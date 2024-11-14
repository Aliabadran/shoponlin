<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <label for="total">Order Total:</label>
    <input type="text" name="total" id="total" required>

    <!-- Add other form inputs as needed -->

    <button type="submit">Place Order</button>
</form>




/ routes/web.php

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');




// Validate the incoming request data
$validatedData = $request->validate([
    'user_id' => 'required|exists:users,id',
    'product_id' => 'required|exists:products,id',
    'quantity' => 'required|integer|min:1',
    'total' => 'required|numeric',
]);

// Create a new order in the database
$order = Order::create([
    'user_id' => $validatedData['user_id'],
    'product_id' => $validatedData['product_id'],
    'quantity' => $validatedData['quantity'],
    'total' => $validatedData['total'],
]);

// Return a response, like redirecting to a success page
return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
}
