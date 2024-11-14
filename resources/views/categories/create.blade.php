@extends('admin.layout.head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@notifyCss
@section('title') Create Categories @endsection

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
                                        <h4>Create Category
                                            <a href="{{ url('categories') }}" class="btn btn-danger float-end  ">Back</a>
                                        </h4>

                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="mb-3">
                                              <label for="">Categories Name</label>
                                              <input type="text" id="name" name="name" class="form-control" required />
                                            </div>
                                             <div class="mb-3">
                                              <label for="description">Description:</label>
                                              <input type="text" id="description" name="description" class="form-control" required />
                                            </div>
                                             <div class="mb-3">
                                              <label for="photo" >Photo:</label>
                                              <input type="file" name="photo"  class="form-control" required />
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">Save</button>
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
<script src="{{ asset('vendor/mckenziearts/notify/js/notify.js') }}"></script>
</body>
