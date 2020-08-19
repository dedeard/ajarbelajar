<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage role');
    }

    public function index()
    {
        SEOMeta::setTitle('Daftar Role');
        return view('roles.index', [ 'roles' => Role::all() ]);
    }

    public function create()
    {
        SEOMeta::setTitle('Buat Role');
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $tableNames = config('permission.table_names.roles');
        $data = $request->validate(['name' => 'required|string|max:64|min:3|unique:'. $tableNames]);
        Role::create($data);
        return redirect()->route('roles.index')->withSuccess('Berhasil membuat Role baru.');
    }

    public function edit($id)
    {
        SEOMeta::setTitle('Edit Role');
        $role = Role::where('name', '!=', 'Super Admin')->findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', ['role' => $role, 'permissions' => $permissions]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::where('name', '!=', 'Super Admin')->findOrFail($id);
        $tableNames = config('permission.table_names.roles');
        $data = $request->validate(['name' => 'required|string|max:64|min:3|unique:'. $tableNames . ',name,' . $id]);
        $role->update($data);
        return redirect()->back()->withSuccess('Berhasil memperbarui Role.');
    }

    public function destroy($id)
    {
        $role = Role::where('name', '!=', 'Super Admin')->findOrFail($id);
        $users = User::role($role->name)->get();
        foreach($users as $user) $user->removeRole($role->name);
        $role->delete();
        return redirect()->route('roles.index')->withSuccess('Berhasil menghapus Role.');
    }

    public function toggleSyncPermission($role_id, $permission_id)
    {
        $role = Role::where('name', '!=', 'Super Admin')->findOrFail($role_id);
        $permission = Permission::findOrFail($permission_id);

        if($role->hasPermissionTo($permission->name)) {
            $role->revokePermissionTo($permission->name);
        } else {
            $role->givePermissionTo($permission->name);
        }

        return redirect()->back()->withSuccess('Berhasil memperbarui role permission.');
    }
}
