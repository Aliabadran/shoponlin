


@extends('admin.layout.head')
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    @notifyCss
@section('title') Products for Category @endsection
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
                    <h1>Products for Category: {{ $category->name }}
                    <a href="{{ url('categories') }}" class="btn btn-danger float-end"> Back</a>
                     </h1>
                  </div>



                  @if($category->products->isEmpty())
                  <p>No products found in this category.</p>
                  @else
                  <div class="row">
                      @foreach($category->products as $product)
                          <div class="col-md-4">
                              <div class="card mb-4">
                                @if ($product->photo)
                                <img src="{{ asset('storage/' . $product->photo) }}" class="card-img-top" alt="{{ $product->name }}" width="100">
                            @endif
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

 <x-notify::notify />
        @notifyJs
  @include('admin.layout.footer')
  @include('sweetalert::alert')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
