@extends('admin.layout.head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@notifyCss
@section('title')Products @endsection

<body>
    <div class="container-scroller">
      @include('admin.layout.sidebar')
      <!-- SweetAlert -->
      @include('sweetalert::alert')

      <!-- partial:partials/_navbar.html -->
      <div class="container-fluid page-body-wrapper">
           <div class="main-panel">
           <div class="panel-body">
            <div class="content-wrapper">
              @include('admin.layout.header')

              <div class="container mt-2">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="scrollable-container">
                              <div class="wide-content">
                                  <div style="width: 1000px;">
                                      <br>
                                      <br>

                                      @if (session('status'))
                                          <div class="alert alert-success">{{ session('status') }}</div>
                                      @endif

                                      <br>
                                      <br>
                                      @can('view products')
                                      <form action="{{ route('products.search') }}" method="GET">
                                          <input type="text" name="query" placeholder="Search categories..." value="{{ isset($query) ? $query : ' ' }}" required>
                                          <button type="submit" class="btn btn-success">Search</button>
                                      </form>
                                      @endcan
                                      <a href="{{ url('products') }}" class="btn btn-danger float-end">Back</a>
                                      <br>

                                      <div class="card mt-3">
                                          <div class="card-header">
                                              <h4>
                                                  <p class="h1">Products</p>
                                                  <br>
                                                  <br>
                                                  @can('create products')
                                                  <a href="{{ route('products.create') }}" class="btn btn-primary float-end me-md-2">Create New Product</a>
                                                  @endcan
                                                </h4>
                                          </div>

                                          @if (session('success'))
                                              <p>{{ session('success') }}</p>
                                          @endif

                                          <div class="card-body">
                                              <table class="table table-bordered table-striped">
                                                  <thead>
                                                      <tr>
                                                          <th>Id</th>
                                                          <th>Name</th>
                                                          <th>Description</th>
                                                          <th>Price</th>
                                                          <th>Discount</th>
                                                          <th>Quantity</th>
                                                          <th>Category</th>
                                                          <th>Photo</th>
                                                          <th width="40%">Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      @foreach ($products as $product)
                                                          <tr>
                                                              <td>{{ $product->id }}</td>
                                                              <td>{{ $product->name }}</td>
                                                              <td>{{ $product->description }}</td>
                                                              <td>${{ number_format($product->price, 0) }}</td>
                                                              <td>{{ number_format($product->discount, 0) }}%</td>
                                                              <td>{{ $product->quantity }}</td>
                                                              <td>{{ $product->category->name }}</td>
                                                              <td>
                                                                  @if ($product->photo)
                                                                      <img src="{{ asset('storage/' . $product->photo) }}" alt="Photo" width="100">
                                                                  @endif
                                                              </td>
                                                              <td>
                                                                @can('view products')
                                                                  <a href="{{ route('products.show', $product->id) }}" class="btn btn-success">View</a>
                                                                  @endcan
                                                                  @can('update products')
                                                                  <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info">Edit</a>
                                                                  @endcan
                                                                  @can('delete products')
                                                                  <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                                      @csrf
                                                                      @method('DELETE')
                                                                      <button type="button" class="btn btn-danger delete-btn" data-id="{{ $product->id }}">Delete</button>
                                                                  </form>
                                                                  @endcan
                                                                  <a href="{{ route('products.categories', $product->id) }}" class="btn btn-primary">Category</a>
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
        </div>
      </div>
   </div>

   @include('admin.layout.footer')
   @include('notify::components.notify')
   @notifyJs
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <script>
       document.querySelectorAll('.delete-btn').forEach(button => {
           button.addEventListener('click', function (e) {
               e.preventDefault();

               const productId = this.getAttribute('data-id');
               const formId = `delete-form-${productId}`;

               Swal.fire({
                   title: 'Are you sure?',
                   text: 'This action cannot be undone.',
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Yes, delete it!'
               }).then((result) => {
                   if (result.isConfirmed) {
                       document.getElementById(formId).submit();
                   }
               });
           });
       });
   </script>
</body>
