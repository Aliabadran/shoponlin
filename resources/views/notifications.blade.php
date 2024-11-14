@extends('home.layout.head')

<!-- Include Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@notifyCss

<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('title') Notifications @endsection

<body>
@include('home.layout.header')

<!-- Inner Page Header -->
<section class="inner_page_head bg-primary text-white py-5">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h3 class="display-4">Notifications</h3>
         </div>
      </div>
   </div>
</section>

<br>

<div class="container mt-5">
   <!-- SweetAlert alert -->
   @include('sweetalert::alert')

   <!-- Notifications Header -->
   <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="h4">Your Notifications</h2>

        <a href="{{ url('notify-all') }}" class="btn btn-primary">Notify User with All Types</a>

      @if(!$notifications->isEmpty())
         <form action="{{ route('notifications.markAsRead') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-primary btn-sm">Mark all as read</button>
         </form>
      @endif
   </div>

   <!-- Show custom alert message -->
   @if(session('alert'))
      <div class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show" role="alert">
         {{ session('alert')['message'] }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
   @endif

   <!-- Notification List -->
   @if($notifications->isEmpty())
      <div class="alert alert-info">
         <p>No notifications available.</p>
      </div>
   @else
      <ul class="list-group list-group-flush">
         @foreach($notifications as $notification)
            <li class="list-group-item d-flex justify-content-between align-items-center {{ $notification->read_at ? '' : 'bg-light' }}">
               <div>
                  <strong>{{ $notification->data['message'] }}</strong>
                  <br>
                  <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
               </div>
               @if ($notification->read_at == null)
                  <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="ms-3">
                     @csrf
                     <button type="submit" class="btn btn-sm btn-info">Mark as Read</button>
                  </form>
               @endif
            </li>
         @endforeach
      </ul>
   @endif
</div>

<!-- Auto-dismiss alert handler -->
<script>
    setTimeout(function() {
        let alertElement = document.querySelector('.alert');
        if (alertElement) {
            alertElement.style.transition = 'opacity 1s';
            alertElement.style.opacity = '0';
            setTimeout(function() {
                alertElement.remove();
            }, 1000);
        }
    }, 3000); // Alert disappears after 3 seconds
</script>

@include('notify::components.notify')
@notifyJs
@notifyRender
@include('home.layout.footerPage')

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
