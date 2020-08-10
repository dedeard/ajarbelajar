<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{

    public function index()
    {
        SEOMeta::setTitle("Kelola Permissions");
        return view('admin::permissions.index', ['permissions' => Permission::all()]);
    }

    public function create()
    {
        SEOMeta::setTitle("Buat Permission");
        return view('admin::permissions.create');
    }

    public function store(Request $request)
    {
        $tableNames = config('permission.table_names');
        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding.');
        }
        $data = $request->validate(['name' => 'required|string|max:64|min:3|unique:'. $tableNames['permissions']]);
        Permission::create($data);
        return redirect()->route('admin.permissions.index')->withSuccess('Berhasil membuat Permission baru.');
    }

    public function edit($id)
    {
        SEOMeta::setTitle("Edit Permission");
        return view('admin::permissions.edit', ['permission' => Permission::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $tableNames = config('permission.table_names');
        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding.');
        }
        $data = $request->validate(['name' => 'required|string|max:64|min:3|unique:'. $tableNames['permissions'] . ',name,' . $id]);
        $permission->update($data);
        return redirect()->back()->withSuccess('Berhasil memperbarui Permission.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $users = User::permission($permission->name)->get();
        foreach($users as $user) $user->revokePermissionTo($permission->name);
        $permission->delete();
        return redirect()->route('admin.permissions.index')->withSuccess('Berhasil menghapus Permission.');
    }
}
