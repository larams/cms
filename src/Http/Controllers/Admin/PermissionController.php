<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Larams\Cms\Permission;
use Larams\Cms\Http\Controllers\Admin\Controller;
use Larams\Cms\StructureItem;

class PermissionController extends Controller
{
    /** @var StructureItem */
    protected $structureItem;

    /** @var Permission */
    protected $permission;

    public function __construct(StructureItem $structureItem, Permission $permission)
    {
        $this->structureItem = $structureItem;
        $this->permission = $permission;
    }

    public function index()
    {
        $permissions = $this->permission->get();
        return $this->view('larams::admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $isCreate = true;
        return $this->view('larams::admin.permissions.form', compact('isCreate'));
    }

    public function store()
    {
        $input = request()->input();
        $permission = $this->permission->create($input);
        return redirect(route('admin.permissions.index'));
    }

    public function edit($id)
    {
        $permission = $this->permission->find($id);
        return $this->view('larams::admin.permissions.form', compact('permission'));
    }

    public function update($id)
    {
        $permission = $this->permission->find($id);
        $data = request()->input();
        $permission->update($data);
        return redirect(route('admin.permissions.index'));
    }

    public function delete($id)
    {
        $permission = $this->permission->find($id);
        $permission->delete();

        return redirect(route('admin.permissions.index'));
    }
}
