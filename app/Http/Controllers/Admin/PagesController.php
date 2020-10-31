<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HeroHelper;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Page;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEOMeta::setTitle('Daftar Halaman');
        return view('pages.index', ['pages' => Page::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEOMeta::setTitle('Buat Halaman');
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => 'required|string|unique:pages',
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $page = Page::create($data);
        return redirect()->route('pages.edit', $page->id)->withSuccess('Halaman telah dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        SEOMeta::setTitle('Edit Halaman');
        $page = Page::findOrFail($id);
        return view('pages.edit', ['page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $data = $request->validate([
            'slug' => 'required|string|unique:pages,slug,'. $page->id,
            'title' => 'required|string',
            'description' => 'nullable|string',
            'hero' => 'nullable|image|max:4000',
            'body' => 'nullable',
        ]);

        $data['draf'] = (bool) !$request->input('public');

        if (isset($data['hero'])) {
            $name = HeroHelper::generate($data['hero'], $page->hero ? $page->hero->name : null);
            $hero = $page->hero;
            if($hero) {
                $hero->update([
                    'type'=> 'hero',
                    'name'=> $name,
                    'original_name'=> $data['hero']->getClientOriginalName()
                ]);
            } else {
                $page->hero()->save(new Image([
                    'type'=> 'hero',
                    'name'=> $name,
                    'original_name'=> $data['hero']->getClientOriginalName()
                ]));
            }
        }
        unset($data['hero']);
        $page->update($data);
        return redirect()->back()->withSuccess('Halaman telah diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::findOrFail($id)->delete();
        return redirect()->route('pages.index')->withSuccess('Halaman telah dihapus.');
    }
}
