
@extends('admin.layout.head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@notifyCss
@section('title') Edit  notifications Offer @endsection
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
                        <h2 style="color: rgb(29, 218, 101)">Edit notifications Offer
                               <br>
                               <br>
                            <a href="{{ url('notificationsOffer') }}" class="btn btn-danger float-end">   Back</a>
                        </h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('notificationsOffer.update', ['notificationsOffer' => $notificationsOffer->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $notificationsOffer->title }}" required>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="message" class="form-control" required>{{ $notificationsOffer->message }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>URL</label>
                                <input type="text" name="url" class="form-control" value="{{ $notificationsOffer->url }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
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
