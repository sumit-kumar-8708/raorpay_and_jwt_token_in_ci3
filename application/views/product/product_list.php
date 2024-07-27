<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php if($this->session->flashdata('success')){ ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php }elseif($this->session->flashdata('error')){ ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

    <h1>Product List</h1>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?= $product->img; ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product->name; ?></h5>
                        <p class="card-text"><b>₹<?= $product->price; ?></b></p>                       
                        <button class="btn btn-primary buy-now" data-id="<?= $product->id; ?>">Buy</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Razorpay Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url('payment/verify'); ?>" method="POST" id="paymentForm">
                        <button id="rzp-button1" class="btn btn-primary">Pay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    $(document).ready(function(){
        $('.buy-now').click(function(){
            var productId = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url('payment/purchase/'); ?>" + productId,
                type: "GET",
                dataType: "json",
                success: function(response){
                    if(response.status === 'success') {
                        var options = {
                            "key": "rzp_test_IwxJBeb7jb4IDr", // Replace with your Razorpay key
                            "amount": response.order.amount,
                            "currency": "INR",
                            "name": response.product.name,
                            "description": "Test Transaction",
                            "order_id": response.order.id,
                            "handler": function (response){
                                $('#paymentForm').append('<input type="hidden" name="razorpay_payment_id" value="' + response.razorpay_payment_id + '">');
                                $('#paymentForm').append('<input type="hidden" name="razorpay_order_id" value="' + response.razorpay_order_id + '">');
                                $('#paymentForm').append('<input type="hidden" name="razorpay_signature" value="' + response.razorpay_signature + '">');
                                $('#paymentForm').submit();
                            },
                            "prefill": {
                                "name": "Amit kumar",
                                "email": "amit@gmial.com"
                            }
                        };

                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    });
    </script>
</body>
</html>
