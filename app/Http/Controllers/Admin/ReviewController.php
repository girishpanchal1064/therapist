<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['client', 'therapist'])->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.reviews.create');
    }

    public function store(Request $request)
    {
        // Implementation for storing reviews
    }

    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        // Implementation for updating reviews
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index');
    }

    public function pending()
    {
        $reviews = Review::where('is_verified', false)->paginate(15);
        return view('admin.reviews.pending', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_verified' => true]);
        return redirect()->back();
    }

    public function reject(Review $review)
    {
        $review->update(['is_verified' => false, 'is_public' => false]);
        return redirect()->back();
    }
}
