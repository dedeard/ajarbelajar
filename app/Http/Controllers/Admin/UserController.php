<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\User;
use App\Model\UserProfile;
use App\Rules\Username;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    public function index()
    {
        $users = [];
        foreach(User::all() as $user) {
            array_push($users, [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->admin ? 'Admin' : 'Member',
                'email_verified_at' => Carbon::parse($user->email_verified_at)->format('Y/m/d'),
                "created_at" => $user->created_at->format('Y/m/d'),
            ]);
        }
        return view('admin.user.index', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:20'],
            'last_name' => ['nullable', 'string', 'min:3', 'max:20'],
            'username' => ['required', 'string', new Username, 'max:64', 'min:6', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'admin' => ['nullable'],
            'email_verified' => ['nullable']
        ]);

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $profile = new UserProfile([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);

        $user->profile()->save($profile);

        if(isset($data['email_verified'])) {
            $user->markEmailAsVerified();
        }

        if(isset($data['admin'])) {
            $user->admin()->save((new Admin));
        }
        return redirect()->back()->withSuccess('Berhasil membuat pengguna.');
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:20'],
            'last_name' => ['nullable', 'string', 'min:3', 'max:20'],
            'username' => ['required', 'string', new Username, 'max:64', 'min:6', 'unique:users,username,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'password' => ['nullable', 'string', 'min:8'],
            'admin' => ['nullable'],
            'email_verified' => ['nullable']
        ]);

        $user->username = $data['username'];
        $user->email = $data['email'];

        if($data['password']) {
            $user->password = Hash::make($data['password']);
        }

        if(empty($data['email_verified'])) {
            $user->email_verified_at = null;
        } else {
            $user->email_verified_at = now();
        }

        $user->save();

        $profile = $user->profile;

        $profile->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);

        if(isset($data['admin'])) {
            if(!$user->admin) {
                $user->admin()->save(new Admin);
            }
        } else {
            if($user->admin) {
                $user->admin->delete();
            }
        }
        
        return redirect()->back()->withSuccess('Berhasil mengedit pengguna.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', ['user' => $user ]);
    }

    public function show($id)
    {

    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        if(Route::has($request->input('redirect'))){
            return redirect()->route($request->input('redirect'))->withSuccess('Berhasil menghapus pengguna.');
        } else {
            return redirect()->back()->withSuccess('Berhasil menghapus pengguna.');
        }
    }
}
