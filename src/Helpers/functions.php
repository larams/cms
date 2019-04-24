<?php

if (!function_exists('webp')) {
    function webp()
    {
        return strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
    }
}

if (!function_exists('dim')) {
    function dim(&$var, $default = null)
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
