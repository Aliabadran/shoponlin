<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert; // Add this for SweetAlert

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('admin.tasks', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Task::create($request->only('title', 'description'));

        // SweetAlert for success
        Alert::success('Success', 'Task created successfully.');

        return redirect()->route('tasks');
    }

    public function update(Request $request, Task $task)
    {
        $task->completed = $request->has('completed'); // This will set true if checked, false otherwise
        $task->save();

        // SweetAlert for success
        Alert::success('Success', 'Task updated successfully.');

        return redirect()->route('tasks');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        // SweetAlert for success
        Alert::success('Success', 'Task deleted successfully.');

        return redirect()->route('tasks');
    }
}
