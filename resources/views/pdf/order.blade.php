<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order PDF</title>
    <style>
        /* Add any necessary styling for your PDF here */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }

    </style>
</head>
<body>
    <h1>Order #{{ $order->id }}</h1>
    <p>Customer: {{ $order->user }}</p>
    <p>Date: {{ $order->created_at->format('Y-m-d') }}</p>
    @if($order)
    <div class="container">
        <div class="row">
            <div class="col-lg-4" style="color:rgb(96, 222, 226)">
                <div class="cart-summary p-3 bg-dark grounded">
                    <h3 class="text-center" style="color:rgb(174, 96, 226)">Order Summary</h3>
                    <hr>
                    <div class="d-flex justify-content-between">

                        <span>Order ID:</span> <span> {{ $order->id }}</span>

                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Total Price</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Shipping Address:</span>
                        <span> {{ $order->address }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Payment Method:</span>
                        <span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Delivery Option:</span>
                        <span> {{ ucfirst(str_replace('_', ' ', $order->delivery_option)) }}</span>
                    </div>
                    <hr>
                </div>
            </div>
            <br>

            <div class="col-lg-4" >
                <div class="cart-summary p-3 bg-dark rounded">
                    <h2 class="text-center" style="color:rgb(65, 187, 75)">User Information</h2>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Name:</span> <span> {{ $order->user->name }}</span>

                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Email:</span>
                        <span> {{ $order->user->email }}</span>
                    </div>
                    <hr>
                </div>
            </div>

           </div>
           <br>
           <br>


        <div class="row">
            <div class="col-lg-8">
                <h3 style="color:rgb(96, 120, 226)">Items Ordered</h3>
                <table class="table table-striped table-hover cart-table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"> id</th>
                            <th scope="col"> Product Image</th>
                            <th scope="col">Product  </th>
                            <th scope="col">Quantity </th>
                            <th scope="col">Price </th>
                            <th scope="col">Total</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                        <tr>
                            <td class="align-middle">
                                <div class="cart-id">
                                    <span>#</span>
                                </div>
                                <td class="align-middle">
                                    <div class="cart-product-image">
                                            <img src="{{ asset('storage/' . $item->product->photo) }}" alt="Photo" width="100">
                                    </div>
                            <td class="align-middle">
                                <div class="cart-product-name">
                                     <span>{{ $item->product->name }}</span>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="cart-quantity">
                                     <span>{{ $item->quantity }}</span>
                                </div>
                            </td>
                            @if(number_format($item->product->discount, 2)!= 0.00)
                            <td class="align-middle">${{ number_format($item->product->priceAfterDiscount(), 2) }}</td>
                             @else
                                <td class="align-middle">${{ number_format($item->product->price, 2) }}</td>
                            @endif

                    <td class="align-middle">${{ number_format($item->price, 2) }}</td>
                    <td class="align-middle">


                    </td>
                </tr>
                @endforeach
            </tbody>
           </table>
            </div>


        </div>
    </div>

    @else
        <p>Order not found.</p>
    @endif</body>
</html>
