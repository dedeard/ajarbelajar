<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SeosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage seo');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEOMeta::setTitle('Daftar SEO');
        return view('seos.index', [ 'seos' => Seo::all() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEOMeta::setTitle('Buat SEO');
        return view('seos.create');
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
            'path' => 'required|string|unique:seos',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        Seo::create($data);
        Cache::forget('seo');
        return redirect()->route('seos.index')->withSuccess('SEO telah dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seo = Seo::findOrFail($id);
        SEOMeta::setTitle('Edit SEO');
        return view('seos.edit', ['seo' => $seo]);
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
        $seo = Seo::findOrFail($id);
        $data = $request->validate([
            'path' => 'required|string|unique:seos,path,' . $seo->id,
            'title' => 'nullable|string',
            'description' => 'nullable|string'
        ]);
        $seo->update($data);
        Cache::forget('seo');
        return redirect()->back()->withSuccess('SEO telah diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Seo::findOrFail($id)->delete();
        Cache::forget('seo');
        return redirect()->back()->withSuccess('SEO telah dihapus.');
    }
}
