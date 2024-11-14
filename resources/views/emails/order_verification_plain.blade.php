Hello {{ $order->use->name }},

Thank you for your order with ID: {{ $orderId }}.
Your order total is ${{ $orderTotal }} and it was placed on {{ $orderDate }}.

View your order here: {{ route('orders.show', $orderId) }}

Thank you for shopping with us!
