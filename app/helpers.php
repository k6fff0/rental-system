<?php

use App\Settings\SystemSettings;
use App\Models\ActivityLog;

if (!function_exists('settings')) {
    function settings(): SystemSettings
    {
        return app(SystemSettings::class);
    }
}

if (!function_exists('log_action')) {
    function log_action(string $message): void
    {
        // لو المستخدم مسجل دخول
        $userId = auth()->check() ? auth()->id() : null;

        ActivityLog::create([
            'user_id'     => $userId,
            'description' => $message,
        ]);
    }
}
