
@extends('home.layout.head')
@notifyCss
@section('title')  Order Details @endsection
<body>
@include('home.layout.header')
<section class="inner_page_head">
   <div class="container_fuild">
      <div class="row">
         <div class="col-md-12">
            <div class="full">
               <h3>Your Order Details</h3>
            </div>
         </div>
      </div>
   </div>
</section>
@include('sweetalert::alert')
<br>
<br>

           <div class="col-md-12">
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

            <div class="card mt-3">
                <div class="card-header">
                    <h1 style="color: rgb(29, 174, 218)">
                        Order Details

                    </h1>

                    <a href="{{ route('orders.index') }}" class="btn btn-danger float-end">Back</a>
                </div>
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

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
                @endif

    </div>
            </div>
           </div>

           @include('notify::components.notify')
           @notifyJs
          

                @include('home.layout.footerPage')

</body>
