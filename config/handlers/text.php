<?php

$config = [
    'properties' => [
        [
            'class' => 'Talandis\Larams\Property\Rte',
            'name' => 'text',
            'title' => 'Text',
        ],


        [
            'class' => 'Talandis\Larams\Property\Select',
            'name' => 'color',
            'title' => 'Color',
            'options' => [
                0 => 'No',
                1 => 'Yes',
            ],
        ],

        [
            'class' => 'Talandis\Larams\Property\Image',
            'name' => 'image',
            'title' => 'Image',
            'format' => 'png',
            'versions' => [
                'default' => [
                    'width' => 200,
                    'height' => 100
                ],
            ]
        ],
    ],
];

return ($config);
