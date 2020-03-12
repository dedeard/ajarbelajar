<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\UpdateProfileRequest;
use App\Model\Image as ModelImage;
use App\Model\Minitutor;
use App\Model\Post;
use App\Model\UserProfile;
use App\Model\UserSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Artesaos\SEOTools\Facades\SEOTools;

class DashbaordController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard.edit');
    }

    public function edit()
    {
        SEOTools::setTitle('Edit Profile');
        return view('web.dashboard.edit');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $data = $request->validated();

        $user->username = $data['username'];
        if(strtolower($data['email']) !== strtolower($user->email)) {
            $user->email = strtolower($data['email']);
            $user->email_verified_at = null;
        }
        if(isset($data['new_password'])) {
            $user->password = Hash::make($data['new_password']);
        }
        $user->save();

        UserProfile::updateOrCreate([ 'user_id' => $user->id], [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'about' => $data['about'],
            'website_url' => $data['website_url'],
        ]);

        UserSocial::updateOrCreate([ 'user_id' => $user->id], [
            'facebook_url' => $data['facebook_url'],
            'instagram_url' => $data['instagram_url'],
            'twitter_url' => $data['twitter_url'],
            'youtube_url' => $data['youtube_url'],
        ]);


        if(isset($data['image'])) {

            $avatar = Image::make($data['image'])->fit(200, 200, function ($constraint) {
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
        }

        return redirect()->back();
    }

    public function following(Request $request)
    {
        SEOTools::setTitle('Diikuti');
        $followings = $request->user()->subscriptions(Minitutor::class)->paginate(12);
        return view('web.dashboard.following', ['minitutors' => $followings]);
    }

    public function favorite(Request $request)
    {
        SEOTools::setTitle('Favorit');
        $posts = $request->user()->favorites(Post::class)->where('draf', 0)->withCount(['comments' => function($query){
            return $query->where('approved', true);
        }, 'views'])->paginate(4);
        return view('web.dashboard.favorite', ['posts' => $posts]);
    }
}
