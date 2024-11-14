
@extends('home.layout.head')
@notifyCss
@section('title') Categories @endsection
<body>
@include('home.layout.header')
<section class="inner_page_head">
   <div class="container_fuild">
      <div class="row">
         <div class="col-md-12">
            <div class="full">
               <h3> Categories</h3>
            </div>
         </div>
      </div>
   </div>
</section>


@include('home.layout.ourcategory')

@include('sweetalert::alert')
@include('notify::components.notify')
@notifyJs


@include('home.layout.footerPage')

