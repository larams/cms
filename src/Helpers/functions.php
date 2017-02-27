<?php

if (!function_exists('dim')) {
    function dim(&$var, $default = NULL)
    {
        return empty($var) ? $var = $default : $var;
    }
}

if (!function_exists('bower')) {
    function bower($path)
    {
        return asset('bower_components/' . $path);
    }
}

if (!function_exists('__')) {
    function __($keyword, $params = array(), $domain = 'messages', $locale = null)
    {

        $result = trans('app.' . $keyword, $params, $domain, $locale);

        //echo "    '".$keyword."' => '',<br />";

        return str_replace('app.', '', $result);
    }
}