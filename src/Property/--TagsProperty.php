<?php

/**
 * Import required classes
 */

ClassUtils::import( 'services.properties.AProperty' );


/**
 * SelectProperty class
 * @access public
 */

class TagsProperty extends AProperty {


	/**
	 * Get default service configuration
	 * @access public
	 * @return array
	 */

	function getConfigDef() {

		$service_config_def	= array(
			'depends' => array(
				'AService:dbi'			=> 'cms_dbi',
			),

			'options'			=> array(),		// Available options

		);

		return( $this->mergeConfig( parent::getConfigDef(), $service_config_def ) );

	}


	/**
	 * Get editor ( editing output )
	 * @access public
	 * @param string $prefix Prefix for form item names
	 * @return string Editor, can be used for administration output
	 */

	function getEditor( $prefix = '' ) {

		$oDbi = $this->getDependService( 'dbi' );

		$tags = $oDbi->getAll("SELECT * FROM {#prefix}tags ORDER BY title ASC" );

		// Default return value ;)
		$ret_val = 'Failed to get property editor';

		if( $this->_configured ) {

			$data = array();

			// Push output data
			if( $this->pushData( $data ) ) {

				$ret_val  = '<select multiple="multiple" size="10" class="form-control chosen tag-select" style="width: 300px;" name="' . $prefix . '[' . $this->_config['name'] . '][]">';

/*
				echo '<pre>'; var_dump( $tags ); echo '</pre>';

				echo '<pre>'; var_dump( $data ); echo '</pre>';
				die( '<span style="color: #0A0;">'. __FILE__ .'</span>:'. __LINE__ );
*/

				foreach( $tags as $option ) {
					$ret_val .= '<option value="' . $option['tag_id'] . '"' . ( ( in_array( $option['tag_id'], (array)$data[$this->_config['name']] ) ) ? ' selected="selected"' : '' ) . '>' . $option['title'] . '</option>';
				}

				$ret_val .= '</select><div class="clr"></div>';
            	$ret_val .= '<div class="fl" style="margin-top: 7px; margin-right: 3px;"> Nauja žymė: </div><input class="text fl tag-input" value="" style="width:' . $this->_config['width'] . ';" /> <a style="margin-top: 4px;" class="button blue fl tag-add" href="#"> Pridėti </a>';


                $ret_val .= '
                    <script type="text/javascript">

                        $(".tag-add").click( function() {ldelim}

                            var $input = $( this ).prev(".tag-input");
                            var $select = $( this ).parent().find(".tag-select");
                            var value = $input.val();

                            $input.val("");

                            $select.append("<option selected=\"selected\" value=\"" + value + "\">" + value + "</option>" );

                            return false;

                        } );


                    </script>
                ';

			}

		}

		return( $ret_val );

	}

	function pickEditorData( &$data ) {

	   $tag_ids = array();
        $oDbi = $this->getDependService( 'dbi' );

	   foreach ( (array)$data[ $this->_config['name'] ]  as $tag ) {

	       if ( !is_numeric( $tag ) ) {

	           $db_tag = $oDbi->getRow("SELECT * FROM {#prefix}tags WHERE title = '".$tag."'" );

	           if ( empty( $db_tag ) ) {
    	           $tag_ids[] = $oDbi->insert( '{#prefix}tags', array('title' => $tag ) );
	           } else {
	               $tag_ids[] = $db_tag['tag_id'];
	           }

	       } else {
	           $tag_ids[] = $tag;
	       }

	   }

	   $this->_intern_data[$this->_config['name']] = $tag_ids;

       return TRUE;
	}
}

?>