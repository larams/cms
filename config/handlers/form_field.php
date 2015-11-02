<?php

$config = array(

	'class' 		=> 'services.handlers.PropertyCollectionHandler',
	'cms_action'	=> 'handlers/property_collection',

	'properties'	=> array(

		array(

			'class' => 'services.properties.SelectProperty',

			'name'		=> 'required',

			'options'	=> array(

				array(
					'value' => '1',
					'title' => 'Taip',
				),

				array(
					'value' => '0',
					'title' => 'Ne',
				),
			),
		),
	),
);

return( $config );

?>