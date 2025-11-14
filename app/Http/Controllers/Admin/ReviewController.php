<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');
        $rating = $request->get('rating');
        $perPage = $request->get('per_page', 15);

        $query = Review::with(['client', 'therapist', 'appointment']);

        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('client', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('therapist', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Apply status filter
        if ($status === 'verified') {
            $query->where('is_verified', true);
        } elseif ($status === 'pending') {
            $query->where('is_verified', false);
        } elseif ($status === 'public') {
            $query->where('is_public', true);
        } elseif ($status === 'private') {
            $query->where('is_public', false);
        }

        // Apply rating filter
        if ($rating) {
            $query->where('rating', $rating);
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.reviews.index', compact('reviews', 'search', 'status', 'rating', 'perPage'));
    }

    public function create()
    {
        $clients = \App\Models\User::role('Client')->orderBy('name')->get();
        $therapists = \App\Models\User::role('Therapist')->orderBy('name')->get();
        $appointments = \App\Models\Appointment::with(['client', 'therapist'])
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        return view('admin.reviews.create', compact('clients', 'therapists', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:users,id',
            'therapist_id' => 'required|exists:users,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'is_verified' => 'boolean',
            'is_public' => 'boolean',
        ]);

        // Check if review already exists for this appointment
        if ($validated['appointment_id']) {
            $existingReview = Review::where('appointment_id', $validated['appointment_id'])
                ->where('client_id', $validated['client_id'])
                ->first();
            
            if ($existingReview) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'A review already exists for this appointment.');
            }
        }

        Review::create([
            'client_id' => $validated['client_id'],
            'therapist_id' => $validated['therapist_id'],
            'appointment_id' => $validated['appointment_id'] ?? null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_verified' => $request->has('is_verified'),
            'is_public' => $request->has('is_public'),
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
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

    public function pending(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 15);

        $query = Review::with(['client', 'therapist', 'appointment'])->where('is_verified', false);

        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('client', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('therapist', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.reviews.pending', compact('reviews', 'search', 'perPage'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_verified' => true]);
        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    public function reject(Review $review)
    {
        $review->update(['is_verified' => false, 'is_public' => false]);
        return redirect()->back()->with('success', 'Review rejected successfully.');
    }
}
