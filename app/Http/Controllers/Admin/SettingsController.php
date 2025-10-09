<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        return view('admin.settings.general');
    }

    public function updateGeneral(Request $request)
    {
        // Implementation for updating general settings
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
