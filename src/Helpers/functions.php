<?php


function bower( $path )
{
    return asset( 'bower_components/' . $path );
}

function __($keyword, $params = array(), $domain = 'messages', $locale = null)
{

    $result = trans('app.' . $keyword, $params, $domain, $locale);

    //echo "    '".$keyword."' => '',<br />";

    return str_replace('app.', '', $result);
}