<?php

return [

    'enabled' => true,

    'default_repository' => 'database',

    'repositories' => [
        'database' => [
            'type' => Spatie\LaravelSettings\SettingsRepositories\DatabaseSettingsRepository::class,
            'model' => Spatie\LaravelSettings\Models\SettingsProperty::class,
            'table' => 'settings',
            'cache' => [
                'enabled' => false,
                'store' => null,
                'prefix' => 'settings',
                'ttl' => null,
            ],
        ],
    ],

    'autosave' => true,

    'cache' => [
        'enabled' => false,
        'store' => null,
        'prefix' => 'settings',
        'ttl' => null,
    ],

    // إعدادات النظام
    'app_name' => 'ٍسمارت',
    'primary_color' => '#3b82f6',
    'maintenance_mode' => false,
    'app_logo' => 'logo_1747965001.jpg',

    // المفتاح المطلوب
    'migrations_paths' => [
        database_path('settings'),
    ],
];
