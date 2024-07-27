<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5 text-success">Payment Successful</h1>        

        <h3 class="mt-4">Payment Details</h3>
        <table class="table table-bordered mt-3">
            <tr>
                <th>Order ID</th>
                <td><?= $payment_details->order_id; ?></td>
            </tr>
            <tr>
                <th>Payment ID</th>
                <td><?= $payment_details->payment_id; ?></td>
            </tr>
            <tr>
                <th>Product Name</th>
                <td>Dummy product</td>
            </tr>
            <tr>
                <th>Amount</th>
                <td><?= $payment_details->amount; ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td class="<?= $payment_details->status == '1' ? 'text-success' : 'text-danger'; ?>"><?= $payment_details->status == '1' ? 'Paid' : 'Failed'; ; ?></td>
            </tr>
        </table>
        <a href="<?= base_url('payment'); ?>" class="btn btn-primary">Go Back</a>
    </div>
</body>
</html>
