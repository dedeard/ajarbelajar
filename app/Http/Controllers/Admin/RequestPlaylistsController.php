<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HeroHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Playlist;
use App\Models\RequestPlaylist;
use App\Models\Video;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class RequestPlaylistsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage playlist');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEOMeta::setTitle('Daftar Playlist Permintaan');
        $playlists = RequestPlaylist::where('requested_at', '!=', null);
        $playlists = $playlists->orderBy('id', 'desc')->paginate(20);
        return view('request_playlists.index', ['playlists' => $playlists]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $playlist = RequestPlaylist::where('requested_at', '!=', null)->findOrFail($id);
        SEOMeta::setTitle($playlist->title);
        $videos = [];

        foreach($playlist->videos()->orderBy('index', 'asc')->get() as $video) {
            array_push($videos, [
                'id' => $video['id'],
                'index' => $video['index'],
                'original_name' => $video['original_name'],
                'url' => $video->getUrl(),
            ]);
        }

        return view('request_playlists.show', ['playlist' => $playlist, 'videos' => $videos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Accept the playlist.
     */
    public function accept($id)
    {
        $rPlaylist = RequestPlaylist::where('requested_at', '!=', null)->findOrFail($id);
        $minitutor = $rPlaylist->minitutor;

        $data = [
            'title' => $rPlaylist->title,
            'description' => $rPlaylist->description,
        ];
        if($rPlaylist->category) $data['category_id'] = $rPlaylist->category->id;

        $playlist = new Playlist($data);
        $minitutor->playlists()->save($playlist);

        if  ($rPlaylist->hero) {
            $hero = new Image([
                'type' => 'hero',
                'original_name' => $rPlaylist->hero->original_name,
                'name' => $rPlaylist->hero->name,
            ]);
            $rPlaylist->hero->delete();
            $playlist->hero()->save($hero);
        }

        foreach($rPlaylist->videos as $oldVideo) {
            $video = new Video([
                'original_name' => $oldVideo->original_name,
                'index' => $oldVideo->index,
                'name' => $oldVideo->name,
            ]);
            $oldVideo->delete();
            $playlist->videos()->save($video);
        }

        $rPlaylist->delete();
        return redirect()->route('playlists.edit', $playlist->id)->withSuccess('Playlist telah diterima.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $playlist = RequestPlaylist::where('requested_at', '!=', null)->findOrFail($id);
        foreach($playlist->videos as $video) {
            VideoHelper::destroy($video->name);
            $video->delete();
        }
        HeroHelper::destroy($playlist->hero ? $playlist->hero->name : null);
        $playlist->delete();
        return redirect()->route('request-playlists.index')->withSuccess('Playlist permintaan telah di hapus.');
    }
}
