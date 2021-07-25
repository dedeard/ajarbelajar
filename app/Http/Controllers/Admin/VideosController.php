<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CategoryHelper;
use App\Helpers\VideoHelper;
use App\Helpers\HeroHelper;
use App\Helpers\PointHelper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Image;
use App\Models\Minitutor;
use App\Notifications\MinitutorPostPublishedNotification;
use App\Notifications\NewPostNotification;
use Exception;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage video');
    }

    public function index(Request $request)
    {
        if (!empty($request->input('search'))) {
            $search = '%' . $request->input('search') . '%';
            $videos = Post::where('type', 'video')->where('title', 'like', $search);
        } else {
            $videos = Post::where('type', 'video');
        }
        $videos = $videos->orderBy('id', 'desc')->paginate(20)->appends(['search' => $request->input('search')]);
        return view('videos.index', ['videos' => $videos]);
    }

    public function minitutors(Request $request)
    {
        if (!empty($request->input('search'))) {
            $search = '%' . $request->input('search') . '%';
            $minitutors = Minitutor::whereHas('user', function ($q) use ($search) {
                return $q->where('name', 'like', $search)
                    ->orWhere('username', 'like', $search)
                    ->orWhere('email', 'like', $search);
            })->where('active', true)->orderBy('id', 'desc');
        } else {
            $minitutors = Minitutor::where('active', true)->orderBy('id', 'desc');
        }
        $minitutors = $minitutors->paginate(20)->appends(['search' => $request->input('search')]);
        return view('videos.minitutors', ['minitutors' => $minitutors]);
    }

    public function create(Request $request)
    {
        $minitutor = Minitutor::where('active', true)->findOrFail($request->input('id') ?? 0);
        return view('videos.create', ['minitutor' => $minitutor]);
    }

    public function store(Request $request)
    {
        $minitutor = Minitutor::where('active', true)->findOrFail($request->input('id') ?? 0);

        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable'
        ]);

        $data['type'] = 'video';
        $video = new Post($data);
        $minitutor->posts()->save($video);

        PointHelper::onMinitutorPostCreated($minitutor->user);

        return redirect()->route('videos.edit', $video->id)->withSuccess('Video telah dibuat.');
    }

    public function edit($id)
    {
        $video = Post::where('type', 'video')->findOrFail($id);
        $categories = Category::all();
        return view('videos.edit', ['video' => $video, 'categories' => $categories]);
    }

    public function uploadVideo(Request $request, $id)
    {
        $video = Post::where('type', 'video')->findOrFail($id);
        $data = $request->validate(['file' => 'required|mimes:mp4,mov,avi,fly|max:500000']);
        $upload = VideoHelper::upload($data['file'], $video->body);
        $video->body = $upload;
        $video->save();
        return response()->noContent();
    }

    public function update(Request $request, $id)
    {
        $video = Post::where('type', 'video')->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable',
            'category' => 'nullable|string',
            'hero' => 'nullable|image|max:4000'
        ]);

        if (isset($data['hero'])) {
            $data['hero'] = HeroHelper::generate($data['hero'], $video->hero);
        } else {
            unset($data['hero']);
        }

        if (isset($data['category'])) {
            $data['category_id'] = Category::getCategoryOrCreate($data['category'])->id;
        } else {
            $data['category_id'] = null;
        }
        unset($data['category']);

        $public = (bool) $request->input('public');

        if(!$public && $video->posted_at) {
            $data['posted_at'] = null;
        }

        if($public && !$video->posted_at) {
            $data['posted_at'] = now();

            $video->minitutor->user->notify(new MinitutorPostPublishedNotification($video));
            foreach($video->minitutor->followers()->get() as $follower){
                try {
                    $follower->user->notify(new NewPostNotification($video));
                } catch(Exception $e) {
                    continue;
                }
            }
        }

        $video->update($data);
        return redirect()->back()->withSuccess('Video telah diperbarui.');
    }

    public function destroy($id)
    {
        $video = Post::where('type', 'video')->findOrFail($id);
        foreach($video->images as $image) {
            EditorjsHelper::deleteImage($image->name);
            $image->delete();
        }
        HeroHelper::destroy($video->hero);
        $video->delete();
        return redirect()->route('videos.index')->withSuccess('Video berhasil dihapus.');
    }
}
