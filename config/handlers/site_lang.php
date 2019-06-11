<?php

return [
    'child_tree_items_list_title' => 'Content blocks',
    'child_tree_item_create_title' => 'Create new block',
    'properties' => [
        [
            'class' => Larams\Cms\Property\Text::class,
            'name' => 'short_code',
            'title' => 'Two character code'
        ],
        [
            'class' => Larams\Cms\Property\Text::class,
            'name' => 'meta_title',
            'title' => 'Meta title'
        ],
        [
            'class' => Larams\Cms\Property\Text::class,
            'name' => 'meta_description',
            'title' => 'Meta description'
        ],
    ]
];
