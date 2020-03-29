<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Admin');
    }

    public function index()
    {
        return view('admin.roles.index', ['roles' => Role::all()]);
    }

    public function update($id, $permission_id, $action)
    {
        $role = Role::findOrFail($id);
        $permission = Permission::findOrFail($permission_id);
        if($action === 'sync') {
            $role->givePermissionTo($permission->name);
        } else {
            $role->revokePermissionTo($permission->name);
        }
        return redirect()->back()->withSuccess('Role berhasil diupdate');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('admin.roles.edit', ['role' => $role, 'permissions' => $permissions]);
    }
}
