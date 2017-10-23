<?php

return [

    'gallery' => true,
    'register_frontend_routes' => true,
    'admin' => [
        'password_expires_in' => false, // '-2 months',
        'require_password_change' => false,
        'redirect_location' => 'admin/structure',
        'guard' => 'web',
        'database_model' => \Larams\Cms\User::class,
        'allowed_ips' => [],
    ],
    'locales' => [
        'lt', 'en', 'ru'
    ]
];