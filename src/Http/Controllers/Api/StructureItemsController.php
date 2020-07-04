<?php

namespace Larams\Cms\Http\Controllers\Api\Admin;

use Larams\Cms\Http\Controllers\Api\CrudController;
use Larams\Cms\Repository\StructureItems;
use Illuminate\Http\Request;
use Larams\Cms\Model\StructureItem;

class StructureItemsController extends CrudController
{
    protected $languageTypeName = 'site_lang';

    public function __construct(StructureItem $model, StructureItems $repository, Request $request)
    {
        $this->model = $model;
        $this->repository = $repository;

        parent::__construct($request);
    }

    public function getLanguages()
    {
        return $this->model->byTypeName($this->languageTypeName)->orderBy('left')->get();
    }
}
