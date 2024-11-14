

@extends('home.layout.head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@section('title') General Feedback @endsection
<body>
@include('home.layout.header')
<section class="inner_page_head">
   <div class="container_fuild">
      <div class="row">
         <div class="col-md-12">
            <div class="full">
               <h3>General Feedback</h3>
            </div>
         </div>
      </div>
   </div>
</section>

<br>

<div class="container">


          <div class="scrollable-container"  >
               <!-- Your wide content goes here -->


           <div class="col-md-12">
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
            @if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

            <div class="card mt-3">
                <div class="card-header">
                    <h2 >
                        General Feedback

                    </h2>
                    <a href="{{ url('/') }}" class="btn btn-danger float-end">  Back</a>
                    </div>




                <!-- Display All General Feedbacks -->
     @foreach($feedbacks as $feedback)
                    <div class="feedback mb-4">

                        <h5>{{ $feedback->title }}</h5>
                        <p>{{ $feedback->description }}</p>


                    <!-- Include the comments Blade component for each feedback -->
                        @include('home.comments', ['comments' => $feedback->comments, 'type' => 'general_feedback', 'id' => $feedback->id])
                    </div>
 @endforeach

    </div>
    @include('home.layout.footerPage')

</body>

