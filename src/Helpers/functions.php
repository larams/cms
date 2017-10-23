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