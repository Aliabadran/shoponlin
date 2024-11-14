

@extends('admin.layout.head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

@notifyCss
@section('title') Blog @endsection

<body>
    <div class="container-scroller">
       @include('admin.layout.sidebar')
      <!-- partial:partials/_sidebar.html -->


      <!-- partial:partials/_navbar.html -->
      <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
        <div class="panel-body">
         <div class="content-wrapper">

           @include('admin.layout.header')

           <div class="scrollable-container"  >
            <div class="wide-content" >
                <div style="width: 1000px;" style="color: rgb(29, 73, 218)"> <!-- Example wide content -->
                    <!-- Your wide content goes here -->


           <div class="col-md-12">

            <div class="card mt-3">
                <div class="card-header">
                    <h2 style="color: rgb(173, 29, 218)">
                        Add New Blog Post

                    </h2>

                </div>
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
            <ul class="alert alert-warning">
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
            @endif
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif



    <div class="container">
       <div class="row">
          <div class="col-lg-8 offset-lg-2">
             <div class="full">
                <form action="{{ route('blog.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Enter blog title" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" class="form-control" id="content" rows="10" placeholder="Enter blog content" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Blog Post</button>
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
        </div>
        </div>
      </div>
    </div>
    <x-notify::notify />
    @notifyJs

    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
