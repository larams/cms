<?php

$properties = [

    [
        'class' => 'Talandis\Larams\Property\Rte',
        'name' => 'text',
        'title' => 'Text',
    ],

    [
        'class' => 'Talandis\Larams\Property\Date',
        'name' => 'date',
        'title' => 'Date'
    ],

    [
        'class' => 'Talandis\Larams\Property\DoubleText',
        'name' => 'doubletext',
        'title' => 'Price',
        'inputs' => [
            [
                'name' => 'old',
                'prefix' => 'Old',
                'suffix' => 'Eur',
                'class' => 'col-xs-6',
            ],
            [
                'name' => 'new',
                'prefix' => 'New',
                'suffix' => 'Eur',
                'class' => 'col-xs-6',
            ]
        ]
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
        'class' => 'Talandis\Larams\Property\Textarea',
        'name' => 'simple_text',
        'title' => 'Unformatted text',
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

];