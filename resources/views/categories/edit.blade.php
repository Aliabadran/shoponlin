@extends('admin.layout.head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@notifyCss
@section('title') Edit  Categories @endsection
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
                        <h4>Edit Category
                               <br>
                               <br>
                            <a href="{{ url('categories') }}" class="btn btn-danger float-end">   Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                             @method('PUT')

                            <div class="mb-3">
                              <label for="name">Category Name</label>
                                <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
                            </div>
                             <div class="mb-3">
                                <label for="description">Description</label>
                                <input type="text" name="description" value="{{ $category->description }}" class="form-control" >
                            </div>
                             <div class="mb-3">
                               <label for="photo">Photo</label>
                               <input type="file" class="form-control-file" class= id="photo" name="photo">
                               @if($category->photo)
                               <img src="{{ asset('storage/' . $category->photo) }}" alt="Photo" width="100">
                                @endif
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
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

<script src="{{ asset('vendor/mckenziearts/notify/js/notify.js') }}"></script>
@include('admin.layout.footer')
</body>
