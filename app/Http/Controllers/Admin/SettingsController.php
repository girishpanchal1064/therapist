<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        return view('admin.settings.general');
    }

    public function updateGeneral(Request $request)
    {
        // Handle commission percentage update
        if ($request->has('therapist_commission_percentage')) {
            $commission = (float) $request->therapist_commission_percentage;
            if ($commission >= 0 && $commission <= 100) {
                Setting::setCommissionPercentage($commission);
            }
        }

        // Add other general settings updates here
        return redirect()->route('admin.settings.general')
            ->with('success', 'Settings updated successfully.');
    }

    public function roles()
    {
        return view('admin.settings.roles');
    }

    public function updateRoles(Request $request)
    {
        // Implementation for updating roles
    }

    public function system()
    {
        return view('admin.settings.system');
    }

    public function updateSystem(Request $request)
    {
        // Implementation for updating system settings
    }
}
