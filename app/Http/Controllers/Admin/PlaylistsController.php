<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HeroHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Minitutor;
use App\Models\Playlist;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class PlaylistsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage playlist');
    }

    public function index(Request $request)
    {
        SEOMeta::setTitle('Daftar Playlist');
        if (!empty($request->input('search'))) {
            $search = '%' . $request->input('search') . '%';
            $playlists = Playlist::where('title', 'like', $search);
            $playlists->orWhere('description', 'like', $search);
        } else {
            $playlists = Playlist::query();
        }
        $playlists = $playlists->orderBy('id', 'desc')->paginate(20)->appends(['search' => $request->input('search')]);
        return view('playlists.index', ['playlists' => $playlists]);
    }

    public function minitutors(Request $request)
    {
        SEOMeta::setTitle('Pilih Minitutor untuk playlist baru');
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
        return view('playlists.minitutors', ['minitutors' => $minitutors]);
    }

    public function create(Request $request)
    {
        SEOMeta::setTitle('Buat Playlist');
        $minitutor = Minitutor::where('active', true)->findOrFail($request->input('id') ?? 0);
        return view('playlists.create', ['minitutor' => $minitutor]);
    }

    public function store(Request $request)
    {
        $minitutor = Minitutor::where('active', true)->findOrFail($request->input('id') ?? 0);

        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable'
        ]);

        $playlist = new Playlist($data);
        $minitutor->playlists()->save($playlist);

        return redirect()->route('playlists.edit', $playlist->id)->withSuccess('Playlist telah dibuat.');
    }

    public function edit($id)
    {
        SEOMeta::setTitle('Edit Playlist');
        $playlist = Playlist::findOrFail($id);
        $categories = Category::all();
        $videos = [];

        foreach($playlist->videos()->orderBy('index', 'asc')->get() as $video) {
            array_push($videos, [
                'id' => $video['id'],
                'index' => $video['index'],
                'original_name' => $video['original_name'],
                'url' => $video->getUrl(),
            ]);
        }

        return view('playlists.edit', ['playlist' => $playlist, 'categories' => $categories, 'videos' => $videos]);
    }

    public function update(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable',
            'category' => 'nullable|string',
            'hero' => 'nullable|image|max:4000',
            'index' => 'nullable|string',
        ]);

        $data['draf'] = (Boolean) !$request->input('public');

        if (isset($data['hero'])) {
            $name = HeroHelper::generate($data['hero'], $playlist->hero ? $playlist->hero->name : null);
            $hero = $playlist->hero;
            if($hero) {
                $hero->update([
                    'type'=> 'hero',
                    'name'=> $name,
                    'original_name'=> $data['hero']->getClientOriginalName()
                ]);
            } else {
                $playlist->hero()->save(new Image([
                    'type'=> 'hero',
                    'name'=> $name,
                    'original_name'=> $data['hero']->getClientOriginalName()
                ]));
            }
        }
        unset($data['hero']);

        if (isset($data['category'])) {
            $data['category_id'] = Category::getCategoryOrCreate($data['category'])->id;
        } else {
            $data['category_id'] = null;
        }

        $playlist->update($data);

        if($request->input('index')) {
            $index = explode('|', $request->input('index'));
            if(count($index) === $playlist->videos()->count()) {
                $x = 1;
                foreach($index as $id) {
                    $video = $playlist->videos()->find($id);
                    if($video) {
                        $video->update(['index' => $x]);
                        $x = $x+1;
                    }
                }
            }
        }

        return redirect()->back()->withSuccess('Playlist telah diperbarui.');
    }

    public function destroy($id)
    {
        $playlist = Playlist::findOrFail($id);
        foreach($playlist->videos as $video) {
            VideoHelper::destroy($video->name);
            $video->delete();
        }
        HeroHelper::destroy($playlist->hero ? $playlist->hero->name : null);
        $playlist->delete();
        return redirect()->route('playlists.index')->withSuccess('Playlist telah dihapus.');
    }
}
