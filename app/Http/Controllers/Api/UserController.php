<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Image as ModelImage;
use App\Model\UserProfile;
use App\Model\UserSocial;
use App\Rules\Username;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function updateAccount(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'username' => ['required', 'string', new Username, 'max:64', 'min:6', 'unique:users,username,' . $user->id ],
            'email' => ['required', 'string', 'email', 'max:250', 'unique:users,email,' . $user->id ]
        ]);

        $user->username = $data['username'];
        
        if(strtolower($data['email']) !== strtolower($user->email)) {
            $user->email = strtolower($data['email']);
            $user->email_verified_at = null;
            $user->save();
            return response()->json(['message' => 'Kami telah mengirimkan email verifikasi pada email anda yang baru.']);
        } else {
            $user->save();
            return response()->json(['message' => 'Akun berhasil di update.']);
        }
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'same:c_new_password'],
            'password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail($attribute.' tidak valid.');
                }
            }],
        ]);

        $user->password = Hash::make($data['new_password']);
        $user->save();

        return response()->json(['message' => 'Kata sandi telah di update.']);
    }

    public function updateProfile(Request $request) {
        $user = $request->user();

        $data = $request->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:20'],
            'last_name' => ['nullable', 'string', 'min:3', 'max:20'],
            'about' => ['nullable', 'string', 'min:20', 'max:250'],
            'website' => ['nullable', 'url', 'max:250'],
        ]);
        
        if (!$user->profile) {
            $profile = new UserProfile($data);
            $user->profile()->save($profile);
        } else {
            $user->profile()->update($data);
        }

        return response()->json(['message' => 'Profile berhasil di update.']);
    }

    public function updateSocials(Request $request) {
        $user = $request->user();
        $data = $request->validate([
            'twitter' => ['nullable', 'string', 'max:250'],
            'facebook' => ['nullable', 'string', 'max:250'],
            'instagram' => ['nullable', 'string', 'max:250'],
            'github' => ['nullable', 'string', 'max:250'],
            'youtube' => ['nullable', 'string', 'max:250'],
        ]);
        if (!$user->socials) {
            $socials = new UserSocial($data);
            $user->socials()->save($socials);
        } else {
            $user->socials()->update($data);
        }

        return response()->json(['message' => 'Sosial media berhasil di update.']);
    }

    public function updateImage(Request $request) {
        $user = $request->user();
        $data = $request->validate([
            'image' => 'required|image|max:4000'
        ]);

        $avatar = Image::make($data['image'])->fit(250, 250, function ($constraint) {
            $constraint->aspectRatio();
        });
        $newName = hash('sha256', Str::random(60)) . '.jpg';

        if($user->image) {
            if(Storage::disk('public')->exists('avatar/' . $user->image->name)) {
                Storage::disk('public')->delete('avatar/' . $user->image->name);
            }
        }

        Storage::disk('public')->put('avatar/' . $newName, (string) $avatar->encode('jpg', 75));

        if($user->image) {
            $user->image()->update(['name' => $newName ]);
        } else {
            $image = new ModelImage(['name' => $newName ]);
            $user->image()->save($image);
        }

        return response()->json(['imageUrl' => asset('storage/avatar/' . $newName), 'message' => 'Avatar berhasil di update'], 200);
    }
}
