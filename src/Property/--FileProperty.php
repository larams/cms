<?php

/**
 * Import required classes
 */

ClassUtils::import( 'services.properties.AProperty' );


/**
 * ImageProperty class
 * @access public
 */

class FileProperty extends AProperty {


	/**
	 * Get default service configuration
	 * @access public
	 * @return array
	 */

	function getConfigDef() {

		$service_config_def	= array(

			'depends' => array(
				'StructService:struct' => '',
			),

		);

		return( $this->mergeConfig( parent::getConfigDef(), $service_config_def ) );

	}


	/**
	 * Push data to data pool ( output mode )
	 * @param array &$data Reference to data pool
	 * @return bool Success?
	 */

	function pushData( &$data ) {

		$ret_val = FALSE;

		if( $this->_configured ) {

			$data[$this->_config['name']] = isset( $this->_intern_data[$this->_config['name']]['file'] ) ? $this->_intern_data[$this->_config['name']]['file'] : array();
			$ret_val = TRUE;

		}

		return( $ret_val );

	}


	/**
	 * Push data to data pool ( internal mode )
	 * @param array &$data Reference to data pool
	 * @return bool Success?
	 */

	function pushInternData( &$data ) {

		$ret_val = FALSE;

		if( $this->_configured ) {

			$data[$this->_config['name']] = isset( $this->_intern_data[$this->_config['name']] ) ? $this->_intern_data[$this->_config['name']] : array();

			$ret_val = TRUE;

		}

		return( $ret_val );

	}


	function pickEditorData( &$data ) {

		$ret_val = FALSE;

		if( $this->_configured ) {

			$this->_intern_data = array();

			if( isset( $data[$this->_config['name']] ) ) {

				$this->_intern_data[$this->_config['name']] = array();

				$oStruct = &$this->getDependService( 'struct' );

				$image_item = $oStruct->getItems( array( 'item_id' => $data[$this->_config['name']], 'data_dynamic' => TRUE, 'uncond' => TRUE, 'single' => TRUE ) );

				if( count( $image_item ) > 0 ) {

					$oItemHandler = &$image_item['item_handler'];

					if( count( $oItemHandler->_config['item']['item_data_handler'] ) > 0 ) {

						$this->_intern_data[$this->_config['name']]['file'] = $oItemHandler->_config['item']['item_data_handler']['file_original'];

					}

				}

			}

			$ret_val = TRUE;

		}

		return( $ret_val );

	}


	/**
	 * Get editor ( editing output )
	 * @access public
	 * @param string $prefix Prefix for form item names
	 * @return string Editor, can be used for administration output
	 */

	function getEditor( $prefix = '' ) {

	//<img style="margin: 10px;" id="property_' . $this->_config['name'] . '_thumb" src="' . ( isset( $this->_intern_data[$this->_config['name']]['thumb']['url'] ) ? $this->_intern_data[$this->_config['name']]['thumb']['url'] : '{$env.img_url}folder.gif' ) . '" />

		if ( !empty( $this->_intern_data[ $this->_config['name'] ] ) ) {

			$ret_val = '

				<div>
					<span id="property_'. $this->_config['name'].'_name"> '. $this->_intern_data[ $this->_config['name'] ]['file']['name'] . ' ('. $this->_intern_data[ $this->_config['name'] ]['file']['url'] .') </span>


					<input name="' . $prefix . '[' . $this->_config['name'] . ']" type="hidden" id="property_' . $this->_config['name'] . '_value" value="' . ( isset( $this->_intern_data[$this->_config['name']]['file']['item_parent_id'] ) ? $this->_intern_data[$this->_config['name']]['file']['item_parent_id'] : '' ) . '" />
					<input type="button" onclick="javascript: window.open( \'{url act=\'mediaselect\' target=\'' . $this->_config['name'] . '\'}\' );" class="btn btn-xs btn-default" value="Pasirinkti.." />
				</div>
				';

		} else {

			$ret_val = '

				<div>
					<span id="property_'. $this->_config['name'].'_name"> Nepasirinkta </span>


					<input name="' . $prefix . '[' . $this->_config['name'] . ']" type="hidden" id="property_' . $this->_config['name'] . '_value" value="' . ( isset( $this->_intern_data[$this->_config['name']]['image']['item_parent_id'] ) ? $this->_intern_data[$this->_config['name']]['image']['item_parent_id'] : '' ) . '" />
					<input type="button" onclick="javascript: window.open( \'{url act=\'mediaselect\' target=\'' . $this->_config['name'] . '\'}\' );" class="btn btn-xs btn-default" value="Pasirinkti.." />
				</div>
				';
		}

		return( $ret_val );

	}

}

?>