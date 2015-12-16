<?php

return [
	'class' 		=> 'services.handlers.PropertyCollectionHandler',
	'cms_action'	=> 'handlers/property_collection',
	'properties'	=> [
		[
			'class' => 'services.properties.SelectProperty',
			'name'		=> 'required',
			'options'	=> [

				[
					'value' => '1',
					'title' => 'Taip',
				],

				[
					'value' => '0',
					'title' => 'Ne',
				],
			],
		],
	],
];