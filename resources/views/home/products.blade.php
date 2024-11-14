
 @extends('home.layout.head')
 @notifyCss
 @section('title') Products @endsection
<body>
@include('home.layout.header')
<section class="inner_page_head">
    <div class="container_fuild">
       <div class="row">
          <div class="col-md-12">
             <div class="full">
                <h3>Product Grid</h3>
             </div>
          </div>
       </div>
    </div>
 </section>


 @include('home.layout.ourproduct')

 @include('notify::components.notify')
 @notifyJs




@include('home.layout.footerPage')

