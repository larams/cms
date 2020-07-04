<?php

return [
    'domain' => env('APP_DOMAIN'),
    'gallery' => true,
    'structure' => true,
    'translations' => true,
    'register_frontend_routes' => true,
    'enable_webp' => false,
    'tinify_api_key' => '',
    'force_file_download' => false,
    'common_permissions' => [],
    'admin' => [
        'translations' => [
            'enable_xlf' => false
        ],
        'rte_hint' => '',
        'allow_folder_moving' => true,
        'log_admin_actions' => false,
        'allow_custom_uri' => false,
        'password_expires_in' => false, // '-2 months',
        'require_password_change' => false,
        'redirect_location' => 'admin/structure',
        'logout_url' => 'admin',
        'guard' => 'web',
        'database_model' => \Larams\Cms\Model\User::class,
        'allowed_ips' => [],
        'menu_items' => [
            [
                'route' => 'admin.structure.index',
                'title' => 'admin.menu.content',
            ],
            [
                'route' => 'admin.gallery.index',
                'title' => 'admin.menu.gallery'
            ],
            [
                'route' => 'admin.translations.index',
                'title' => 'admin.menu.translations'
            ],
            [
                'route' => 'admin.administrators.index',
                'title' => 'admin.menu.administrators'
            ],
            [
                'route' => 'admin.redirects.index',
                'title' => 'admin.menu.redirects'
            ],
            [
                'route' => 'admin.types.index',
                'title' => 'admin.menu.content_types'
            ],
            [
                'route' => 'admin.permissions.index',
                'title' => 'admin.menu.permissions'
            ],
            [
                'route' => 'admin.roles.index',
                'title' => 'admin.menu.roles'
            ]
        ]
    ],
    'locales' => [
        'lt',
        'en',
        'ru'
    ]
];
