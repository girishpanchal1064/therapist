<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 6;
        $categoryId = $request->get('category', 'all');
        $page = $request->get('page', 1);

        // Get categories for tabs
        $categories = BlogCategory::active()->ordered()->get();

        // Get featured post
        $featuredPost = BlogPost::published()
            ->featured()
            ->with(['author.profile', 'author.therapistProfile', 'category'])
            ->first();

        // Build query for posts
        $query = BlogPost::published()
            ->with(['author.profile', 'author.therapistProfile', 'category'])
            ->orderBy('published_at', 'desc');

        // Filter by category if not 'all'
        if ($categoryId !== 'all') {
            $query->byCategory($categoryId);
        }

        // Get posts with pagination
        $posts = $query->paginate($perPage, ['*'], 'page', $page);

        // Handle AJAX requests
        if ($request->ajax()) {
            $html = view('web.blog.partials.posts-grid', compact('posts'))->render();

            return response()->json([
                'html' => $html,
                'hasMore' => $posts->hasMorePages(),
                'nextPage' => $posts->currentPage() + 1,
                'total' => $posts->total(),
            ]);
        }

        return view('web.blog.index', compact(
            'posts',
            'categories',
            'featuredPost',
            'categoryId'
        ));
    }

    public function show($slug)
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->with(['author.profile', 'author.therapistProfile', 'category'])
            ->firstOrFail();

        // Increment views count
        $post->increment('views_count');

        // Get related posts
        $relatedPosts = BlogPost::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->with(['author.profile', 'author.therapistProfile', 'category'])
            ->limit(3)
            ->get();

        return view('web.blog.show', compact('post', 'relatedPosts'));
    }

    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();

        $posts = BlogPost::published()
            ->byCategory($category->id)
            ->with(['author.profile', 'author.therapistProfile', 'category'])
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        return view('web.blog.category', compact('posts', 'category'));
    }
}
