
    <div class="container">
        <h1>{{ $notification->title }}</h1>
        <p>{{ $notification->message }}</p>
        <a href="{{ $notification->url }}" target="_blank">View More</a>
    </div>

    @extends('admin.layout.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
       @notifyCss
   @section('title') notifications Offer Details @endsection
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
                           <h2 style="color: rgb(29, 133, 218)">Notifications Offer Details
                                  <br>
                            </h2>
                       </div>
                       <div class="card-body">

                                   <div class="card" style="width: 28rem;">


                                   <div class="card-body">
                                       <h1 class="card-title"> <h1><strong style="color: rgb(117, 29, 218)">Name:</strong>   <h3>{{ $notification->title }}</h3>  </h1></h1>
                                       <h2 class="card-text">   <div class="mb-3">
                                                           <h2><strong style="color: rgb(196, 29, 218)">Description:</strong>
                                                            <br><h4>{{ $notification->message }}</h4></h2>
                                                           </div></h2>

                                                           <h1 class="card-text">
                                      <a href="{{ $notification->url }}" target="_blank"    class="btn btn-success ">View More</a>
                                       <a href="{{ url('notificationsOffer') }}" class="btn btn-info float-end">  Back to List</a>
                                                           </h1> </div>
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
