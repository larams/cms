<?php

return [
    'child_tree_items_list_title' => 'admin.text.content_blocks',
    'child_tree_item_create_title' => 'admin.text.create_new_block',
    'properties' => [
        [
            'class' => 'Larams\Cms\Property\Text',
            'name' => 'short_code',
            'title' => 'Two character code'
        ],
        [
            'class' => 'Larams\Cms\Property\Text',
            'name' => 'meta_title',
            'title' => 'Meta title'
        ],
        [
            'class' => 'Larams\Cms\Property\Text',
            'name' => 'meta_description',
            'title' => 'Meta description'
        ],
    ]
];
