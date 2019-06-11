<?php

$properties = [

    [
        'class' => Larams\Cms\Property\Rte::class,
        'name' => 'text',
        'title' => 'Text',
        'hint' => '',
    ],
    [
        'class' => Larams\Cms\Property\File::class,
        'name' => 'file',
        'title' => 'Attached file',
    ],
    [
        'class' => Larams\Cms\Property\Text::class,
        'name' => 'single_line_text',
        'title' => 'Text single line'
    ],

    [
        'class' => Larams\Cms\Property\StructureItems::class,
        'name' => 'item_id',
        'title' => 'Element',
        'allowEmpty' => true,
        'multiple' => true,
        'firstLevel' => false,
        'typeName' => 'site_lang',
        'style' => 'SELECT',    // Leave empty for Checkbox/Radio style
    ],
    [
        'class' => Larams\Cms\Property\Date::class,
        'name' => 'date',
        'title' => 'Date'
    ],

    [
        'class' => Larams\Cms\Property\DoubleText::class,
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
        'class' => Larams\Cms\Property\Select::class,
        'name' => 'color',
        'title' => 'Color',
        'options' => [
            0 => 'No',
            1 => 'Yes',
        ],
    ],

    [
        'class' => Larams\Cms\Property\Textarea::class,
        'name' => 'simple_text',
        'title' => 'Unformatted text',
    ],
    [
        'class' => Larams\Cms\Property\StructureText::class,
        'name' => 'multi_items',
        'splitByType' => 'site',
        'typeName' => 'site_lang',
        'inputWidthClass' => 'col-xs-3',
        'title' => 'Text for every language'
    ],
    [
        'class' => Larams\Cms\Property\Image::class,
        'name' => 'image',
        'title' => 'Image',
        'format' => 'png',
        'automatic' => false,
        'versions' => [
            'lg' => [
                'width' => 200,
                'height' => 100
            ],
            'xs' => [
                'width' => 100,
                'height' => 50,
            ]
        ]
    ],

];
