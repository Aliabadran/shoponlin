

@extends('admin.layout.head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">

@section('title')  Order Details @endsection

<body>
    <div class="container-scroller">
       @include('admin.layout.sidebar')
      <!-- partial:partials/_sidebar.html -->


      <!-- partial:partials/_navbar.html -->
      <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
        <div class="panel-body">
         <div class="content-wrapper">

           @include('admin.layout.header')


            <div class="card mt-3">
                <div class="card-header">
                    <h1 style="color: rgb(218, 29, 161)">
                        Order Details u {{ $order->user->name }}

                    </h1>

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

                    <a href="{{ route('home') }}" class="btn btn-danger float-end">Back</a>
                </div>
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

                @if($order)
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4" >
                            <div class="cart-summary p-3 bg-dark grounded">
                                <h3 class="text-center" >Order Summary</h3>
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


                       </div>
                       <br>
                       <br>


                    <div class="row">
                        <div class="col-lg-8">
                            <h3 >Items Ordered</h3>
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
</div>
</div>
</div>


</body>





<h1>Order #{{ $order->id }}</h1>
<p>Customer: {{ $order->customer_name }}</p>
<p>Total: ${{ $order->total }}</p>
<p>Status: {{ $order->status }}</p>
<!-- More order details... -->
