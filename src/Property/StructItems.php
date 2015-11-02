<?php

namespace Talandis\Larams\Property;

use Talandis\Larams\Property;
use Talandis\Larams\StructureItem;

class StructItems extends Property
{

    protected $rows = 5;

    protected $cssClass = 'col-xs-6';

    protected $typeName = null;

    protected $style = null;

    protected $firstLevel = false;

    protected $multiple = false;

    protected $allowEmpty = false;

    public function getHtml()
    {

        $structureItems = new StructureItem();

        $topLevelItem = $structureItems->byTypeName( $this->typeName )->get();

        if (!empty( $this->firstLevel )) {
            $childs = $structureItems->where('parent_id', $topLevelItem->id )->get();
        } else {
            $childs = $structureItems->where('left', '>', $topLevelItem->left )->where('right', '<', $topLevelItem->right )->orderBy('left')->get();
        }


        $configuration = array(
            'cssClass' => $this->cssClass,
            'typeName' => $this->typeName,
            'style' => $this->style,
            'firstLevel' => $this->firstLevel,
            'multiple' => $this->multiple,
            'allowEmpty' => $this->allowEmpty,
            'item' => $this->item,
            'name' => $this->name,
            'childs' => $childs
        );

        return view('larams::properties.struct_items', $configuration);

    }
}


/**
 * Import required classes
 */

ClassUtils::import('services.properties.AProperty');


/**
 * SelectProperty class
 * @access public
 */
class StructItemsProperty extends AProperty
{


    /**
     * Get default service configuration
     * @access public
     * @return array
     */

    function getConfigDef()
    {

        $service_config_def = array(

            'options' => array(),        // Available options
            'css_class' => 'col-xs-6',
            'depends' => array(
                'StructService:struct' => 'struct',
            ),

            'type_name' => '',
            'style' => '',
            'first_level' => false,
            'multiple' => false,
            'allow_empty' => false,

        );

        return ($this->mergeConfig(parent::getConfigDef(), $service_config_def));

    }

    /*
        function pushData( &$data ) {

            $ret_val = FALSE;

            if( $this->_configured ) {

    //          $data[$this->_config['name']] = isset( $this->_intern_data[$this->_config['name']]['image'] ) ? $this->_intern_data[$this->_config['name']]['image'] : array();
                $ret_val = TRUE;

            }

            return( $ret_val );

        }
    */

    /**
   	 * Pick editor data and set it to internal data
   	 * @access public
   	 * @param array $data
   	 * @return bool Success?
   	 */

   	function pickEditorData( &$data ) {

   		$ret_val = FALSE;

   		if( $this->_configured ) {

   			if( isset( $data[$this->_config['name']] ) ) {

   				$this->_intern_data[$this->_config['name']] = $data[$this->_config['name']];

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

    function getEditor($prefix = '')
    {

        // Default return value ;)
        $ret_val = 'Failed to get property editor';

        if ($this->_configured) {

            $oStruct = $this->getDependService('struct');

            if (!empty($this->_config['type_name'])) {

                $top_level_item = $oStruct->getItem(array('type_name' => $this->_config['type_name'], 'child_and' => $GLOBALS['oActions']->_AG['_lang_curr']['item_id'], 'item_active' => FALSE, 'item_tree' => FALSE));
            } else {
                $top_level_item = $oStruct->getItem(array('type_name' => $this->_config['type_name'], 'child_and' => $GLOBALS['oActions']->_AG['_path_curr']['item_id'], 'item_active' => FALSE, 'item_tree' => FALSE));
            }

            $childs = $oStruct->getItems(array( ($this->_config['first_level'] ? 'item_parent_id' : 'child_and') => $top_level_item['item_id'], 'item_active' => FALSE, 'item_tree' => FALSE, 'sort_by' => 'item_left'));

            if ($this->pushData($data)) {

                $ret_val = '';

                if ($this->_config['style'] == 'SELECT') {
                    $ret_val .= '<select name="' . $prefix . '[' . $this->_config['name'] . ']" class="form-control">';
                }

                if (!empty( $this->_config['allow_empty']) && empty( $this->_config['multiple'])) {

                    $ret_val .= '<div class="checkbox"><label><input type="radio" name="' . $prefix . '[' . $this->_config['name'] . ']'. ( $this->_config['multiple'] ? '[]' : '' ) .'" value=""  /> Nepasirinkta</label></div>';

                }

                foreach ($childs as $k => $child) {

                    $has_childs = $childs[$k + 1]['item_level'] > $child['item_level'];

                    $disabled = '';
                    if ($has_childs) {
                        $disabled = 'style="display: none;"';
                    }

                    $is_selected = !empty($data[$this->_config['name']]) && ( (is_array( $data[$this->_config['name']] ) && in_array($child['item_id'], $data[$this->_config['name']]) ) || (!is_array( $data[ $this->_config['name']]) && $child['item_id'] == $data[$this->_config['name']]) );

                    if ($this->_config['style'] == 'SELECT') {

                        $whitespaces = '';
                        $i = 0;
                        while( $i < ($child['item_level'] - $childs[0]['item_level']) ) {
                            $whitespaces .= '&nbsp;&nbsp;&nbsp;';
                            $i++;
                        }

                        $ret_val .= '<option' . ( $is_selected ? 'selected="selected"' : '') . ' value="' . $child['item_id'] . '">' . $whitespaces . $child['item_name'] . '</option>';

                    } else {

                        $ret_val .= '<div class="checkbox">
                                          <label style="padding-left: ' . (($child['item_level'] - $childs[0]['item_level'] + 1) * 20 ) . 'px;">
                                            <input ' . $disabled . ' type="'. ( $this->_config['multiple'] ? 'checkbox' : 'radio' ) .'" ' . ( $is_selected ? 'checked="checked"' : '') . ' name="' . $prefix . '[' . $this->_config['name'] . ']'. ( $this->_config['multiple'] ? '[]' : '' ) .'" value="' . $child['item_id'] . '" />
                                            ' . $child['item_name'] . '
                                          </label>
                                      </div>
                                ';
                    }


                }

                if ($this->_config['style'] == 'SELECT') {
                    $ret_val .= '</select>';
                }

            }

            /*

                        $data = array();

                        // Push output data
                        if( $this->pushData( $data ) ) {

                            $ret_val  = '<select class="'.$this->_config['css_class'].'" name="' . $prefix . '[' . $this->_config['name'] . ']">';

                            foreach( $this->_config['options'] as $option ) {
                                $ret_val .= '<option value="' . $option['value'] . '"' . ( ( $option['value'] == $data[$this->_config['name']] ) ? ' selected="selected"' : '' ) . '>' . $option['title'] . '</option>';
                            }

                            $ret_val .= '</select>';

                        }
            */

        }

        return ($ret_val);

    }


}