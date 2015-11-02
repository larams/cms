<?php

namespace Talandis\Larams\Http\Controllers\Admin;

use Talandis\Larams\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{

    protected $layout = 'larams::admin.layouts.default';

    public function panic( $error ) {

        abort( 500, $error );

    }

}
