<?php

return [
    'domain' => env('APP_DOMAIN'),
    'gallery' => true,
    'structure' => true,
    'translations' => true,
    'register_frontend_routes' => true,
    'admin' => [
        'log_admin_actions' => false,
        'allow_custom_uri' => false,
        'password_expires_in' => false, // '-2 months',
        'require_password_change' => false,
        'redirect_location' => 'admin/structure',
        'logout_url' => 'admin',
        'guard' => 'web',
        'database_model' => \Larams\Cms\User::class,
        'allowed_ips' => [],
    ],
    'locales' => [
        'lt', 'en', 'ru'
    ]
];
