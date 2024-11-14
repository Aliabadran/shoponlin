
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
@include('sweetalert::alert')
<div class="container mt-5">

    <a href="{{ route('home') }}" class="btn btn-danger float-end">Back</a>
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Contact Form -->

</div>
<section class="why_section layout_padding">
    <div class="container">

       <div class="row">
          <div class="col-lg-8 offset-lg-2">
             <div class="full">

               @can('store contacts')
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" class="form-control" id="subject" placeholder="Enter subject" value="{{ old('subject') }}" required>
                        @error('subject')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" class="form-control" id="message" rows="5" placeholder="Enter your message" required>{{ old('message') }}</textarea>
                        @error('message')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
                 @endcan
             </div>
          </div>
       </div>
    </div>
 </section>
 @include('notify::components.notify')
 @notifyJs

 @include('home.layout.arrivel')
 @include('home.layout.footerPage')

</body>
