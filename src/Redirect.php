<?php

namespace Larams\Cms;

/**
 * Class Redirect
 * @package Larams\Cms
 *
 */
class Redirect extends \Eloquent
{

    protected $table = 'redirects';

    protected $fillable = ['id', 'from_url', 'to_url', 'position', 'type'];

}
