

@extends('admin.layout.head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

@notifyCss
@section('title')  Search @endsection


<style>
    /* Your CSS */
    body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    background-color: white;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

.result-section {
    margin-bottom: 40px;
}

.result-section h3 {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.result-item {
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.result-item:last-child {
    border-bottom: none;
}

.result-item p {
    margin: 0;
    color: #555;
    line-height: 1.6;
}

button.toggle {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    margin-top: 10px;
    border-radius: 5px;
}

button.toggle:hover {
    background-color: #0056b3;
}

.hidden {
    display: none;
}

</style>

<script>
    function toggleVisibility(sectionId) {
        const section = document.getElementById(sectionId);
        section.classList.toggle('hidden');
    }
</script>


<body>

    <div class="container-scroller">
        @include('admin.layout.sidebar')

        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
            <div class="panel-body">
             <div class="content-wrapper">

               @include('admin.layout.header')

               <div class="scrollable-container"  >
                <div class="wide-content" >
                    <div style="width: 1000px;" style="color: rgb(29, 73, 218)"> <!-- Example wide content -->


@if(isset($message))
    <p>{{ $message }}</p>
@endif
<div class="container">
    <h1>Search Results</h1>

    <section id="users">
        <h3>Users</h3>
        @foreach($users as $user)
            <div class="result-item">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
            </div>
        @endforeach
        <button class="toggle" onclick="toggleVisibility('users')">Toggle Users</button>
    </section>

    <section id="products">
        <h3>Products</h3>
        @foreach($products as $product)
            <div class="result-item">
                <p><strong>Name:</strong> {{ $product->name }}</p>
                <p><strong>Description:</strong> {{ $product->description }}</p>
            </div>
        @endforeach
        <button class="toggle" onclick="toggleVisibility('products')">Toggle Products</button>
    </section>

    <section id="orders">
        <h3>Orders</h3>
        @foreach($orders as $order)
            <div class="result-item">
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            </div>
        @endforeach
        <button class="toggle" onclick="toggleVisibility('orders')">Toggle Orders</button>
    </section>

    <section id="categories">
        <h3>Categories</h3>
        @foreach($categories as $category)
            <div class="result-item">
                <p><strong>Name:</strong> {{ $category->name }}</p>
            </div>
        @endforeach
        <button class="toggle" onclick="toggleVisibility('categories')">Toggle Categories</button>
    </section>
</div>
</div>
                </div></div>
             </div>
            </div>
            </div>
        </div>
    </div>
</body>




