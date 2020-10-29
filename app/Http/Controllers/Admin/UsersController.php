<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AvatarHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Minitutor;
use App\Models\Playlist;
use App\Models\User;
use App\Rules\RoleExists;
use App\Rules\Username;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    const EDUCATIONS = ['D1', 'D2', 'D3', 'S1', 'S2', 'S3'];

    public function __construct()
    {
        $this->middleware('can:manage user');
    }

    public function index(Request $request)
    {
        SEOMeta::setTitle('Daftar User');
        if (!empty($request->input('search'))) {
            $search = '%' . $request->input('search') . '%';
            $users = User::where('name', 'like', $search);
            $users->orWhere('username', 'like', $search);
            $users->orWhere('email', 'like', $search);
        } else {
            $users = User::orderBy('id', 'desc');
        }
        $users = $users->paginate(20)->appends(['search' => $request->input('search')]);
        return view('users.index', ['users' => $users]);
    }

    public function create()
    {
        SEOMeta::setTitle('Buat User');
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        return view('users.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', new Username, 'max:64', 'min:6', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'email_verified' => ['nullable'],
            'role' => ['nullable', 'integer', new RoleExists],
            'image' => 'nullable|image|max:4000'
        ]);

        $data['username'] = strtolower($data['username']);
        $data['password'] = Hash::make($data['password']);
        if (isset($data['email_verified'])) $data['email_verified_at'] = now();

        if (isset($data['image'])) {
            $data['avatar'] = AvatarHelper::generate($data['image']);
            unset($data['image']);
        }

        $user = User::create($data);

        if (isset($data['role']) && $request->user()->can('manage role')) {
            $role = Role::findOrFail($data['role']);
            $user->assignRole($role->name);
        }

        return redirect()->route('users.edit', $user->id)->withSuccess('User telah dibuat.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        SEOMeta::setTitle($user->name);

        $playlists = $user->activities()->with(['playlist' => function($q){
            Playlist::postListQuery($q);
        }])->whereHas('playlist')->where('activitiable_type', Playlist::class)->get();
        $articles = $user->activities()->with(['article' => function($q){
            Article::postListQuery($q);
        }])->whereHas('article')->where('activitiable_type', Article::class)->get();

        $activities = $articles->merge($playlists)->transform(function($item){
            if(isset($item->article)){
                $post = $item->article;
            } else {
                $post = $item->playlist;
            }
            return [
                'id' => $item->id,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'post' => $post,
            ];
        })->sortByDesc('updated_at')->values()->all();
        return view('users.show', ['user' => $user, 'activities' => $activities]);
    }

    public function showFavorites($id)
    {
        $user = User::findOrFail($id);
        SEOMeta::setTitle($user->name);

        $playlists = $user->subscriptions()
            ->withType(Playlist::class)
            ->with(['playlist' => function($q){
                return Playlist::postListQuery($q);
            }])
            ->get();

        $articles = $user->subscriptions()
            ->withType(Article::class)
            ->with(['article' => function($q){
                return Article::postListQuery($q);
            }])
            ->get();

        $favorites = $articles->merge($playlists)->transform(function($item){
            if(isset($item->article)){
                return $item->article;
            } else {
                return $item->playlist;
            }
        });

        return view('users.favorites', ['user' => $user, 'favorites' => $favorites]);
    }

    public function showFollowings($id)
    {
        $user = User::findOrFail($id);
        SEOMeta::setTitle($user->name);
        $followings = $user->subscriptions()->withType(Minitutor::class)->with(['minitutor' => function($q){
            $q->with('user');
        }])->get();
        return view('users.followings', ['user' => $user, 'followings' => $followings]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        SEOMeta::setTitle('Edit ' . $user->name);
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        return view('users.edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', new Username, 'max:64', 'min:6', 'unique:users,username,' . $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8'],
            'email_verified' => ['nullable'],
            'role' => ['nullable', 'integer', new RoleExists],
            'image' => 'nullable|image|max:4000'
        ]);

        if (!$user->hasRole('Super Admin') && $request->user()->can('manage role')) {
            if (isset($data['role'])) {
                $role = Role::findOrFail($data['role']);
                $user->syncRoles($role->name);
            } else {
                $user->syncRoles([]);
            }
        }


        $data['username'] = strtolower($data['username']);

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (isset($data['image'])) {
            $data['avatar'] = AvatarHelper::generate($data['image']);
            AvatarHelper::destroy($user->avatar);
            unset($data['image']);
        }

        if (isset($data['email_verified'])) {
            $data['email_verified_at'] = $user->email_verified_at ?? now();
        } else {
            $data['email_verified_at'] = null;
        }

        $user->update($data);
        return redirect()->back()->withSuccess('User telah diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('Super Admin')) return abort(403);
        AvatarHelper::destroy($user->avatar);
        $user->delete();
        return redirect()->route('users.index')->withSuccess('User telah dihapus.');
    }

    public function createMinitutor($id)
    {
        SEOMeta::setTitle('Buat Minitutor');
        $user = User::findOrFail($id);
        if (isset($user->minitutor)) return abort(404);
        return view('users.create_minitutor', ['user' => $user, 'last_educations' => self::EDUCATIONS]);
    }

    public function storeMinitutor(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (isset($user->minitutor)) return abort(404);
        $data = $request->validate([
            'last_education' => 'required|string|max:50',
            'university' => 'required|string|max:250',
            'city_and_country_of_study' => 'required|string|max:250',
            'majors' => 'required|string|max:250',
            'contact' => 'required|string|max:250',
        ]);
        $data['interest_talent'] = '';
        $data['reason'] = '';
        $data['expectation'] = '';
        $data['active'] = true;
        $minitutor = new Minitutor($data);
        $user->minitutor()->save($minitutor);
        return redirect()->route('minitutors.show', $minitutor->id)->withSuccess('Berhasil mejadikan user sebagai minitutor.');
    }
}
