<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Larams\Cms\Permission;
use Larams\Cms\Role;
use Larams\Cms\Http\Controllers\Admin\Controller;
use Larams\Cms\StructureItem;

class RoleController extends Controller
{
    /** @var StructureItem */
    protected $structureItem;

    /** @var Permission */
    protected $permission;

    /** @var Role */
    protected $role;

    public function __construct(StructureItem $structureItem, Role $role, Permission $permission)
    {
        $this->structureItem = $structureItem;
        $this->permission = $permission;
        $this->role = $role;
    }

    public function index()
    {
        $roles = $this->role->get();
        return $this->view('larams::admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $isCreate = true;
        $permissions = $this->permission->get();
        return $this->view('larams::admin.roles.form', compact('isCreate', 'permissions'));
    }

    public function store()
    {
        $input = request()->input();
        $role = $this->role->create($input);
        if (!empty($input['permission_id'])) {
            $role->permissions()->sync($input['permission_id']);
        }
        return redirect(route('admin.roles.index'));
    }

    public function edit($id)
    {
        $role = $this->role->find($id);
        $permissions = $this->permission->get();
        $permissionIds = $role->permissions()->pluck('permission_id')->toArray();
        return $this->view('larams::admin.roles.form', compact('role', 'permissions', 'permissionIds'));
    }

    public function update($id)
    {
        $role = $this->role->find($id);
        $data = request()->input();
        $role->update($data);
        if (!empty($data['permission_id'])) {
            $role->permissions()->sync($data['permission_id']);
        }
        return redirect(route('admin.roles.index'));
    }

    public function delete($id)
    {
        $role = $this->role->find($id);
        $role->permissions()->detach();
        $role->delete();
        return redirect(route('admin.roles.index'));
    }
}
