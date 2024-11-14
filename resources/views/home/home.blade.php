<!DOCTYPE html>
<html>
 @extends('home.layout.head')

 @section('title') Famms - Fashion @endsection
 <!-- Include Notify CSS -->
 <link rel="stylesheet" href="{{ asset('vendor/mckenziearts/notify/css/notify.css') }}">

</head>
  @notifyCss

<body>

@include('home.layout.header')
@include('home.layout.slider')
@include('sweetalert::alert')
@include('notify::components.notify')

@include('home.ads.show')

@include('home.layout.why')
@include('home.layout.arrivel')
@include('home.layout.ourcategory')
@include('home.layout.ourproduct')

@include('home.layout.CustomerTestimonial')
@notifyJs

@include('home.layout.footer')

</body>

</html>
