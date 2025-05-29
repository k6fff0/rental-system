<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{


    public function index()
    {
        $user = Auth::user();

        // عرض كل الإشعارات الأحدث أولاً
        $notifications = $user->notifications()->latest()->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $notification = $user->notifications()->findOrFail($id);

        // تعليم الإشعار كمقروء
        if ($notification->unread()) {
            $notification->markAsRead();
        }

        // لو فيه URL مرفق نوجه المستخدم ليه
        $url = $notification->data['url'] ?? null;

        return $url ? redirect($url) : back();
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'تم تمييز جميع الإشعارات كمقروءة.');
    }
}
