<!DOCTYPE html>
<html>
<head>
    
    @notifyCss

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .comment-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        .comment {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .reply-button {
            cursor: pointer;
            color: #007bff;
        }
        .reply-form {
            display: none;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="comment-section">
        <h3>Comments</h3>
        <hr>
        <!-- Display Comments and Replies -->
        @foreach($comments as $comment)
            <div class="comment">
                <strong>{{ $comment->user->name }}</strong>:
                <p>{{ $comment->body }}</p>

                <!-- Reply Button -->
                <span class="reply-button" data-id="{{ $comment->id }}">Reply</span>

                <!-- Form to Add a Reply -->
                <form action="{{ route('comments.store', ['type' => $type, 'id' => $id]) }}" method="POST" class="reply-form" id="reply-form-{{ $comment->id }}">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <textarea name="body" class="form-control mt-2" placeholder="Write your reply..."></textarea>
                    <button type="submit" class="btn btn-primary btn-sm mt-2">Submit Reply</button>
                </form>

                <!-- Display Replies -->
                @foreach($comment->replies as $reply)
                    <div class="ml-4 mt-3">
                        <strong>{{ $reply->user->name }}</strong>:
                        <p>{{ $reply->body }}</p>
                    </div>
                @endforeach
            </div>
        @endforeach

        <!-- Form to Add a New Comment -->
        <form action="{{ route('comments.store', ['type' => $type, 'id' => $id]) }}" method="POST" class="mt-4">
            @csrf
            <textarea name="body" class="form-control" placeholder="Add a comment..."></textarea>
            <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
        </form>
    </div>
</div>



@include('sweetalert::alert')

<!-- JavaScript to Show/Hide Reply Forms -->
<script>
    document.querySelectorAll('.reply-button').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            document.getElementById(`reply-form-${id}`).style.display = 'block';
        });
    });
</script>

@include('notify::components.notify')
@notifyJs



</body>
</html>
