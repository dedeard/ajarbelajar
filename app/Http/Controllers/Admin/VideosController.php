<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CategoryHelper;
use App\Helpers\HeroHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Minitutor;
use App\Models\Playlist;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage video');
    }

    public function index()
    {
        //
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

        $playlist = new Playlist($data);
        $minitutor->playlists()->save($playlist);

        return redirect()->route('videos.edit', $playlist->id)->withSuccess('Berhasil membuat video baru.');
    }

    public function edit($id)
    {
        $playlist = Playlist::findOrFail($id);
        $categories = Category::all();
        return view('videos.edit', ['playlist' => $playlist, 'categories' => $categories]);
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

        if(isset($data['hero'])) {
            $data['hero'] = HeroHelper::generate($data['hero'], $playlist->hero);
        } else {
            unset($data['hero']);
        }

        if(isset($data['category'])){
            $data['category_id'] = CategoryHelper::getCategoryIdOrCreate($data['category']);
        } else {
            $data['category_id'] = null;
        }

        $playlist->update($data);

        return redirect()->back()->withSuccess('Video berhasil di update.');
    }

    public function destroy($id)
    {
        //
    }
}
