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
            <p>Hello {{ $order->user_name }},</p>
            <p>Thank you for your order with ID: {{ $orderId }}.</p>
            <p>Your order total is ${{ $orderTotal }} and it was placed on {{ $orderDate }}.</p>
            <p>
                <a href="{{ route('orders.show', $orderId) }}" class="button">View Your Order</a>
            </p>
        </div>

        <div class="footer">
            <p>Thank you for shopping with us!</p>
        </div>
    </div>
</body>
</html>




Here’s an example of how you might send the email after order creation:

php
Copy code
use App\Mail\OrderVerificationMail;
use Illuminate\Support\Facades\Mail;

public function sendOrderVerification(Order $order)
{
    // Send the email
    Mail::to($order->customer_email)->send(new OrderVerificationMail($order));
}
