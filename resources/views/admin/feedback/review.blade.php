<!DOCTYPE html>
<html>
<head>
    <title>Admin Review Feedback</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Review Feedback</h2>
    <hr>

    @foreach($feedbacks as $feedback)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $feedback->title }}</h5>
                <p class="card-text">{{ $feedback->body }}</p>
                <p class="card-text"><small class="text-muted">{{ $feedback->category }}</small></p>

                <!-- Publish feedback -->
                <form action="{{ route('admin.feedback.publish', $feedback->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Publish</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@include('sweetalert::alert')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
