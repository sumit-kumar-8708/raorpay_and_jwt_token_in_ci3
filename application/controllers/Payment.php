<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'views/razorpay/Razorpay.php';
use Razorpay\Api\Api;

class Payment extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment_model');
    }

    public function index()
    {       
        $user_details = [
            'name' => 'Sumit',
            'email' => 'Sumit@basix.in',
            'phone' => '8708197431',
            'address' => 'Nangloi,Delhi',            
        ];
        $this->load->view('pay/pay_form', ['user_details' => $user_details]);
    }

    public function checkout()
    {
        $key_id = 'rzp_test_IwxJBeb7jb4IDr';
        $secret = 'ioAoTT3q08Gp7S9Bkti6XAtx';
        $amount = $_POST['prize'];
        // create order
        $api = new Api($key_id,$secret);
        $order = $api->order->create([
            'receipt'         => 'order_rcptid_11',         
            'amount'          => $amount*100,
            'currency'        => 'INR',            
        ]);    

        //insert data with status 0
        $this->payment_model->insert_payment([
            'order_id' => $order['id'],
            'product_id' => 1,
            'amount' => $amount,
            'status' => '0' // Initially set to 0 (Created)
        ]);

        // customer details
        $user_details = [
            'name' => 'Sumit',
            'email' => 'Sumit@basix.in',
            'phone' => '8708197431',
            'address' => 'Nangloi,Delhi',            
        ];
        $data['user_details'] = $user_details;
        $data['key_id'] = $key_id;
        $data['secret'] = $secret;
        $data['order'] = $order;
        $this->load->view('pay/checkout',$data);      
       
    }

    public function paymentStatus()
    {  
        // after payment successful then i have got razorpay_payment_id,razorpay_order_id,razorpay_signature
        $razorpay_payment_id = $_POST['razorpay_payment_id'];
        $razorpay_order_id   = $_POST['razorpay_order_id'];
        $razorpay_signature  = $_POST['razorpay_signature'];

        $secret = 'ioAoTT3q08Gp7S9Bkti6XAtx';

        // $generated_signature = hmac_sha256($razorpay_order_id + "|" + $razorpay_payment_id, $secret);
        //      --------------OR------------------
        $data = $razorpay_order_id . "|" . $razorpay_payment_id;
        $generated_signature = hash_hmac("sha256",$data,$secret);

        if ($generated_signature == $razorpay_signature) {
            $key_id = 'rzp_test_IwxJBeb7jb4IDr';
            $secret = 'ioAoTT3q08Gp7S9Bkti6XAtx';
            $api = new Api($key_id,$secret);
            try {
                $payment = $api->payment->fetch($razorpay_payment_id);
                // Verify the payment details (amount, currency, etc.)
                if ($payment->status == 'captured') {
                    // Update payment status in the database
                    $this->payment_model->update_payment($razorpay_order_id, [                        
                        'payment_id' => $razorpay_payment_id,
                        'signature'  => $razorpay_signature,
                        'status'     => '1' // Payment successful
                    ]);
                    $details_data['payment_details'] = $this->payment_model->get_payment_by_order_id($razorpay_order_id);
                    $this->load->view('pay/success_view', $details_data);
                } else {
                    echo 'payment status: ' . $payment->status; die;
                    echo 'payment is failed'; die;
                }
            } catch (\Exception $e) {
                echo 'error: ' . $e->getMessage(); die;
            }
        } else {
            echo 'payment verification failed'; die;
        }
    }


}
