@extends('admin.layout.head')
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    @notifyCss
@section('title') Category Details @endsection
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
                        <h4>Category Details
                               <br>
                         </h4>
                    </div>
                    <div class="card-body">

                                <div class="card" style="width: 23rem;">
                                                <div class="mb-3">
                                                        @if ($category->photo)
                                                        <p><strong>Photo:</strong></p>
                                                        <div class="category-image">
                                                            @if ($category->photo)
                                                            <img src="{{ asset('storage/' . $category->photo) }}" alt="Photo" width="100">
                                                        @endif
                                                        @endif
                                                    </div>
                                <div class="card-body">
                                    <h2 class="card-title"> <p><strong>Name:</strong> {{ $category->name }}</p> </h2>
                                    <p class="card-text">   <div class="mb-3">
                                                        <p><strong>Description:</strong> {{ $category->description }}</p>
                                                        </div></p>
                                    <a href="{{ url('categories') }}" class="btn btn-info float-end">  Back to List</a>
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
</body>
