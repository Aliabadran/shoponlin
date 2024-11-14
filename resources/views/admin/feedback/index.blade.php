@extends('admin.layout.head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
         @notifyCss
    <!-- Custom CSS -->

    @section('title')Admin Feedback Review @endsection

<body>

    <div class="container-scroller">
        @include('admin.layout.sidebar')
        @include('sweetalert::alert')

        <div class="container-fluid page-body-wrapper">
         <div class="main-panel">
         <div class="panel-body">
          <div class="content-wrapper">

            @include('admin.layout.header')

            <div class="scrollable-container">
             <div class="wide-content">


    <div class="container mt-5">
        <h2 class="text-center mb-4">Admin Feedback Management</h2>

    <hr>

    <!-- Pending Feedback Section -->
    <h3 class="text-success">Pending Feedback</h3>
    @if($pendingFeedbacks->isEmpty())
    <div class="alert alert-info">No pending feedbacks to review.</div>
    @else
        @foreach($pendingFeedbacks as $feedback)
            <div class="card mb-3  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $feedback->title }}</h5>
                    <p class="card-text">{{ $feedback->body }}</p>
                    <p class="text-muted"><small>Submitted by: {{ $feedback->user->name ?? 'Unknown' }}</small></p>
                    <p class="text-muted"><small class="text-muted">Category: {{ $feedback->category }}</small></p>
                    <p class="text-muted"><small class="text-muted">Status: {{ $feedback->status }}</small></p>

                    <!-- Publish Feedback Form with SweetAlert Confirmation -->
                    <button type="button" class="btn btn-success" onclick="confirmPublish({{ $feedback->id }})">Publish</button>
                    <form id="publish-form-{{ $feedback->id }}" action="{{ route('admin.feedback.publish', $feedback->id) }}" method="POST" style="display:none;">
                        @csrf
                    </form>

                    <!-- Reply Form -->
                    <form action="{{ route('feedback.reply', $feedback->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" class="form-control" placeholder="Write your reply..." rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Reply</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

    <hr>

    <!-- Published Feedback Section -->
    <h3 class="text-success">Published Feedback</h3>
    @if($publicFeedbacks->isEmpty())
    <div class="alert alert-info">No published feedbacks available.</div>
    @else
        @foreach($publicFeedbacks as $feedback)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $feedback->title }}</h5>
                    <p class="card-text">{{ $feedback->body }}</p>
                    <p class="card-text"><small class="text-muted">Category: {{ $feedback->category }}</small></p>
                    <p class="card-text"><small class="text-muted">Status: {{ $feedback->status }}</small></p>

                    <!-- Toggle Visibility with SweetAlert Confirmation -->
                    <button type="button" class="btn btn-warning" onclick="confirmToggleVisibility({{ $feedback->id }}, {{ $feedback->is_public }})">
                        {{ $feedback->is_public ? 'Unpublish' : 'Publish' }}
                    </button>
                    <form id="visibility-form-{{ $feedback->id }}" action="{{ route('admin.feedback.toggleVisibility', $feedback->id) }}" method="POST" style="display:none;">
                        @csrf
                    </form>

                    <!-- Update Status Form -->
                    <form action="{{ route('admin.feedback.updateStatus', $feedback->id) }}" method="POST" class="d-inline">
                        @csrf
                        <select name="status" class="form-control d-inline w-auto" onchange="this.form.submit()">
                            <option value="Pending" {{ $feedback->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Reviewed" {{ $feedback->status == 'Reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="In Progress" {{ $feedback->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Implemented" {{ $feedback->status == 'Implemented' ? 'selected' : '' }}>Implemented</option>
                        </select>
                    </form>

                    <!-- Replies Section -->
                    @foreach($feedback->replies as $reply)
                        <div class="mt-3 p-2 border-left">
                            <strong>Reply from {{ $reply->user->name ?? 'Unknown' }}:</strong> {{ $reply->body }}
                        </div>
                    @endforeach


                    <!-- Reply Form -->
                    <form action="{{ route('feedback.reply', $feedback->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" class="form-control" placeholder="Write your reply..." rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Reply</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>

@include('sweetalert::alert')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmPublish(feedbackId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to publish this feedback?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, publish it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('publish-form-' + feedbackId).submit();
            }
        });
    }

    function confirmToggleVisibility(feedbackId, isPublic) {
        let action = isPublic ? 'unpublish' : 'publish';
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to ${action} this feedback?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: `Yes, ${action} it!`,
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('visibility-form-' + feedbackId).submit();
            }
        });
    }
</script>
<x-notify::notify />
@notifyJs
</body>
