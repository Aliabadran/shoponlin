@extends('home.layout.head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@notifyCss

@section('title')Order @endsection
<body>
@include('home.layout.header')
<section class="inner_page_head">
   <div class="container_fuild">
      <div class="row">
         <div class="col-md-12">
            <div class="full">
               <h3>Order Successful</h3>
            </div>
         </div>
      </div>
   </div>
</section>


@if ($errors->any())
<ul class="alert alert-warning">
    @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ul>
@endif
@if (session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif
<br>
<div class="container">
<h1  style="color:rgb(14, 109, 61)">Thank you for your order! Below are your order details:</h1>
<a href="{{ url('/') }}" class="btn btn-danger float-end">   Back</a>
</div>
@if ($errors->any())
<ul class="alert alert-warning">
    @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ul>
@endif
@if (session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif
<br>
<br>
<div class="container">


    <div class="row">
        <div class="col-lg-8">
            <h3 style="color:rgb(96, 120, 226)">Items Ordered</h3>
            <table class="table table-striped table-hover cart-table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col"> id</th>
                        <th scope="col"> Product Image</th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                    <tr>
                        <td class="align-middle">
                            <div class="cart-id">
                                <span>{{ $item->id }}</span>
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

                    <!-- Remove Item from Cart -->
                    <form action="" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
       </table>
        </div>

        <div class="col-lg-4">
            <div class="cart-summary p-3 bg-light rounded">
                <h3 class="text-center">Order Summary</h3>
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
                <div class="d-flex justify-content-between">
                    @if(session('coupon'))
                    <p>Coupon Applied: {{ session('coupon')['code'] }}</p>
                    <p>Discount: ${{ session('coupon')['discount_value'] }}</p>
                    <p>Discounted Total: ${{ number_format(session('coupon')['discounted_total'], 2) }}</p>
                @else
                    <p>Total Price: ${{ number_format($order->total, 2) }}</p>
                @endif
                </div>
                  <!-- Coupon Details -->
        @if($order->coupon)
        <div class="d-flex justify-content-between">
            <span>Coupon Applied:</span>
            <span>{{ $order->coupon->code }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Discount:</span>
            <span>${{ number_format($order->coupon->discount_value, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <strong>Total (After Discount):</strong>
            <strong>${{ number_format($order->total, 2) }}</strong>
        </div>
    @else
        <div class="d-flex justify-content-between">
            <strong>Total Price:</strong>
            <strong>${{ number_format($order->total, 2) }}</strong>
        </div>
    @endif
    <hr>
                <hr>

            </div>
        </div>



    </div>
</div>




</div>

<x-notify::notify />
        @notifyJs
@include('sweetalert::alert')
@include('home.layout.footerPage')
</body>

