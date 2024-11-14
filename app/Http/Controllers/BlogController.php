<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(5); // Fetch the latest blog posts and paginate
        return view('home.blog.index', compact('blogs'));
    }

    // Display a single blog post
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('home.blog.show', compact('blog'));
    }





    public function create()
    {
        return view('admin.blog.create');
    }
        // Store the new blog post in the database
        public function store(Request $request)
        {
            // Validate the form data
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            // Create a new blog post
            Blog::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);

            Alert::success('Success', 'Blog post added successfully.');
            notify()->Success('Blog post added successfully.');
            return redirect()->back();
            // Redirect back to the blog list with a success message
          //  return redirect()->route('home.blog.index')->with('success', 'Blog post added successfully!');
        }

}
