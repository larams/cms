<?php

namespace Talandis\Larams\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Talandis\Larams\StructureItem;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $layout = 'layouts.default';

    public function beforeAction( StructureItem $structureItem, $currentLanguage, $currentSite, $currentItem )
    {

    }

    public function view( $view, $variables = array() )
    {
        return view( $this->layout, ['content' => view( $view, $variables )]);
    }

}
