<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');
        $categoryId = $request->get('category_id');
        $featured = $request->get('featured');
        $perPage = $request->get('per_page', 15);

        $query = BlogPost::with(['category', 'author']);

        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('author', function($authorQuery) use ($search) {
                      $authorQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Apply status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Apply category filter
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Apply featured filter
        if ($featured !== null) {
            $query->where('is_featured', $featured == '1');
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Get all categories for filter
        $categories = \App\Models\BlogCategory::orderBy('name')->get();

        return view('admin.blog.index', compact('posts', 'search', 'status', 'categoryId', 'featured', 'perPage', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\BlogCategory::orderBy('name')->get();
        $authors = \App\Models\User::whereHas('roles', function($q) { 
            $q->whereIn('name', ['Admin', 'SuperAdmin', 'Therapist']); 
        })->orderBy('name')->get();
        
        return view('admin.blog.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'author_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:blog_categories,id',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'focus_keyword' => 'nullable|string|max:100',
            'canonical_url' => 'nullable|url|max:255',
            'og_title' => 'nullable|string|max:100',
            'og_description' => 'nullable|string|max:200',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'twitter_card' => 'nullable|in:summary,summary_large_image',
        ]);

        // Handle file uploads
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog/featured', 'public');
        }

        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('blog/og', 'public');
        }

        // Calculate reading time
        $wordCount = str_word_count(strip_tags($validated['content']));
        $validated['reading_time'] = max(1, ceil($wordCount / 200));

        // Set author if not provided (use authenticated user)
        if (!isset($validated['author_id'])) {
            $validated['author_id'] = auth()->id();
        }

        // Set published_at if status is published and not set
        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = BlogPost::create($validated);

        // Calculate and save SEO score
        $post->seo_score = $post->calculateSeoScore();
        $post->save();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function show(BlogPost $blog)
    {
        $blog->load(['author', 'category']);
        return view('admin.blog.show', compact('blog'));
    }

    public function edit(BlogPost $blog)
    {
        $blog->load(['author', 'category']);
        $categories = \App\Models\BlogCategory::orderBy('name')->get();
        $authors = \App\Models\User::whereHas('roles', function($q) { 
            $q->whereIn('name', ['Admin', 'SuperAdmin', 'Therapist']); 
        })->orderBy('name')->get();
        
        return view('admin.blog.edit', compact('blog', 'categories', 'authors'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug,' . $blog->id,
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'author_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:blog_categories,id',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'focus_keyword' => 'nullable|string|max:100',
            'canonical_url' => 'nullable|url|max:255',
            'og_title' => 'nullable|string|max:100',
            'og_description' => 'nullable|string|max:200',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'twitter_card' => 'nullable|in:summary,summary_large_image',
        ]);

        // Handle file uploads
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image && \Storage::disk('public')->exists($blog->featured_image)) {
                \Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blog/featured', 'public');
        }

        if ($request->hasFile('og_image')) {
            // Delete old image if exists
            if ($blog->og_image && \Storage::disk('public')->exists($blog->og_image)) {
                \Storage::disk('public')->delete($blog->og_image);
            }
            $validated['og_image'] = $request->file('og_image')->store('blog/og', 'public');
        }

        // Calculate reading time
        $wordCount = str_word_count(strip_tags($validated['content']));
        $validated['reading_time'] = max(1, ceil($wordCount / 200));

        // Set published_at if status is published and not set
        if ($validated['status'] === 'published' && !isset($validated['published_at']) && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        // Calculate and save SEO score
        $blog->seo_score = $blog->calculateSeoScore();
        $blog->save();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index');
    }

    public function categories(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');
        $perPage = $request->get('per_page', 15);

        $query = \App\Models\BlogCategory::withCount('posts');

        // Search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $categories = $query->orderBy('sort_order')->orderBy('name')->paginate($perPage);

        return view('admin.blog.categories', compact('categories', 'search', 'status', 'perPage'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_categories,slug',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        \App\Models\BlogCategory::create($validated);

        return redirect()->route('admin.blog.categories')
            ->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, \App\Models\BlogCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        return redirect()->route('admin.blog.categories')
            ->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(\App\Models\BlogCategory $category)
    {
        // Check if category has posts
        if ($category->posts()->count() > 0) {
            return redirect()->route('admin.blog.categories')
                ->with('error', 'Cannot delete category with existing posts. Please reassign or delete posts first.');
        }

        $category->delete();

        return redirect()->route('admin.blog.categories')
            ->with('success', 'Category deleted successfully.');
    }

    public function publish(BlogPost $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => $post->published_at ?? now()
        ]);
        return redirect()->back()->with('success', 'Blog post published successfully.');
    }
}
