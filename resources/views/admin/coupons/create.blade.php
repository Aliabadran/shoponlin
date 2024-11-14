
@extends('admin.layout.head')
@section('title') Create Coupon @endsection
@notifyCss

  <body>

        <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.layout.sidebar')

      <!-- partial:partials/_navbar.html -->
        <div class="container-fluid page-body-wrapper">
           <div class="main-panel">
           <div class="panel-body">
            <div class="content-wrapper">

              @include('admin.layout.header')


                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-12">

                                @if ($errors->any())
                                <ul class="alert alert-warning">
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                                @endif

                                <div class="card">
                                    <div class="card-header">
                                        <h4 style="color: rgb(29, 79, 218)">Create Coupon

                                        </h4>
                                    </div>
                                    <div class="card-body">


                                @if ($errors->any())
                                    <ul class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif

    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="code">Coupon Code</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="discount_value">Discount Value</label>
            <input type="number" step="0.01" name="discount_value" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="discount_type">Discount Type</label>
            <select name="discount_type" class="form-control" required>
                <option value="fixed">Fixed</option>
                <option value="percent">Percentage</option>
            </select>
        </div>

        <div class="form-group">
            <label for="applies_to">Applies To</label>
            <select name="applies_to" class="form-control" required>
                <option value="cart">Cart</option>
                <option value="product">Product</option>
                <option value="order">Order</option>
            </select>
        </div>

        <div class="form-group">
            <label for="product_id">Product (if applicable)</label>
            <select name="product_id" class="form-control">
                <option value="">None</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="expires_at">Expiration Date</label>
            <input type="date" name="expires_at" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Create Coupon</button>
    </form>

    @include('notify::components.notify')
    @notifyJs

                @include('sweetalert::alert')
      @include('admin.layout.footer')
    </body>
