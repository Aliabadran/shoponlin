
@extends('admin.layout.head')
@section('title') Edit Coupon @endsection
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
                                        <h4 style="color: rgb(29, 79, 218)">Edit Coupon

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


    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="code">Coupon Code</label>
            <input type="text" name="code" class="form-control" value="{{ $coupon->code }}" required>
        </div>

        <div class="form-group">
            <label for="discount_value">Discount Value</label>
            <input type="number" step="0.01" name="discount_value" class="form-control" value="{{ $coupon->discount_value }}" required>
        </div>

        <div class="form-group">
            <label for="discount_type">Discount Type</label>
            <select name="discount_type" class="form-control" required>
                <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                <option value="percent" {{ $coupon->discount_type == 'percent' ? 'selected' : '' }}>Percentage</option>
            </select>
        </div>


        <div class="form-group">
            <label for="applies_to">Applies To</label>
            <select name="applies_to" id="applies_to" class="form-control">
                <option value="cart" {{ $coupon->applies_to == 'cart' ? 'selected' : '' }}>Cart</option>
                <option value="order" {{ $coupon->applies_to == 'order' ? 'selected' : '' }}>Order</option>
                <option value="product" {{ $coupon->applies_to == 'product' ? 'selected' : '' }}>Product</option>
            </select>
        </div>

        <div class="form-group" id="product-selection" style="{{ $coupon->applies_to == 'product' ? '' : 'display:none;' }}">
            <label for="product_id">Product</label>
            <select name="product_id" id="product_id" class="form-control">
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $coupon->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="expires_at">Expiration Date</label>
            <input type="date" name="expires_at" class="form-control" value="{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '' }}">
        </div>

        <button type="submit" class="btn btn-success">Update Coupon</button>
    </form>

    @include('notify::components.notify')
    @notifyJs

       @include('sweetalert::alert')
      @include('admin.layout.footer')
      <script>
        // Show/hide product dropdown based on applies_to value
        document.getElementById('applies_to').addEventListener('change', function() {
            if (this.value === 'product') {
                document.getElementById('product-selection').style.display = 'block';
            } else {
                document.getElementById('product-selection').style.display = 'none';
            }
        });
    </script>
    </body>
