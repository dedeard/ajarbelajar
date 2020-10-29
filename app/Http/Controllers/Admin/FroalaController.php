<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FroalaHelper;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class FroalaController extends Controller
{
    public function getImage()
    {
        $data = Image::where('imageable_type', 'froala')->where('imageable_id', 1)->get()->transform(function($img){
            return [
                'url' => FroalaHelper::generateUrl($img->name)
            ];
        });
        return  response()->json($data);
    }

    public function uploadImage(Request $request)
    {
        $data = $request->validate(['file' => 'required|image|max:4000']);
        $upload = FroalaHelper::uploadImage($data['file']);
        Image::create([
            'name' => $upload['name'],
            'imageable_type' => 'froala',
            'imageable_id' => 1,
            'original_name' => $data['file']->getClientOriginalName(),
        ]);
        return response()->json(['link' => $upload['url']]);
    }

    public function destroyImage(Request $request)
    {
        FroalaHelper::deleteImage($request->input('src'));
        return true;
    }
}
