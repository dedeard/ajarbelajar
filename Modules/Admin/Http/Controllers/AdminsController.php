<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\Role;

class AdminsController extends Controller
{
    public function __construct()
    {
        // Middleware to check user permissions for specific actions
        $this->middleware('can:read admin')->only('index');
        $this->middleware('can:create admin')->only(['create', 'store']);
        $this->middleware('can:update admin')->only(['edit', 'update']);
        $this->middleware('can:delete admin')->only('destroy');
    }

    /**
     * Display a listing of the admins.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch all admins from the database
        $admins = Admin::all();

        // Return the index view with the admins data
        return view('admin::admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        // Fetch roles from the database where name is not 'super admin'
        $roles = Role::where('name', '!=', 'super admin')->get();

        // Convert the $roles collection to the desired format ["id" => "display_name"]
        $roleOptions = $roles->pluck('display_name', 'id')->toArray();

        // Return the create view with the roles data
        return view('admin::admins.create', compact('roles', 'roleOptions'));
    }

    /**
     * Store a newly created admin in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data before saving to the database
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
            'is_active' => 'boolean',
            'role_id' => [
                'required',
                'exists:roles,id',
                // Custom validation rule to prevent assigning the 'super admin' role
                function ($attribute, $value, $fail) {
                    $role = Role::findOrFail($value);
                    if ($role->name === 'super admin') {
                        $fail('Peran yang dipilih tidak diizinkan.');
                    }
                },
            ],
        ]);

        // Hash the password before saving to the database
        $request->merge(['password' => Hash::make($request->password)]);

        // Create a new admin instance and save it to the database
        Admin::create($request->all());

        // Redirect to the admin index page or show a success message
        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        // Find the admin by the given ID
        $admin = Admin::findOrFail($id);

        // Check if the admin has the role named "super admin"
        if ($admin->role && $admin->role->name === 'super admin') {
            // You can redirect with an error message or abort the action if needed
            return redirect()->route('admin.admins.index')->with('error', 'Tidak dapat mengedit super admin!');
        }

        // Fetch roles from the database where name is not 'super admin'
        $roles = Role::where('name', '!=', 'super admin')->get();

        // Convert the $roles collection to the desired format ["id" => "display_name"]
        $roleOptions = $roles->pluck('display_name', 'id')->toArray();

        // Return the edit view with the admin and roles data
        return view('admin::admins.edit', compact('admin', 'roleOptions'));
    }

    /**
     * Update the specified admin in the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Find the admin by the given ID
        $admin = Admin::findOrFail($id);

        // Check if the admin has the role named "super admin"
        if ($admin->role && $admin->role->name === 'super admin') {
            // You can redirect with an error message or abort the action if needed
            return redirect()->route('admin.admins.index')->with('error', 'Tidak dapat mengupdate super admin!');
        }

        // Validate the request data before updating the database
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,'.$admin->id,
            'password' => 'nullable|min:6',
            'is_active' => 'boolean',
            'role_id' => 'exists:roles,id',
        ]);

        // Check if the 'password' field is provided in the request
        if ($request->has('password')) {
            // Hash the password before updating the database
            $request->merge(['password' => Hash::make($request->password)]);
        } else {
            // Remove the 'password' field from the request data if it's empty (null)
            $request->request->remove('password');
        }

        // Update the admin's attributes and save it to the database
        $admin->update($request->all());

        // Redirect to the admin index page or show a success message
        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil diupdate!');
    }

    /**
     * Remove the specified admin from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Find the admin by the given ID
        $admin = Admin::findOrFail($id);

        // Check if the admin has the role named "super admin"
        if ($admin->role && $admin->role->name === 'super admin') {
            // You can redirect with an error message or abort the action if needed
            return redirect()->route('admin.admins.index')->with('error', 'Tidak dapat menghapus super admin!');
        }

        // Delete the admin from the database
        $admin->delete();

        // Redirect to the admin index page or show a success message
        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil dihapus!');
    }
}
