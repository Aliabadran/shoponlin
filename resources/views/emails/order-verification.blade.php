
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add some styling */
        body { font-family: Arial, sans-serif; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; }
        .header { background-color: #f5f5f5; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #888; }
        .button { display: inline-block; padding: 10px 20px; color: #fff; background-color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Order Verification</h1>
    </div>

    <div class="content">
<h1>Hello, {{ $user->name }}</h1>

<p>Thank you for placing your order! Please verify your order by clicking the link below:</p>

<a href="{{ $url }}" class="button">Verify Order</a>

<p>Order Details:</p>
<ul>
    <li>Thank you for your order with ID:{{ $order->id }}</li>
    <li>Address: {{ $order->address }}</li>
    <li>Total: {{ $order->total }}</li>
    <li>Payment Method: {{ $order->payment_method }}</li>
    <li>Delivery Option:{{ $order->delivery_option }}</li>
    <li>It Was placed on:{{ $order->created_at }}</li>

</ul>
</div>
<div class="footer">
    <p>Thank you for shopping with us!</p>
</div>
</div>
</body>
</html>

