@extends('admin.layout.head')
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@section('title') Product  Details @endsection
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



<div class="container">
    <h1>Products in {{ $category->name }}</h1>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('categories.products', $category->id) }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="min_price">Min Price</label>
                <input type="number" id="min_price" name="min_price" value="{{ request()->get('min_price', 0) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="max_price">Max Price</label>
                <input type="number" id="max_price" name="max_price" value="{{ request()->get('max_price', 10000) }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="sort_by">Sort By</label>
                <select id="sort_by" name="sort_by" class="form-control">
                    <option value="price" {{ request()->get('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                    <option value="name" {{ request()->get('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="sort_order">Sort Order</label>
                <select id="sort_order" name="sort_order" class="form-control">
                    <option value="asc" {{ request()->get('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request()->get('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Apply Filters</button>
    </form>

    <!-- Products List -->
    @if($products->isEmpty())
        <p>No products found in this category.</p>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text">Price: ${{ $product->price }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Product</a>
                        </div>
                    </div>
                </div>
            @endforeach
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
</div>
@include('admin.layout.footer')
</body>
