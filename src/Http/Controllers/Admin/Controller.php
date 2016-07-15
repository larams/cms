<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Larams\Cms\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{

    protected $layout = 'larams::admin.layouts.default';

    public function panic( $error ) {

        abort( 500, $error );

    }

}
