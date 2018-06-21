<?php


namespace Larams\Cms\Helpers;

class BootstrapForm
{

    public static function input($params)
    {

        $id = str_replace(array('[', ']'), '', $params['name']);
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
            $hint .= '<br />' . $params['hint'];
        }

        if (!empty($hint)) {
            $hint = '<span class="help-block" style="color: #888; margin-top: 3px;">' . $hint . '</span>';
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

    public static function rte($params)
    {


    }

    public static function select($params)
    {

        $html = '
             <div class="form-group">
                <label for="' . $params['name'] . '" class="control-label">' . $params['title'] . '</label>
                <div class="">
                    <select name="' . $params['name'] . '" class="form-control ' . (!empty($params['class']) ? $params['class'] : '') . '" id="' . $params['name'] . '">
        ';

        foreach ($params['values'] as $key => $value) {

            $option_key = !empty($params['option_key']) && isset($value[$params['option_key']]) ? $value[$params['option_key']] : $key;
            $option_value = !empty($params['option_value']) && isset($value[$params['option_value']]) ? $value[$params['option_value']] : $value;

            $html .= '<option ' . (!empty($params['value']) && $option_key == $params['value'] ? 'selected="selected"' : '') . ' value="' . $option_key . '">' . $option_value . '</option>';
        }

        $html .= '
                    </select>
                </div>
            </div>
        ';

        return $html;

    }

}
