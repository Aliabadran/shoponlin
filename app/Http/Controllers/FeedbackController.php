<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Notifications\NewReplyNotification;
use App\Notifications\FeedbackStatusChanged;
use RealRashid\SweetAlert\Facades\Alert; // Add SweetAlert

class FeedbackController extends Controller
{
    // 1. Show the feedback submission form
    public function showFeedbackForm()
    {
        return view('home.feedback.form');
    }

    // 2. Store the feedback from the user
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'required|in:Bug Report,Feature Request,General Comment',
        ]);

        Feedback::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category,
            'is_public' => false, // Set to false initially for moderation
            'status' => 'Pending',
        ]);

        // Show SweetAlert for successful submission
        Alert::success('Feedback Submitted', 'Your feedback has been submitted and is awaiting review.');
        notify()->success('Your feedback has been submitted and is awaiting review.');
        return redirect()->back();
    }

    // 3. Display all public feedback for users
    public function index()
    {
        $feedbacks = Feedback::where('is_public', true)->latest()->get();
        return view('home.feedback.index', compact('feedbacks'));
    }

    // 4. Admin view for pending feedback review
    public function review()
    {
        $pendingFeedbacks = Feedback::where('is_public', false)->latest()->get();
        $publicFeedbacks = Feedback::where('is_public', true)->latest()->get();;
        return view('admin.feedback.index', compact('pendingFeedbacks', 'publicFeedbacks'));
    }

    // 5. Admin publish feedback
    public function publish(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->is_public = true;
        $feedback->status = 'Reviewed';
        $feedback->save();

        // Optional: Notify the user
        $feedback->user->notify(new FeedbackStatusChanged($feedback, 'Reviewed'));

        // Show SweetAlert for publishing
        Alert::success('Feedback Published', 'Feedback has been published.');
        notify()->success('Feedback has been published.');
        return redirect()->back();
    }

    // 6. Reply to feedback (by users and admins)
    public function reply(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $parentFeedback = Feedback::findOrFail($id);

        $reply = Feedback::create([
            'user_id' => auth()->id(),
            'title' => 'Reply to: ' . $parentFeedback->title,
            'body' => $request->body,
            'category' => $parentFeedback->category,
            'is_public' => true,
            'status' => 'Reviewed',
            'parent_id' => $id,
        ]);

        // Notify the original user of the feedback
        $parentFeedback->user->notify(new NewReplyNotification($parentFeedback, $reply));

        // Show SweetAlert for reply
        Alert::success('Reply Posted', 'Your reply has been posted.');
        notify()->success('Your reply has been posted.');
        return redirect()->back();
    }

    // 7. Admin update feedback status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Reviewed,In Progress,Implemented',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->status = $request->status;
        $feedback->save();

        // Optional: Notify the user
        $feedback->user->notify(new FeedbackStatusChanged($feedback, $feedback->status));

        // Show SweetAlert for status update
        Alert::success('Status Updated', 'Feedback status updated successfully.');
        smilify('Success', 'Feedback status updated successfully.');
        return redirect()->back();
    }

    // 8. Admin toggle feedback visibility
    public function toggleVisibility($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->is_public = !$feedback->is_public;
        $feedback->save();

        // Show SweetAlert for visibility toggle
        Alert::success('Visibility Updated', 'Feedback visibility updated.');
        smilify('Success', 'Feedback visibility updated.');
        return redirect()->back();
    }
}
