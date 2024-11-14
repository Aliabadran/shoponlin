@extends('admin.layout.head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@notifyCss
@section('title') Orders @endsection

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
                <div style="width: 1000px;">
                    <div class="col-md-12">
                        <!-- Handle Validation Errors -->
                        @if ($errors->any())
                        <ul class="alert alert-warning">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif

                        <!-- Handle Success Messages -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Orders List -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h2 style="color: rgb(173, 29, 218)">All Orders</h2>
                                <a href="{{ route('orders.pdf') }}" target="_blank" class="btn btn-primary">Generate PDF</a>
                            </div>

                            @if($orders->isEmpty())
                                <p>No orders found.</p>
                            @else
                            <div class="card-body">
                                <table class="table table-striped table-hover cart-table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Order ID</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">User Email</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Items</th>
                                            <th scope="col">Actions</th>
                                            <th scope="col">Pdf</th>
                                            <th scope="col">Sent Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                        <tr>
                                            <td class="align-middle">{{ $order->id }}</td>
                                            <td class="align-middle">{{ $order->user->name }}</td>
                                            <td class="align-middle">{{ $order->user->email }}</td>
                                            <td class="align-middle">${{ number_format($order->total, 2) }}</td>
                                            <td class="align-middle">{{ $order->address }}</td>
                                            <td class="align-middle">{{ ucfirst($order->status) }}</td>
                                            <td class="align-middle">
                                                <ul>
                                                    @foreach ($order->orderItems as $item)
                                                        <li>{{ $item->product->name }} - Quantity: ({{ $item->quantity }})</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                            @can('view admin orders')
                                                <!-- Order Actions -->
                                                <a href="{{ route('order.details', $order->id) }}" class="btn btn-sm btn-success mt-1">View Details</a>
                                           @endcan
                                            </td>
                                            <td>
                                            @can('update order status')
                                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="form-select" required>
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-info mt-1 update-status-btn">Update Status</button>
                                                </form>
                                         @endcan
                                            </td>
                                            <td>
                                            @can('generate order pdf')
                                                <a href="{{ route('order.pdf', $order->id) }}" class="btn btn-primary">Download Order PDF</a>
                                                <a href="{{ route('orders.pdf.view', $order->id) }}" class="btn btn-secondary" target="_blank">View Order PDF</a>
                                           @endcan
                                            </td>
                                            <td>
                                            @can('verify order')
                                                <a href="{{ route('order.verification', ['user' => auth()->user()->id, 'order' => $order->id]) }}" class="btn btn-warning">Send Verification Email</a>
                                           @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
       </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert for Updating Order Status -->
    <script>
        document.querySelectorAll('.update-status-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to update the order status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form if confirmed
                    }
                });
            });
        });
    </script>
<x-notify::notify />
@notifyJs
   @include('admin.layout.footer')
</body>
