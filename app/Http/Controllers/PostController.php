<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::get()->toArray();
        // dd($posts);
        return view('admin/products.show')->with (compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string'
            ]);

            $post = Post::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => 1
            ]);

            return redirect()->back()->with('success_message', 'Post added successfully');
        } catch (\Exception $e) {
            \Log::error('Error creating post: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error_message', 'Failed to create post. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
