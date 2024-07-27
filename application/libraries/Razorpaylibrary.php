<?php
require_once APPPATH . 'libraries/razorpay/Razorpay.php';
require_once APPPATH . 'libraries/razorpay/Api.php';

use Razorpay\Api\Api;

class Razorpaylibrary
{
    private $api;

    public function __construct()
    {
        $api_key = 'rzp_test_IwxJBeb7jb4IDr'; // Replace with your Razorpay API key
        $api_secret = 'ioAoTT3q08Gp7S9Bkti6XAtx'; // Replace with your Razorpay API secret
        $this->api = new Api($api_key, $api_secret);
    }

    public function create_order($amount, $receipt)
    {
        return $this->api->order->create([
            'amount' => $amount,
            'currency' => 'INR',
            'receipt' => $receipt,
            'payment_capture' => 1 // Auto capture
        ]);
    }

    public function fetch_payment($payment_id)
    {
        return $this->api->payment->fetch($payment_id);
    }
}
