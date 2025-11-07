<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the therapist's reviews.
     */
    public function index(Request $request)
    {
        $therapistId = Auth::id();
        $search = $request->get('search');
        $rating = $request->get('rating');

        $query = Review::where('therapist_id', $therapistId)
            ->with(['client', 'appointment']);

        // Search by client name or comment
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by rating
        if ($rating) {
            $query->where('rating', $rating);
        }

        $perPage = $request->get('per_page', 10);
        
        $reviews = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        // Calculate statistics
        $totalReviews = Review::where('therapist_id', $therapistId)->count();
        $averageRating = Review::where('therapist_id', $therapistId)->avg('rating') ?? 0;
        $ratingDistribution = Review::where('therapist_id', $therapistId)
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        return view('therapist.reviews.index', compact('reviews', 'search', 'rating', 'totalReviews', 'averageRating', 'ratingDistribution'));
    }
}
