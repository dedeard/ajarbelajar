<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image as ModelImage;
use App\Models\RequestPost;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RequestPostImagesController extends Controller
{
    const driver = 'public';

    private function getPost($userId, $postId)
    {
        $post = RequestPost::where('user_id', $userId)->where('id', $postId)->first();
        if(!$post) return abort(404);
        return $post;
    }

    public function index(Request $request, $id)
    {
        $post = $this->getPost($request->user()->id, $id);
        $images = [];

        foreach($post->images as $key => $image) {
            if (self::driver === 'public'){
                $images[$key] = [
                    'url' => asset('storage/posts/request/image/' . $image->name),
                    'thumb' => asset('storage/posts/request/image/thumb/' . $image->name),
                ];
            } else {
                $images[$key] = [
                    'url' => Storage::disk(self::driver)->url('posts/request/image/' . $image->name),
                    'thumb' => Storage::disk(self::driver)->url('posts/request/image/thumb/' . $image->name),
                ];
            }
        }
        return response()->json($images, 200);
    }

    public function store(Request $request, $id)
    {
        $post = $this->getPost($request->user()->id, $id);

        $data = $request->validate([ 'file' => 'required|image|max:4000' ]);

        $lg = Image::make($data['file'])->resize(600, null, function ($constraint) { $constraint->aspectRatio(); });
        $sm = Image::make($data['file'])->resize(200, null, function ($constraint) { $constraint->aspectRatio(); });

        $name = Str::random(60) . '.jpg';

        Storage::disk(self::driver)->put('posts/request/image/' . $name, (string) $lg->encode('jpg', 90));
        Storage::disk(self::driver)->put('posts/request/image/thumb/' . $name, (string) $sm->encode('jpg', 90));

        $image = new ModelImage(['name' => $name]);

        $post->images()->save($image);
        if(self::driver === 'public') {
            $link = asset('storage/posts/request/image/' . $name);
        } else {
            $link = Storage::disk(self::driver)->url('posts/request/image/' . $name);
        }
        return response()->json([ "link" => $link ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $post = $this->getPost($request->user()->id, $id);
        $data = $request->validate([ 'src' => 'required' ]);
        $path = explode('/', $data['src']);
        $name = $path[count($path)-1];

        if(Storage::disk(self::driver)->exists('posts/request/' . $name)) {
            Storage::disk(self::driver)->delete('posts/request/' . $name);
        }
        if(Storage::disk(self::driver)->exists('posts/request/thumb/' . $name)) {
            Storage::disk(self::driver)->delete('posts/request/thumb/' . $name);
        }
        $post->images()->where('name', $name)->delete();
        return response()->json([], 200);
    }

    public function updateHero(Request $request, $id)
    {
        $post = $this->getPost($request->user()->id, $id);
        $data = $request->validate([ 'image' => 'required|image|max:4000' ]);

        $lg = Image::make($data['image'])->fit(720*1.5, 480*1.5, function ($constraint) {
            $constraint->aspectRatio();
        });
        $sm = Image::make($data['image'])->fit(720/1.5, 480/1.5, function ($constraint) {
            $constraint->aspectRatio();
        });

        if($post->hero) {
            if(Storage::disk(self::driver)->exists('posts/request/hero/' . $post->hero)) {
                Storage::disk(self::driver)->delete('posts/request/hero/' . $post->hero);
            }
            if(Storage::disk(self::driver)->exists('posts/request/hero/thumb/' . $post->hero)) {
                Storage::disk(self::driver)->delete('posts/request/hero/thumb/' . $post->hero);
            }
        }

        $name = Str::random(60) . '.jpg';

        Storage::disk(self::driver)->put('posts/request/hero/' . $name, (string) $lg->encode('jpg', 90));
        Storage::disk(self::driver)->put('posts/request/hero/thumb/' . $name, (string) $sm->encode('jpg', 90));

        $post->hero = $name;
        $post->save();

        if(self::driver === 'public') {
            $link = asset('storage/posts/request/hero/' . $name);
        } else {
            $link = Storage::disk(self::driver)->url('posts/request/hero/' . $name);
        }

        return response()->json(['imageUrl' => $link, 'message' => 'Gambar postingan berhasil di update.'], 200);
    }
}
