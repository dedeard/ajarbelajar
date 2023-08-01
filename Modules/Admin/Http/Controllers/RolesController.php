<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Permission;
use Modules\Admin\Entities\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read role')->only('index');
        $this->middleware('can:create role')->only('create');
        $this->middleware('can:update role')->only(['edit', 'update', 'toggleSyncPermission']);
        $this->middleware('can:delete role')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $roles = Role::all();

        return view('admin::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('admin::roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:64|min:3|unique:roles',
            'display_name' => 'required|string|max:64',
            'description' => 'nullable|string|max:300',
        ]);

        $data['name'] = strtolower($data['name']);
        $role = Role::create($data);

        return redirect()->route('admin.roles.edit', $role->id)->withSuccess('Berhasil membuat peran baru.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);

        // Check if the role is protected before proceeding to edit
        if ($role->is_protected) {
            return redirect()->route('admin.roles.index')->withError('Tidak dapat mengedit peran yang dilindungi.');
        }

        $permissions = Permission::all();

        return view('admin::roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:64|min:3|unique:roles,name,'.$id,
            'display_name' => 'required|string|max:64',
            'description' => 'nullable|string|max:300',
        ]);

        $role = Role::findOrFail($id);

        // Check if the role is protected before performing the update
        if ($role->is_protected) {
            return redirect()->route('admin.roles.edit', $role->id)->withError('Tidak dapat memperbarui peran yang dilindungi.');
        }

        $data['name'] = strtolower($data['name']);
        $role->update($data);

        return redirect()->back()->withSuccess('Berhasil memperbarui peran.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->is_protected) {
            return redirect()->route('admin.roles.index')->withError('Peran terlindungi tidak dapat dihapus.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->withSuccess('Peran berhasil dihapus.');
    }

    /**
     * Toggle the sync status of the specified permission for the role.
     *
     * @param  int  $roleId
     * @param  int  $permissionId
     * @return Renderable
     */
    public function toggleSyncPermission($roleId, $permissionId)
    {
        $role = Role::with('permissions')->findOrFail($roleId);
        Permission::findOrFail($permissionId);

        if ($role->is_protected) {
            return redirect()->route('admin.roles.edit', $role->id)->withError('Tidak dapat mengalihkan izin untuk peran yang dilindungi.');
        }

        if ($role->hasPermission($permissionId)) {
            $role->revokePermission($permissionId);
            $message = 'Izin dicabut dari peran.';
        } else {
            $role->grantPermission($permissionId);
            $message = 'Izin diberikan kepada peran.';
        }

        return redirect()->back()->withSuccess($message);
    }
}
