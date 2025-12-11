<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $reviews = Review::where('client_id', $user->id)
            ->with(['therapist.therapistProfile', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get summary statistics
        $totalReviews = Review::where('client_id', $user->id)->count();
        $verifiedCount = Review::where('client_id', $user->id)->where('is_verified', true)->count();
        $publishedCount = Review::where('client_id', $user->id)->where('is_verified', true)->where('is_public', true)->count();

        return view('client.reviews.index', compact('reviews', 'totalReviews', 'verifiedCount', 'publishedCount'));
    }

    public function create($appointmentId)
    {
        $appointment = Appointment::with(['therapist.therapistProfile'])
            ->findOrFail($appointmentId);

        // Check if user owns this appointment
        if ($appointment->client_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if appointment is completed
        if ($appointment->status !== 'completed') {
            return redirect()->route('client.dashboard')
                ->with('error', 'You can only review completed sessions.');
        }

        // Check if review already exists
        $existingReview = Review::where('client_id', Auth::id())
            ->where('appointment_id', $appointmentId)
            ->first();

        if ($existingReview) {
            return redirect()->route('client.reviews.index')
                ->with('info', 'You have already reviewed this session.');
        }

        return view('client.reviews.create', compact('appointment'));
    }

    public function store(Request $request, $appointmentId = null)
    {
        $appointmentId = $appointmentId ?? $request->appointment_id;
        
        $request->validate([
            'appointment_id' => 'required_without:appointmentId|exists:appointments,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $appointmentId = $appointmentId ?? $request->appointment_id;
        $appointment = Appointment::findOrFail($appointmentId);

        // Check if user owns this appointment
        if ($appointment->client_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if review already exists
        $existingReview = Review::where('client_id', Auth::id())
            ->where('appointment_id', $appointmentId)
            ->first();

        if ($existingReview) {
            return redirect()->route('client.reviews.index')
                ->with('error', 'You have already reviewed this session.');
        }

        // Create review
        $review = Review::create([
            'client_id' => Auth::id(),
            'therapist_id' => $appointment->therapist_id,
            'appointment_id' => $appointmentId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_verified' => false,
            'is_public' => $request->has('is_public'),
        ]);

        // Update therapist rating
        if ($appointment->therapist->therapistProfile) {
            $appointment->therapist->therapistProfile->updateRating();
        }

        return redirect()->route('client.reviews.index')
            ->with('success', 'Review submitted successfully! It will be published after verification.');
    }
}
