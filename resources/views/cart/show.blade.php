@extends('home.layout.head')

<!-- External Styles -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@notifyCss
@section('title')Cart @endsection

<body>
    @include('home.layout.header')
    @include('sweetalert::alert')

    <!-- Page Heading -->
    <section class="inner_page_head">
        <div class="container_fuild">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <h3>Your Shopping Cart</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alert Section for Errors/Status -->
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

    <div class="container">
        <br><br>
        <a href="{{ url('/') }}" class="btn btn-danger float-end">Back</a>
        <br><br>

        @if ($cartItems->isEmpty())
            <div class="text-center">
                <p>Your cart is empty.</p>
                <a href="{{ url('/') }}" class="btn btn-primary">Shop Now</a>
            </div>
        @else
            <div class="container">
                <div class="row">
                    <!-- Cart Table -->
                    <div class="col-lg-8">
                        <table class="table table-striped table-hover cart-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>id</th>
                                    <th>Product Image</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>


                                        <td class="align-middle">{{ $item->id }}</td>
                                        <td class="align-middle">
                                            <img src="{{ asset('storage/' . $item->product->photo) }}" alt="Photo" width="100">
                                        </td>
                                        <td class="align-middle">{{ $item->product->name }}</td>
                                        <td class="align-middle">
                                            update cart
                                            @can('update cart')
                                            <form method="POST" action="{{ route('cart.update', $item->id) }}">
                                                @csrf
                                                @method('put')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" step="1" required>
                                                <button type="submit" class="btn btn-sm btn-info mt-1">Update</button>
                                            </form>
                                            @endcan

                                        </td>
                                        <td class="align-middle">
                                            ${{ number_format($item->product->discount > 0 ? $item->product->priceAfterDiscount() : $item->product->price, 2) }}
                                        </td>
                                        <td class="align-middle">${{ number_format($item->price, 2) }}</td>
                                        <td class="align-middle">
                                            <!-- Make the form ID and button ID unique using the item's ID -->
                                            @can('remove from carts')
                                            <form id="deleteForm-{{ $item->id }}" action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger deleteButton" data-id="{{ $item->id }}">Remove</button>
                                            </form>
                                            @endcan

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4">
                        <div class="cart-summary p-3 bg-light rounded">
                            <h4 class="text-center">Cart Summary</h4>
                            <hr>

                                <div class="d-flex justify-content-between">
                                    <span>Total Items</span>
                                    <span>{{ count($cartItems) }}</span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span>Total Price</span>
                                    <span>${{ number_format($totalPrice, 2) }}</span>
                                </div>

                                <!-- Coupon Form -->
                                <form action="{{ route('apply.coupon') }}" method="POST" class="mb-3">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Coupon Code" required>
                                        <button type="submit" class="btn btn-primary">Apply Coupon</button>
                                    </div>
                                </form>
                               @can('apply coupon')
                                <!-- Display Discount Information -->
                                @if (session('coupon'))
                                    <p class="text-success">Coupon Applied: <strong>{{ session('coupon')['code'] }}</strong></p>
                                    <p class="text-success">Discount:
                                        @if(session('coupon')['discount_type'] === 'fixed')
                                            ${{ session('coupon')['discount_value'] }}
                                        @else
                                            {{ session('coupon')['discount_value'] }}%
                                        @endif
                                    </p>

                                    <hr>

                                    <div class="d-flex justify-content-between">
                                        <span>Coupon Discount:</span>
                                        <span>
                                            @if(session('coupon')['discount_type'] === 'fixed')
                                                ${{ number_format(session('coupon')['discount_value'], 2) }}
                                            @else
                                                ${{ number_format($totalPrice * (session('coupon')['discount_value'] / 100), 2) }}
                                            @endif
                                        </span>
                                    </div>


                                        <div class="d-flex justify-content-between">
                                            <strong>Total Price (After Discount):</strong>
                                            <strong>${{ number_format($discountedTotal, 2) }}</strong>


                                    </div>
                                @else
                                    <div class="d-flex justify-content-between">
                                        <strong>Total Price:</strong>
                                        <strong>${{ number_format($totalPrice, 2) }}</strong>
                                    </div>
                                @endif
                                @endcan
                                @if (session()->has('coupon') && session('coupon')['applied'])
                                    <div class="alert alert-warning mt-2">
                                        A coupon is currently applied. Please proceed to checkout before adding new items to the cart.
                                    </div>
                                @endif

                                <br>

                            <a  class="btn btn-success btn-block">Proceed to Checkout</a>
                            <br>

                            @can('checkout order')
                            <!-- Shipping and Payment Form -->
                            <h2>Shipping Information</h2>
                            <form   id="checkoutForm"  method="POST" action="{{ route('checkout.confirm') }}">
                                @csrf
                            <!-- Coupon Code Field -->
                            <div class="form-group">
                                <label for="coupon_code">Coupon Code:</label>
                                <input type="text" id="coupon_code" name="coupon_code" placeholder="Enter coupon code">
                            </div>
                                <div class="form-group">
                                    <label for="address">Shipping Address:</label>
                                    <input type="text" id="address" name="address" placeholder="Enter your address" required>
                                </div>
                                <br>
                                <!-- Payment Method -->
                                <div class="form-group">
                                    <h3>Payment Method</h3>
                                    <div>
                                        <input type="radio" id="credit_card" name="payment_method" value="credit_card" required>
                                        <label for="credit_card">Credit Card</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="cash_on_delivery" name="payment_method" value="cash_on_delivery" required>
                                        <label for="cash_on_delivery">Cash on Delivery</label>
                                    </div>
                                </div>
                                <br>
                                <!-- Credit Card Info (Show only if selected) -->
                                <div id="credit-card-info" style="display:none;">
                                    <h3>Credit Card Information</h3>
                                    <div class="form-group">
                                        <label for="card_number">Card Number:</label>
                                        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9101 1121">
                                    </div>
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date:</label>
                                        <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV:</label>
                                        <input type="text" id="cvv" name="cvv" placeholder="123">
                                    </div>
                                </div>
                                <!-- Delivery Option -->
                                <h3>Delivery Option</h3>
                                <div>
                                    <input type="radio" id="home_delivery" name="delivery_option" value="home_delivery" required>
                                    <label for="home_delivery">Home Delivery</label>
                                </div>
                                <div>
                                    <input type="radio" id="pickup" name="delivery_option" value="pickup" required>
                                    <label for="pickup">Pickup from Store</label>
                                </div>
                                <br>

                                <!-- Confirm Order Button with SweetAlert -->
                                <button type="button" class="btn btn-success btn-block" id="confirmOrderBtn">Confirm Order</button>
                                </form>
                                @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <br><br>
    </div>
    <x-notify::notify />
    @notifyJs
    @include('home.layout.footerPage')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const itemId = this.getAttribute('data-id'); // Get the item ID from the button's data attribute
                const deleteFormId = `deleteForm-${itemId}`; // Construct the form ID dynamically

                // First prompt asking user to type "DELETE"
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Type DELETE to confirm.',
                    input: 'text',
                    inputPlaceholder: 'Type DELETE',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    // If the user types DELETE correctly
                    if (result.isConfirmed && result.value === 'DELETE') {

                        // Show second prompt for final confirmation
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'Do you really want to delete this item?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, keep it'
                        }).then((finalResult) => {
                            // If the user confirms the second prompt, proceed with the deletion
                            if (finalResult.isConfirmed) {
                                document.getElementById(deleteFormId).submit(); // Submit the unique form
                            } else {
                                Swal.fire('Cancelled', 'Your item is safe :)', 'error');
                            }
                        });
                    } else {
                        // If the user cancels or doesn't type DELETE, show cancellation alert
                        Swal.fire('Cancelled', 'Your item is safe :)', 'error');
                    }
                });
            });
        });
    </script>
<script>
    document.getElementById('confirmOrderBtn').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent the default behavior of the button

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to confirm your order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, confirm it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                // Get the form element and submit it
                const form = document.getElementById('checkoutForm');
                if (form) {
                    form.submit();
                } else {
                    console.error('Form not found');
                }
            }
        });
    });
</script>
<script>
    // Function to show/hide credit card information based on selected payment method
    document.querySelectorAll('input[name="payment_method"]').forEach((input) => {
        input.addEventListener('change', function () {
            if (this.value === 'credit_card') {
                document.getElementById('credit-card-info').style.display = 'block';
            } else {
                document.getElementById('credit-card-info').style.display = 'none';
            }
        });
    });
</script>

    <!-- JS for toggling credit card info -->
    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach((input) => {
            input.addEventListener('change', function () {
                if (this.value === 'credit_card') {
                    document.getElementById('credit-card-info').style.display = 'block';
                } else {
                    document.getElementById('credit-card-info').style.display = 'none';
                }
            });
        });
    </script>
@include('sweetalert::alert')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
