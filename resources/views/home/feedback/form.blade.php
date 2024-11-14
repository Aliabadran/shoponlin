
@extends('home.layout.head')
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<body>

    @include('home.layout.header')

<section class="inner_page_head">
   <div class="container_fuild">
      <div class="row">
         <div class="col-md-12">
            <div class="full">
               <h3>Submit Your Feedback</h3>
            </div>
         </div>
      </div>
   </div>
</section>
<br>
<div class="container mt-10">

    <h2>Submit Your Feedback</h2>
    <hr>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="body">Feedback</label>
            <textarea name="body" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" class="form-control" required>
                <option value="Bug Report">Bug Report</option>
                <option value="Feature Request">Feature Request</option>
                <option value="General Comment">General Comment</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
</div>

@include('home.layout.footerPage')
@include('sweetalert::alert')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
