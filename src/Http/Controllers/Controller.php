<?php

namespace Larams\Cms\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $layout = 'layouts.default';

    public function view( $view, $variables = array() )
    {

        if ( isset( $this->route ) && !isset( $variables['route'] ) ) {
            $variables['route'] = $this->route;
        }

        return response()->view( $this->layout, ['content' => view( $view, $variables )]);
    }

}
