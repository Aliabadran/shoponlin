@extends('home.layout.head')
@section('title')  User Feedback @endsection

<body>
    @include('home.layout.header')

    <section class="inner_page_head">
        <div class="container_fuild">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <h3>Public Feedback</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <h2 class="mb-4">Public Feedback</h2>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Feedbacks Loop -->
        @foreach($feedbacks as $feedback)
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $feedback->title }}</h5>
                    <p class="card-text">{{ $feedback->body }}</p>
                    <p class="card-text">
                        <small class="text-muted">Category: {{ $feedback->category }}</small>
                    </p>

                    <!-- Latest Reply Section -->
                    @if($feedback->replies->isNotEmpty())
                        <div class="latest-reply p-3 my-2 bg-light border rounded">
                            <strong>Latest Reply {{ $reply->user->name ?? 'Unknown' }}:</strong> {{ $feedback->replies->last()->body }}
                        </div>
                    @endif

                    <!-- All Replies Section (Initially Hidden) -->
                    <div class="all-replies mt-4" id="replies-{{ $feedback->id }}" style="display: none;">
                        <h6>All Replies</h6>
                        @foreach($feedback->replies as $reply)
                            <div class="p-3 my-2 bg-light border rounded">

                                <strong>Reply from {{ $reply->user->name ?? 'Unknown' }}:</strong> {{ $reply->body }}

                            </div>
                        @endforeach
                    </div>

                    <!-- Button to Show All Replies -->
                    @if($feedback->replies->count() > 1)
                        <button class="btn btn-link" onclick="toggleReplies({{ $feedback->id }})" id="toggle-button-{{ $feedback->id }}">
                            Show All Replies
                        </button>
                    @endif

                    <!-- Reply Form for Authenticated Users -->
                    @auth
                        <form action="{{ route('feedback.reply', $feedback->id) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="form-group">
                                <textarea name="body" class="form-control" placeholder="Write your reply..." rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Submit Reply</button>
                        </form>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>

    <!-- JavaScript for Toggling Replies -->
    <script>
        function toggleReplies(feedbackId) {
            var repliesSection = document.getElementById('replies-' + feedbackId);
            var toggleButton = document.getElementById('toggle-button-' + feedbackId);

            if (repliesSection.style.display === 'none') {
                repliesSection.style.display = 'block';
                toggleButton.textContent = 'Hide All Replies';
            } else {
                repliesSection.style.display = 'none';
                toggleButton.textContent = 'Show All Replies';
            }
        }
    </script>
    @include('home.layout.footerPage')
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
