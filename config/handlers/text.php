<?php

$config = [
    'properties' => [
        [
            'class' => Larams\Cms\Property\Rte::class,
            'name' => 'text',
            'title' => 'Text',
            'hint' => config('larams.admin.rte_hint'),
        ],
    ],
];

return ($config);
