<?php

namespace Larams\Cms\Model;

use Larams\Cms\Model;

/**
 * Class Redirect
 * @package Larams\Cms
 *
 */
class Redirect extends Model
{

    protected $table = 'redirects';

    protected $fillable = ['id', 'from_url', 'to_url', 'position', 'type'];

}
