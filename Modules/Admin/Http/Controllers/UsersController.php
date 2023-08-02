<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use App\Rules\Username;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read user')->only('index');
        $this->middleware('can:create user')->only(['create', 'store']);
        $this->middleware('can:update user')->only(['edit', 'update']);
        $this->middleware('can:delete user')->only('destroy');
    }

    public function index(Request $request)
    {
        Paginator::useBootstrapFour();
        $search = $request->get('search');
        $users = User::when($search, fn ($query, $search) => $query->search($search))->orderBy('id', 'desc')->paginate(10)->appends(['search', $search]);

        return view('admin::users.index', compact('users'));
    }

    public function create()
    {
        return view('admin::users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'username' => ['required', 'string', new Username, 'max:15', 'min:6', 'unique:users'],
            'password' => 'required|min:6',
            'website' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        $data = $request->except('email_verified');
        $data['password'] = Hash::make($request->input('password'));

        // Send email verification notification if checkbox is not checked
        if (!$request->has('email_verified')) {
            $user = User::create($data);
            $user->sendEmailVerificationNotification();
        } else {
            $data['email_verified_at'] = now();
            User::create($data);
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dibuat!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin::users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'username' => ['required', 'string', new Username, 'max:15', 'min:6', 'unique:users,username,' . $id],
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'website' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        $data = $request->except(['email_verified', 'password']);

        if (!empty($request->input('password'))) {
            $data['password'] = Hash::make($request->input('password'));
        }

        if ($request->has('email_verified')) {
            if (!$user->email_verified_at) {
                $data['email_verified_at'] = now();
            }
        } else {
            $data['email_verified_at'] = null;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
