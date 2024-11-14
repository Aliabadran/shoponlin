<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\GeneralFeedback;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert; // Import SweetAlert

class CommentController extends Controller
{

    // Store a new comment
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:500',
            'commentable_type' => 'required|string', // e.g., 'product', 'general_feedback', 'feedback'
            'commentable_id' => 'required|integer',
        ]);

        // Use the getModel method to find the model instance
        $model = $this->getModel($request->commentable_type, $request->commentable_id);

        if (!$model) {
            // Show error alert
            Alert::error('Error', 'Invalid model type or ID.');
            return redirect()->back();
        }

        // Create the comment using the polymorphic relationship
        $model->comments()->create([
            'body' => $request->body,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id, // This will be null for top-level comments
        ]);

        // Show success alert
        Alert::success('Success', 'Comment added successfully!');
        drakify('success');
        return redirect()->back();
    }

    // Helper function to get the model based on type and ID
    private function getModel($type, $id)
    {
        switch ($type) {
            case 'product':
                return Product::find($id);
            case 'general_feedback':
                return GeneralFeedback::find($id);
            case 'feedback':
                return Feedback::find($id);
            default:
                return null;
        }
    }

    // Method to handle replying to a comment
    public function reply($id, Request $request)
    {
        // Your reply logic here
        $comment = Comment::findOrFail($id);
        $reply = new Comment();
        $reply->body = $request->input('reply_text');
        $reply->parent_id = $comment->id; // Assuming you have a parent_id field for replies
        $reply->save();

        // Show success alert for reply
        Alert::success('Success', 'Reply added successfully!');
        emotify ('Success', 'Reply added successfully!');
        return redirect()->back();
    }

    // Display the edit form for a comment
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('home.comments-edit', compact('comment'));
    }

    // Update the comment in the database
    public function update($id, Request $request)
    {
        $comment = Comment::findOrFail($id);

        // Validate the request
        $request->validate([
            'body' => 'required',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // Update the comment
        $comment->body = $request->input('body');
        $comment->user_id = Auth::id();
        $comment->parent_id = $request->parent_id;
        $comment->save();

        // Show success alert for update
        Alert::success('Success', 'Comment updated successfully!');
        drakify('success');
        return redirect()->route('home.comments');
    }

    // Method to handle deleting a comment
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        // Show success alert for deletion
        Alert::success('Success', 'Comment deleted successfully!');
        drakify('error');
        return redirect()->back();
    }
}
