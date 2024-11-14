

@extends('admin.layout.head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@notifyCss

@section('title')  Contact  @endsection

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
                        Contact Messages

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

            @if($contacts->isEmpty())
            <p>No Contact found.</p>
        @else

    <!-- Contact Messages Table -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Received At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->subject }}</td>
                        <td>{{ Str::limit($contact->message, 50) }}</td> <!-- Limit message preview to 50 characters -->
                        <td>{{ $contact->created_at->format('F j, Y, g:i a') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No contact messages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $contacts->links() }}
    </div>
    @endif
</div>
           </div>
                </div>
            </div>
           </div>
         </div></div>
        </div>
      </div>
    </div>
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-notify::notify />
        @notifyJs
</body>

@include('admin.layout.footer')
