<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Admin');
    }

    public function index()
    {
        return view('admin.permissions.index', ['permissions' => Permission::all()]);
    }

    public function store(Request $request)
    {
        $tableNames = config('permission.table_names');
        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding.');
        }
        $data = $request->validate(['name' => 'required|string|max:64|min:3|unique:'. $tableNames['permissions']]);
        Permission::create($data);
        return redirect()->route('admin.permissions.index')->withSuccess('Berhasil membuat permission baru');
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $users = User::permission($permission->name)->get();
        foreach($users as $user) $user->revokePermissionTo($permission->name);
        $permission->delete();
        return redirect()->route('admin.permissions.index')->withSuccess('Berhasil menghapus permission');
    }
}
