<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TherapistProfile;
use App\Models\TherapistSpecialization;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'therapist')
            ->whereHas('therapistProfile', function($q) {
                $q->where('is_verified', true)
                  ->where('is_available', true);
            })
            ->with(['therapistProfile.specializations', 'profile']);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhereHas('therapistProfile', function($subQ) use ($searchTerm) {
                      $subQ->where('qualification', 'like', "%{$searchTerm}%")
                           ->orWhere('bio', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('therapistProfile.specializations', function($subQ) use ($searchTerm) {
                      $subQ->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Apply filters
        if ($request->filled('specializations')) {
            $query->whereHas('therapistProfile.specializations', function($q) use ($request) {
                $q->whereIn('slug', $request->specializations);
            });
        }

        if ($request->filled('language')) {
            $query->whereHas('therapistProfile', function($q) use ($request) {
                $q->whereJsonContains('languages', $request->language);
            });
        }

        if ($request->filled('gender')) {
            $query->whereHas('profile', function($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        if ($request->filled('min_fee') || $request->filled('max_fee')) {
            $query->whereHas('therapistProfile', function($q) use ($request) {
                if ($request->filled('min_fee')) {
                    $q->where('consultation_fee', '>=', $request->min_fee);
                }
                if ($request->filled('max_fee')) {
                    $q->where('consultation_fee', '<=', $request->max_fee);
                }
            });
        }

        if ($request->filled('experience')) {
            $query->whereHas('therapistProfile', function($q) use ($request) {
                $q->where('experience_years', '>=', $request->experience);
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'rating');
        switch ($sortBy) {
            case 'rating':
                $query->join('therapist_profiles', 'users.id', '=', 'therapist_profiles.user_id')
                      ->select('users.*')
                      ->orderBy('therapist_profiles.rating_average', 'desc');
                break;
            case 'experience':
                $query->join('therapist_profiles', 'users.id', '=', 'therapist_profiles.user_id')
                      ->select('users.*')
                      ->orderBy('therapist_profiles.experience_years', 'desc');
                break;
            case 'fee_low':
                $query->join('therapist_profiles', 'users.id', '=', 'therapist_profiles.user_id')
                      ->select('users.*')
                      ->orderBy('therapist_profiles.consultation_fee', 'asc');
                break;
            case 'fee_high':
                $query->join('therapist_profiles', 'users.id', '=', 'therapist_profiles.user_id')
                      ->select('users.*')
                      ->orderBy('therapist_profiles.consultation_fee', 'desc');
                break;
            case 'name':
                $query->orderBy('users.name', 'asc');
                break;
            default:
                $query->join('therapist_profiles', 'users.id', '=', 'therapist_profiles.user_id')
                      ->select('users.*')
                      ->orderBy('therapist_profiles.rating_average', 'desc');
        }

        // Paginate the results
        $perPage = $request->get('per_page', 12);
        $therapists = $query->paginate($perPage);

        // Get specializations for filter
        $specializations = TherapistSpecialization::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Get languages for filter
        $languages = User::where('role', 'therapist')
            ->whereHas('therapistProfile')
            ->get()
            ->pluck('therapistProfile.languages')
            ->flatten()
            ->unique()
            ->filter()
            ->sort()
            ->values();

        // Get filter options
        $filterOptions = [
            'specializations' => $specializations,
            'languages' => $languages,
            'genders' => ['male', 'female', 'other'],
            'experience_ranges' => [
                ['min' => 0, 'max' => 2, 'label' => '0-2 years'],
                ['min' => 3, 'max' => 5, 'label' => '3-5 years'],
                ['min' => 6, 'max' => 10, 'label' => '6-10 years'],
                ['min' => 11, 'max' => 20, 'label' => '11-20 years'],
                ['min' => 21, 'max' => 999, 'label' => '20+ years'],
            ],
            'fee_ranges' => [
                ['min' => 0, 'max' => 500, 'label' => 'Under ₹500'],
                ['min' => 500, 'max' => 1000, 'label' => '₹500 - ₹1000'],
                ['min' => 1000, 'max' => 2000, 'label' => '₹1000 - ₹2000'],
                ['min' => 2000, 'max' => 5000, 'label' => '₹2000 - ₹5000'],
                ['min' => 5000, 'max' => 9999, 'label' => 'Above ₹5000'],
            ]
        ];

        // Handle AJAX requests
        if ($request->ajax()) {
            $viewType = $request->get('view_type', 'card');
            
            if ($viewType === 'list') {
                $html = view('web.therapists.partials.list-view', compact('therapists'))->render();
            } else {
                $html = view('web.therapists.partials.card-view', compact('therapists'))->render();
            }
            
            return response()->json([
                'html' => $html,
                'pagination' => $therapists->links()->render(),
                'total' => $therapists->total(),
                'current_page' => $therapists->currentPage(),
                'last_page' => $therapists->lastPage()
            ]);
        }

        return view('web.therapists.index', compact(
            'therapists',
            'specializations',
            'languages',
            'filterOptions'
        ));
    }

    public function show($slug)
    {
        $therapist = User::where('role', 'therapist')
            ->whereHas('therapistProfile', function($q) {
                $q->where('is_verified', true);
            })
            ->with(['therapistProfile.specializations', 'profile', 'reviewsAsTherapist.client.profile'])
            ->findOrFail($slug);

        if (!$therapist->therapistProfile) {
            abort(404, 'Therapist profile not found');
        }

        // Get recent reviews
        $reviews = $therapist->reviewsAsTherapist()
            ->where('is_verified', true)
            ->where('is_public', true)
            ->with('client.profile')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get available time slots for next 7 days
        $availableSlots = $this->getAvailableSlots($therapist->id);

        return view('web.therapists.show', compact(
            'therapist',
            'reviews',
            'availableSlots'
        ));
    }

    private function getAvailableSlots($therapistId)
    {
        // This is a simplified version - in real app, get from availability table
        $slots = [];
        $startDate = today();

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $daySlots = [];

            // Generate time slots for each day (9 AM to 6 PM, 1-hour slots)
            for ($hour = 9; $hour < 18; $hour++) {
                if ($hour == 12) continue; // Skip lunch break

                $time = sprintf('%02d:00', $hour);

                // Check if slot is available
                $isBooked = \App\Models\Appointment::where('therapist_id', $therapistId)
                    ->where('appointment_date', $date->toDateString())
                    ->where('appointment_time', $time . ':00')
                    ->whereIn('status', ['scheduled', 'confirmed'])
                    ->exists();

                if (!$isBooked && ($date->isFuture() || ($date->isToday() && $hour > now()->hour))) {
                    $daySlots[] = [
                        'time' => $time,
                        'formatted_time' => \Carbon\Carbon::parse($time)->format('g:i A'),
                        'available' => true
                    ];
                }
            }

            if (!empty($daySlots)) {
                $slots[] = [
                    'date' => $date->toDateString(),
                    'formatted_date' => $date->format('M d, Y'),
                    'day_name' => $date->format('l'),
                    'slots' => $daySlots
                ];
            }
        }

        return $slots;
    }
}
