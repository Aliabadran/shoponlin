@extends('admin.layout.head')
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    @notifyCss
@section('title') Edit   Advertisement @endsection
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




<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-header">
         <h1>Edit Advertisement</h1>
           <br>
       <a href="{{ url('ads') }}" class="btn btn-danger float-end">   Back</a>
            </div>
    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-body">
    <!-- Form for editing an ad -->
    <form action="{{ route('ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $ad->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="categories" class="form-label">Categories</label>
            <select name="category_ids[]" id="categories" class="form-control" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ isset($ad) && $ad->categories->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $ad->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image_path" class="form-label">Image</label>
            <input type="file" class="form-control" id="image_path" name="image_path">
            @if($ad->image_path)
            <img src="{{ asset('storage/' . $ad->image_path) }}" alt="Photo" width="100">
            @else
            <small>Leave empty if you don't want to change the image.</small>
        @endif
     </div>
     <div class="mb-3">
        <label for="products">Select Products</label>
        <select name="product_ids[]" id="products" class="form-control" multiple>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>
        <div class="mb-3">
            <label for="is_active" class="form-label">Active</label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="1" {{ old('is_active', $ad->is_active) == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('is_active', $ad->is_active) == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Advertisement</button>
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
    <x-notify::notify />
        @notifyJs
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('admin.layout.footer')
</body>
