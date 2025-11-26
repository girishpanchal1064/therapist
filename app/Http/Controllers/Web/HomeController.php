<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AreaOfExpertise;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured therapists (top rated and verified)
        $featuredTherapists = User::role('Therapist')
            ->whereHas('therapistProfile', function($q) {
                $q->where('is_verified', true)
                  ->where('is_available', true);
            })
            ->with(['therapistProfile.specializations', 'profile'])
            ->get()
            ->sortByDesc(function($therapist) {
                return $therapist->therapistProfile->rating_average ?? 0;
            })
            ->take(6);

        // Get active areas of expertise
        $areasOfExpertise = AreaOfExpertise::active()->ordered()->get();

        return view('web.home', compact('featuredTherapists', 'areasOfExpertise'));
    }
}
