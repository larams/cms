<?php

$properties = [

    [
        'class' => 'Larams\Cms\Property\Rte',
        'name' => 'text',
        'title' => 'Text',
    ],

    [
        'class' => 'Larams\Cms\Property\Text',
        'name' => 'single_line_text',
        'title' => 'Text single line'
    ],

    [
        'class' => 'Larams\Cms\Property\StructureItems',
        'name' => 'item_id',
        'title' => 'Element',
        'allowEmpty' => true,
        'multiple' => true,
        'firstLevel' => false,
        'typeName' => 'site_lang',
        'style' => 'SELECT',    // Leave empty for Checkbox/Radio style
    ],
    [
        'class' => 'Larams\Cms\Property\Date',
        'name' => 'date',
        'title' => 'Date'
    ],

    [
        'class' => 'Larams\Cms\Property\DoubleText',
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
        'class' => 'Larams\Cms\Property\Select',
        'name' => 'color',
        'title' => 'Color',
        'options' => [
            0 => 'No',
            1 => 'Yes',
        ],
    ],

    [
        'class' => 'Larams\Cms\Property\Textarea',
        'name' => 'simple_text',
        'title' => 'Unformatted text',
    ],

    [
        'class' => 'Larams\Cms\Property\Image',
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