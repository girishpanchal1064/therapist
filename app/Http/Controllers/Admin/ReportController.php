<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function users()
    {
        return view('admin.reports.users');
    }

    public function appointments()
    {
        return view('admin.reports.appointments');
    }

    public function financial()
    {
        return view('admin.reports.financial');
    }
}
