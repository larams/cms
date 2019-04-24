<?php

if (!function_exists('webp')) {
    function webp()
    {
        $acceptWebpHeader = !empty($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
        $isChrome = strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false;

//        ((is.chrome && agent.satisfies('>=23.0.0'))
//        					||  (is.opera && agent.satisfies('>=12.1'))
//        					||  (is.android && agent.satisfies('>=4.0')))

        return config('larams.enable_webp') && ( $acceptWebpHeader || $isChrome );
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
