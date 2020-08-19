<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage permission');
    }

    public function index()
    {
        SEOMeta::setTitle("Daftar Permission");
        return view('permissions.index', ['permissions' => Permission::all()]);
    }

    public function create()
    {
        SEOMeta::setTitle("Buat Permission");
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $tableNames = config('permission.table_names.permissions');
        $data = $request->validate(['name' => 'required|string|max:64|min:3|unique:' . $tableNames]);
        Permission::create($data);
        return redirect()->route('permissions.index')->withSuccess('Berhasil membuat Permission baru.');
    }

    public function edit($id)
    {
        SEOMeta::setTitle("Edit Permission");
        return view('permissions.edit', ['permission' => Permission::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $tableNames = config('permission.table_names.permissions');
        $data = $request->validate(['name' => 'required|string|max:64|min:3|unique:' . $tableNames . ',name,' . $id]);
        $permission->update($data);
        return redirect()->back()->withSuccess('Berhasil memperbarui Permission.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $users = User::permission($permission->name)->get();
        foreach ($users as $user) $user->revokePermissionTo($permission->name);
        $permission->delete();
        return redirect()->route('permissions.index')->withSuccess('Berhasil menghapus Permission.');
    }
}
