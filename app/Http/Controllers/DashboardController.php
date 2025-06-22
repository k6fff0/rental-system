<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();


        $requestCount = \App\Models\MaintenanceRequest::where('assigned_worker_id', $user->id)->count();

        return view('dashboard', compact('requestCount'));
    }
}
