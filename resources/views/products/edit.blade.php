@extends('admin.layout.head')
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@section('title') Edit Product @endsection
@notifyCss
<body>
 <div class="container-scroller">
   @include('admin.layout.sidebar')
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
                        <h4>Edit Product
                               <br>
                               <br>
                            <a href="{{ url('products') }}" class="btn btn-danger float-end">   Back  </a>
                        </h4>
                    </div>
                    <div class="card-body"></div>
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                             @method('PUT')

                            <div class="mb-3">
                              <label for="name">Product Name</label>
                                <input type="text" name="name" value="{{ old('description', $product->description) }}" class="form-control" required/>
                                  @error('name')
                                <p>{{ $message }}</p>
                                  @enderror
                            </div>
                             <div class="mb-3">
                                <label for="description">Description</label>
                                <input type="text" name="description" value="{{ $product->description }}" class="form-control" />
                               @error('description')
                               <p>{{ $message }}</p>
                                 @enderror
                            </div>
                                <div class="mb-3">
                                 <label for="price">Price:</label>
                                  <input type="number" id="price" name="price"  step="0.01" class="form-control"   value="{{ old('price', $product->price) }}" required/>
                                      @error('price')
                                     <p>{{ $message }}</p>
                                       @enderror
                                      </div>
                                         <div class="mb-3">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" id="quantity" name="quantity"  class="form-control" value=" {{ old('quantity', $product->quantity) }}" required />
                                      @error('quantity')
                                       <p>{{ $message }}</p>
                                       @enderror
                                      </div>
                                       <div class="mb-3">
                                        <label for="category_id">Category</label>
                                          <select name="category_id" id="category_id"  class="form-control" required>
                                            @foreach ($categories as $category)
                                              <option value="{{ $category->id }}"   {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                                    </option>
                                                 @endforeach
                                                </select>
                                               @error('category_id')
                                                  <p>{{ $message }}</p>
                                               @enderror
                                            </div>
                                               <div class="mb-3">
                                            <label for="discount">Discount (%)</label>
                                            <input type="number" id="discount" name="discount" step="0.01" class="form-control"  value="{{ old('quantity', $product->quantity) }}"  required />
                                                @error('discount')
                                                <p>{{ $message }}</p>
                                                @enderror
                                            </div>
                                                <div class="mb-3">
                                        <label for="photo">Photo</label>
                                            <input type="file" id="photo" name="photo" class="form-control"  />
                                            @if($product->photo)
                                            <img src="{{ asset('storage/' . $product->photo) }}" alt="Photo" width="100">
                                             @endif
                                            @error('photo')
                                        <p>{{ $message }}</p>
                                            @enderror
                                        </div>
                                         <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Update Product</button>
                                     </div>
                                 </form>
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
<!-- SweetAlert -->
@include('sweetalert::alert')
@include('notify::components.notify')
@notifyJs
@include('admin.layout.footer')
</body>





