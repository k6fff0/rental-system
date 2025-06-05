<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\MaintenanceRequest;

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        return response()->json([
            'token' => 'dummy-token',
            'user' => $user,
        ]);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
});

Route::get('/maintenance', function () {
    $requests = MaintenanceRequest::latest()->take(10)->get()->map(function ($item) {
        return [
            'id' => $item->id,
            'issue_name' => optional($item->subSpecialty)->name ?? 'غير محدد',
            'unit_name' => optional($item->unit)->name ?? 'غير معروف',
            'status' => $item->status,
            'created_at' => $item->created_at->format('Y-m-d H:i'),
        ];
    })->values(); // ✅ هنا الإغلاق الصح

    return response()->json(['data' => $requests]);
});
