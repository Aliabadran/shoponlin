@extends('home.layout.head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@notifyCss
@section('title') Orders @endsection
<body>
@include('home.layout.header')

<section class="inner_page_head">
   <div class="container_fuild">
      <div class="row">
         <div class="col-md-12">
            <div class="full">
               <h3>Your Orders</h3>
            </div>
         </div>
      </div>
   </div>
</section>

<br>

<div class="container">
    <div class="scrollable-container">
        <div class="col-md-12">
            @if ($errors->any())
                <ul class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="card mt-3">
                <div class="card-header">
                    <h2 style="color: rgb(173, 29, 218)">All Orders</h2>
                    <a href="{{ url('/') }}" class="btn btn-danger float-end">Back</a>
                </div>

                @if($orders->isEmpty())
                    <p>No orders found.</p>
                @else
                    <div class="card-body">
                        <table class="table table-striped table-hover cart-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Total Items</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="align-middle">{{ $order->id }}</td>
                                        <td class="align-middle">${{ number_format($order->total, 2) }}</td>
                                        <td class="align-middle">{{ $order->items->count() }}</td>
                                        <td class="align-middle">{{ $order->address }}</td>
                                        <td class="align-middle">{{ ucfirst($order->status) }}</td>
                                        <td>
                                            <div>
                                               @can('cancel order')
                                                @if($order->status == 'pending')

                                                <form id="cancelForm-{{ $order->id }}" action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="button" class="btn btn-danger cancelOrderButton" data-id="{{ $order->id }}">Cancel Order</button>
                                                </form>
                                                @else
                                                    <span class="text-muted">No actions available</span>
                                                @endif
                                                       @endcan
                                            </div>
                                            <div>
                                               @can('view user orders')
                                                <a href="{{ route('order.detaill', $order->id) }}" class="btn btn-sm btn-success mt-1">View Details</a>
                                                  @endcan
                                            </div>
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

@include('home.layout.footerPage')
@include('notify::components.notify')
@notifyJs

<!-- SweetAlert Include -->
@include('sweetalert::alert')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.cancelOrderButton').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent immediate form submission

            const orderId = this.getAttribute('data-id');
            const formId = `cancelForm-${orderId}`;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, keep it',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    document.getElementById(formId).submit();
                }
            });
        });
    });
</script>
</body>
