<?php


namespace Larams\Cms\Helpers;

class BootstrapForm
{

    public static function input($params)
    {

        $id = empty($params['id']) ? str_replace(array('[', ']'), '', $params['name']) : $params['id'];
        $hint = '';
        $max_length = '';
        if (!empty($params['max_length'])) {

            $hint = trans('admin.text.characters_left') . ': <strong id="len_' . $id . '">' . $params['max_length'] . '</strong>';
            $max_length = 'maxlength="' . $params['max_length'] . '"';

            $hint .= '
                <script type="text/javascript">
                    $(\'#' . $id . '\').keyup( function( e ) {

                        var len = $( this ).val().length;
                        $(\'#len_' . $id . '\').text( ' . $params['max_length'] . ' - len );

                    } );
                </script>
            ';

        }

        if (!empty($params['hint'])) {
            $hint .= (!empty( $hint) ? '<br />' : '') . $params['hint'];
        }

        if (!empty($hint)) {
            $hint = '<span class="help-block" style="margin-top: 3px;">' . $hint . '</span>';
        }

        $disabled = '';
        if (!empty($params['disabled'])) {
            $disabled = ' disabled="disabled" ';
        }

        $html = '
             <div class="form-group">
                <label for="' . $id . '" class="control-label">' . $params['title'] . '</label>
                <div class="">
                    <input 
                    ' . $max_length . $disabled . ' 
                    type="' . (!empty($params['type']) ? $params['type'] : 'text') . '" 
                    name="' . $params['name'] . '" 
                    class="form-control ' . (!empty($params['class']) ? $params['class'] : '') . '" 
                    id="' . $id . '" 
                    value="' . htmlspecialchars(array_key_exists('value', $params) ? $params['value'] : '', ENT_QUOTES, 'UTF-8') . '"
                    >
                    ' . $hint . '
                </div>
            </div>
        ';

        return $html;

    }

    public static function checkbox($params)
    {
        $id = empty($params['id']) ? str_replace(array('[', ']'), '', $params['name']) : $params['id'];

        $html = '
             <div class="checkbox">
                <label for="' . $id . '">
                    <input type="hidden" name="'. $params['name'].'" value="0" />
                    <input 
                    ' . (!empty($params['checked']) ? 'checked="checked"' : '') . ' 
                    type="' . (!empty($params['type']) ? $params['type'] : 'checkbox') . '" 
                    name="' . $params['name'] . '" 
                    class="' . (!empty($params['class']) ? $params['class'] : '') . '" 
                    id="' . $id . '" 
                    value="' . htmlspecialchars(array_key_exists('value', $params) ? $params['value'] : '1', ENT_QUOTES, 'UTF-8') . '"
                    >
                    ' . $params['title'] . '
                </label>
            </div>
        ';

        return $html;
    }

    public static function textarea($params)
    {
        $id = empty($params['id']) ? str_replace(array('[', ']'), '', $params['name']) : $params['id'];
        $hint = '';
        $rows = '';

        if (!empty($params['rows'])) {
            $rows .= ' rows="' . $params['rows'] . '" ';
        }

        if (!empty($params['hint'])) {
            $hint .= (!empty( $hint) ? '<br />' : '') . $params['hint'];
        }

        if (!empty($hint)) {
            $hint = '<span class="help-block" style="margin-top: 3px;">' . $hint . '</span>';
        }

        $disabled = '';
        if (!empty($params['disabled'])) {
            $disabled = ' disabled="disabled" ';
        }

        $html = '
             <div class="form-group">
                <label for="' . $id . '" class="control-label">' . $params['title'] . '</label>
                <div class="">
                    <textarea 
                    ' . $disabled . ' 
                    ' . $rows . '
                    name="' . $params['name'] . '" 
                    class="form-control ' . (!empty($params['class']) ? $params['class'] : '') . '" 
                    id="' . $id . '" 
                    >' . htmlspecialchars(array_key_exists('value', $params) ? $params['value'] : '', ENT_QUOTES, 'UTF-8') . '</textarea>
                    ' . $hint . '
                </div>
            </div>
        ';

        return $html;

    }

    public static function rte($params)
    {


    }

    public static function select($params)
    {

        $html = '
             <div class="form-group">
                <label for="' . $params['name'] . '" class="control-label">' . $params['title'] . '</label>
                <div class="">
                    <select ' . (!empty($params['multiple']) ? 'multiple' : '') . ' name="' . $params['name'] . '" class="form-control ' . (!empty($params['class']) ? $params['class'] : '') . '" id="' . $params['name'] . '">
        ';

        if (!empty($params['empty'])) {
            $html .= '<option value="">' . (!empty($params['empty_title']) ? $params['empty_title'] : '') . '</option>';
        }

        foreach ($params['values'] as $key => $value) {

            if (is_array($value)) {
                $option_key = !empty($params['option_key']) && isset($value[$params['option_key']]) ? $value[$params['option_key']] : $key;
                $option_value = !empty($params['option_value']) && isset($value[$params['option_value']]) ? $value[$params['option_value']] : $value;
            } else {
                $option_key = !empty($params['option_key']) && isset($value->{$params['option_key']}) ? $value->{$params['option_key']} : $key;
                $option_value = !empty($params['option_value']) && isset($value->{$params['option_value']}) ? $value->{$params['option_value']} : $value;
            }

            $html .= '<option ' . ((!empty($params['value']) && $option_key == $params['value']) || (!empty($params['ids']) && (in_array($option_key, $params['ids']))) ? 'selected="selected"' : '') . ' value="' . $option_key . '">' . $option_value . '</option>';
        }

        $html .= '
                    </select>
                </div>
            </div>
        ';

        return $html;

    }

}
