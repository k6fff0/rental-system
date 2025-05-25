<?php

use App\Settings\SystemSettings;

if (!function_exists('settings')) {
    function settings(): SystemSettings
    {
        return app(SystemSettings::class);
    }
}
