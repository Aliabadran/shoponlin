
@extends('admin.layout.head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
         @notifyCss
    <!-- Custom CSS -->

    @section('title')Coupons @endsection

<body>

    <div class="container-scroller">
        @include('admin.layout.sidebar')
        @include('sweetalert::alert')

        <div class="container-fluid page-body-wrapper">
         <div class="main-panel">
         <div class="panel-body">
          <div class="content-wrapper">

            @include('admin.layout.header')

            <div class="scrollable-container">
             <div class="wide-content">


    <div class="container mt-5">
        <div class="card-header">
            <h2  style="color: rgb(29, 79, 218)">Coupons
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary float-end">Create New Coupon</a>
            </h2>
        </div>




    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
</div>
<div class="card-body">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Discount</th>
                <th>Type</th>
                <th>Applies To</th>
                <th>Product</th>
                <th>Expires At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->id }}</td>
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->discount_value }}</td>
                    <td>{{ ucfirst($coupon->discount_type) }}</td>
                    <td>{{ ucfirst($coupon->applies_to) }}</td>
                    <td>{{ $coupon->product ? $coupon->product->name : 'N/A' }}</td>
                    <td>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : 'No Expiration' }}</td>
                    <td>
                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-warning">Edit</a>

                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this coupon?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach


        </tbody>

    </table>

    </div>

             </div>
             </div>
            </div>
          </div>
         </div>
         </div>
        </div>
    </div>

    @include('sweetalert::alert')
    <x-notify::notify />
    @notifyJs
    @include('admin.layout.footer')
    </body>
