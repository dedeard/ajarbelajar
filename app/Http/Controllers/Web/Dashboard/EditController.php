<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Rules\Username;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class EditController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('Edit Profile');
        return view('web.dashboard.edit.index');
    }
    public function update(Request $request)
    {
        $user = $request->user();
        
        $data = $request->validate([
            'username' => ['required', 'string', new Username, 'max:64', 'min:6', 'unique:users,username,' . $user->id ],
            'email' => ['required', 'string', 'email', 'max:250', 'unique:users,email,' . $user->id ],
            'first_name' => ['required', 'string', 'min:3', 'max:20'],
            'last_name' => ['nullable', 'string', 'min:3', 'max:20'],
            'about' => ['nullable', 'string', 'min:20', 'max:250'],
            'website_url' => ['nullable', 'url', 'max:250'],
            'facebook_url' => ['nullable', 'url', 'max:250'],
            'instagram_url' => ['nullable', 'url', 'max:250'],
            'youtube_url' => ['nullable', 'url', 'max:250'],
            'twitter_url' => ['nullable', 'url', 'max:250'],
            'image' => ['nullable', 'image', 'max:4000'],
            'new_password' => ['nullable', 'string', 'min:8', 'same:c_new_password'],
            'password' => ['nullable', 'required_with:new_password', 'password']
        ]);

        if(strtolower($data['email']) !== strtolower($user->email)) {
            $data['email_verified_at'] = null;
        }

        if(isset($data['new_password'])) {
            $data['password'] = Hash::make($data['new_password']);
        } else {
            unset($data['password']);
        }

        if(isset($data['image'])) {
            $avatar = Image::make($data['image'])->fit(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $newName = hash('sha256', Str::random(60)) . '.jpg';
            if($user->avatar && Storage::disk('public')->exists('avatar/' . $user->avatar)) {
                Storage::disk('public')->delete('avatar/' . $user->avatar);
            }
            Storage::disk('public')->put('avatar/' . $newName, (string) $avatar->encode('jpg', 75));
            $data['avatar'] = $newName;
        }
        $user->update($data);
        return redirect()->back();
    }
}
