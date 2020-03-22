<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Rules\RoleExists;
use App\Rules\Username;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage user']);
    }

    public function index(Request $request)
    {
        $users = User::select('*');

        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $users = $users->where('first_name', 'like', $search)
                ->orWhere('last_name', 'like', $search)
                ->orWhere('username', 'like', $search)
                ->orWhere('email', 'like', $search);
        }
        return view('admin.users.index', ['users' => $users->orderBy('id', 'desc')->paginate(20)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:20'],
            'last_name' => ['nullable', 'string', 'min:3', 'max:20'],
            'username' => ['required', 'string', new Username, 'max:64', 'min:6', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'email_verified' => ['nullable'],
            'role' => ['nullable', new RoleExists],
        ]);

        $data['password'] = Hash::make($data['password']);
        if (isset($data['email_verified'])) $data['email_verified_at'] = now();

        $user = User::create($data);

        if (isset($data['role']) && $request->user()->can('manage role')) {
            $user->syncRoles(Role::findByName($data['role']));
        }

        return redirect()->route('admin.users.edit', $user->id)->withSuccess('Berhasil membuat User.');
    }

    public function create(Request $request)
    {
        $data = [];
        if ($request->user()->can('manage role')) {
            $data['roles'] = Role::where('name', '!=', 'Super Admin')->get();
        }
        return view('admin.users.create', $data);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->user()->hasRole('Super Admin')) {
            if ($user->hasRole(['Super Admin'])) return abort(403);
        } else {
            if ($user->hasRole(['Super Admin', 'Administrator'])) return abort(403);
        }

        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:20'],
            'last_name' => ['nullable', 'string', 'min:3', 'max:20'],
            'username' => ['required', 'string', new Username, 'max:64', 'min:6', 'unique:users,username,' . $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8'],
            'email_verified' => ['nullable'],
            'role' => ['nullable', new RoleExists],
        ]);

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (isset($data['email_verified'])) {
            if (!$user->email_verified_at) $data['email_verified_at'] = now();
        } else {
            $data['email_verified_at'] = null;
        }

        $user->update($data);

        if ($request->user()->can('manage role')) {
            if(isset($data['role'])) {
                $user->syncRoles(Role::findByName($data['role']));
            } else {
                $user->syncRoles();
            }
        }

        return redirect()->back()->withSuccess('Berhasil mengedit User.');
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->user()->hasRole('Super Admin')) {
            if ($user->hasRole(['Super Admin'])) return abort(403);
        } else {
            if ($user->hasRole(['Super Admin', 'Administrator'])) return abort(403);
        }

        $data['roles'] = Role::where('name', '!=', 'Super Admin')->get();

        $data = ['user' => $user];
        if ($request->user()->can('manage role')) {
            $data['roles'] = Role::where('name', '!=', 'Super Admin')->get();
        }
        return view('admin.users.edit', $data);
    }

    public function show($id)
    {
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->user()->hasRole('Super Admin')) {
            if ($user->hasRole(['Super Admin'])) return abort(403);
        } else {
            if ($user->hasRole(['Super Admin', 'Administrator'])) return abort(403);
        }
        $user->delete();
        return redirect()->route('admin.users.index')->withSuccess('Berhasil menghapus User.');
    }
}
