<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view notifications')->only(['index', 'show']);
        $this->middleware('permission:create notifications')->only(['create', 'store']);
        $this->middleware('permission:edit notifications')->only(['edit', 'update']);
        $this->middleware('permission:delete notifications')->only(['destroy']);
    }

    public function index()
    {
        return view('admin.notifications.index');
    }
}
