<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('category')->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        // Implementation for storing blog posts
    }

    public function show(BlogPost $blog)
    {
        return view('admin.blog.show', compact('blog'));
    }

    public function edit(BlogPost $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        // Implementation for updating blog posts
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index');
    }

    public function categories()
    {
        return view('admin.blog.categories');
    }

    public function publish(BlogPost $blog)
    {
        $blog->update(['status' => 'published']);
        return redirect()->back();
    }
}
