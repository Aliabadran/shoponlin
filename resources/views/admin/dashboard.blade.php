

@extends('admin.layout.head')
@section('title')  DashBoart @endsection
    @notifyCss
<body>

    <div class="container-scroller">
       @include('admin.layout.sidebar')
      <!-- partial:partials/_sidebar.html -->
      @include('sweetalert::alert')
      @include('notify::components.notify')
      <!-- partial:partials/_navbar.html -->
        <div class="container-fluid page-body-wrapper">

            @include('admin.layout.header')


         <!--  ('admin.layout.body' char) -->
           @include('admin.layout.body')
            </div>
        </div>
        @notifyJs
           @include('admin.layout.footer')
           <script src="{{ asset('vendor/mckenziearts/notify/js/notify.js') }}"></script>
        </body>

