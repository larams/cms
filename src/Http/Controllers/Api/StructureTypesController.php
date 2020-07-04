<?php

namespace App\Http\Controllers\Api\Admin;

use Larams\Cms\Http\Controllers\Api\CrudController;
use Larams\Cms\Repository\StructureTypes;
use Illuminate\Http\Request;
use Larams\Cms\Model\StructureType;

class StructureTypesController extends CrudController
{
    public function __construct(StructureType $model, StructureTypes $repository, Request $request)
    {
        $this->model = $model;
        $this->repository = $repository;

        parent::__construct($request);
    }

    protected function getHandlers()
    {
        return $this->model->getHandlers();
    }

}
