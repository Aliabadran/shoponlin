

@extends('admin.layout.head')
@section('title')  DashBoart @endsection

<body>
    <div class="container-scroller">
       @include('admin.layout.sidebar')
      <!-- partial:partials/_sidebar.html -->


      <!-- partial:partials/_navbar.html -->
        <div class="container-fluid page-body-wrapper">

            @include('admin.layout.header')


         <!--  ('admin.layout.body' char) -->
           @include('admin.layout.char')
            </div>
        </div>

           @include('admin.layout.footer')
        </body>

