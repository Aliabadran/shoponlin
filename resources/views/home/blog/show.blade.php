
@extends('home.layout.head')

@section('title') Contact  @endsection
@notifyCss
<body>
@include('home.layout.header')
<section class="inner_page_head">
   <div class="container_fuild">
      <div class="row">
         <div class="col-md-12">
            <div class="full">
               <h3> Contact Us</h3>
            </div>
         </div>
      </div>
   </div>
</section>

<div class="container mt-5">

    <a href="{{ route('home') }}" class="btn btn-danger float-end">Back</a>
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Contact Form -->


<div class="container mt-5">
    <h2>{{ $blog->title }}</h2>
    <p class="text-muted">{{ $blog->created_at->format('F j, Y') }}</p>

    <div class="content">
        {!! nl2br(e($blog->content)) !!}
    </div>

    <a href="{{ route('blog.index') }}" class="btn btn-success mt-4">Back to Blog</a>
</div>
<br>
</div>
@include('home.layout.footerPage')
@include('sweetalert::alert')

</body>
