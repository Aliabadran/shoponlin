@notifyCss
<div class="container mt-5">
    <!-- Product Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <!-- Product Image -->
            <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-6">
            <!-- Product Details -->
            <h2 class="mb-3">{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->description }}</p>
            <h4 class="text-primary">${{ number_format($product->price, 2) }}</h4>
            <!-- Add to Cart Button -->
            <button class="btn btn-success mt-3">Add to Cart</button>
        </div>
    </div>

    <hr>

    <!-- Comments Section -->
    <div class="comments-section mt-5">
        <h3 class="mb-4">Comments</h3>

        @foreach($product->comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="media mb-3">
                        <!-- Comment User Image -->
                        <img src="{{ $comment->user->profile_picture }}" alt="User Image" class="mr-3 rounded-circle" style="width: 50px; height: 50px;">
                        <div class="media-body">
                            <h5 class="mt-0">{{ $comment->user->name }}</h5>
                            <p>{{ $comment->body }}</p>
                            <small class="text-muted">Posted on {{ $comment->created_at->format('F j, Y \a\t g:i A') }}</small>
                        </div>
                    </div>

                    <!-- Replies Section -->
                    @foreach($comment->replies as $reply)
                        <div class="media mt-4">
                            <!-- Reply User Image -->
                            <img src="#" alt="User Image" class="mr-3 rounded-circle" style="width: 40px; height: 40px;">
                            <div class="media-body">
                                <h6 class="mt-0">{{ $reply->user->name }}</h6>
                                <p>{{ $reply->body }}</p>
                                <small class="text-muted">Replied on {{ $reply->created_at->format('F j, Y \a\t g:i A') }}</small>
                            </div>
                        </div>
                    @endforeach

                    <!-- Reply Form -->
                    <form action="{{ route('comments.store', ['type' => $type, 'id' => $id]) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="2" placeholder="Write a reply..."></textarea>
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <input type="hidden" name="commentable_type" value="product">
                            <input type="hidden" name="commentable_id" value="{{ $product->id }}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Reply</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Add New Comment Form -->
    <div class="add-comment-section mt-5">
        <h4>Add a Comment</h4>
        <form action="{{ route('comments.store', ['type' => $type, 'id' => $id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="body" class="form-control" rows="3" placeholder="Write a comment..."></textarea>
                <input type="hidden" name="commentable_type" value="product">
                <input type="hidden" name="commentable_id" value="{{ $product->id }}">
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>
    </div>
</div>
@include('notify::components.notify')
@notifyJs

@include('sweetalert::alert')
