

@extends('admin.layout.head')
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    @notifyCss
@section('title')Offer Notifications @endsection
<body>
 <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
     @include('admin.layout.sidebar')
     @include('sweetalert::alert')
      <!-- partial:partials/_navbar.html -->
    <div class="container-fluid page-body-wrapper">
       <div class="main-panel">
         <div class="panel-body">
            <div class="content-wrapper">

              @include('admin.layout.header')
              @include('sweetalert::alert')


                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-md-12">


                                @if (session('status'))
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif
                                @if ($errors->any())
                                <ul class="alert alert-warning">
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                                @endif

                                <br>

                                <div class="card mt-3">
                                      <div class="card-header" >

                                        <p class="h1" style="color: rgb(57, 29, 218)" >Notifications</p>
                                        @can('create notificationContent')
                                            <a href="{{ route('notificationsOffer.create') }}" class="btn btn-primary float-end">Create New Notification</a>
                                        @endcan
                                        </div>



                                          <!-- Search Results -->
                                  <ul>


                                      <div class="card-body">
                                         <table class="table table-bordered table-striped">
                                            <thead>
                                               <tr>
                                                <th>Title</th>
                                                <th>Message</th>
                                                <th>URL</th>
                                                <th width="40%">Actions</th>
                                                  </tr>
                                             </thead>
                                            <tbody>
                                                @foreach($notifications as $notification)
                                                <tr>
                                                    <td>{{ $notification->title }}</td>
                                                    <td>{{ $notification->message }}</td>
                                                    <td>{{ $notification->url}}</td>
                                                    <td>
                                                        @can('show notificationContent')
                                                        <a href="{{ route('notificationsOffer.show', $notification ) }}" class="btn btn-success" >View</a>
                                                        @endcan
                                                        @can('update notificationContent')
                                                        <a href="{{ route('notificationsOffer.edit', $notification->id) }}" class="btn btn-warning">Edit</a>
                                                        @endcan

                                                        @can('delete notificationContent')
                                                        <form id="deleteForm-{{ $notification->id }}" action="{{ route('notificationsOffer.destroy', $notification) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger deletenotificationBtn" data-id="{{ $notification->id }}">Delete</button>
                                                        </form>
                                                        @endcan

                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                 </tbody>
                                             </table>

                                     </div>

                                  </ul>
                                </div>

       </div>
    </div>
 </div>

 @include('notify::components.notify')
    @notifyJs
    <script src="{{ asset('vendor/mckenziearts/notify/js/notify.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Select all delete buttons and add a click event listener
        document.querySelectorAll('.deletenotificationBtn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the form from submitting immediately

                // Get the ID from the data-id attribute
                const notificationId = this.getAttribute('data-id');
                const formId = `deleteForm-${notificationId}`;

                // Show the SweetAlert2 confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form if the user confirms
                        document.getElementById(formId).submit();
                    }
                });
            });
        });
    </script>

   @include('admin.layout.footer')
 </body>
