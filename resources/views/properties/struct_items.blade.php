<div class="clearfix">


@if ( $style == 'SELECT' )
    <select name="data[{{$name}}]" class="form-control">
@endif

    @if ( !empty( $allowEmpty ) && empty( $multiple ) )
        <div class="checkbox"><label><input type="radio" name="data[{{$name}}]" value=""  /> {{__("Not selected")}}</label></div>
    @endif

    @foreach ( $childs as $child )



    @endforeach

@if ( $style == 'SELECT' )
    </select>
@endif

</div>
{{--
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

            $ret_val .= '';

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

}

return ($ret_val);

--}}