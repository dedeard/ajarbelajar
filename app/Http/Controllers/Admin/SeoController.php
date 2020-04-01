<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Seo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage seo']);
    }

    public function index()
    {
        $seos = Seo::all();
        return view('admin.seo.index', [ 'seos' => $seos ]);
    }

    public function edit($id)
    {
        $seo = Seo::findOrFail($id);
        return view('admin.seo.edit', ['seo' => $seo]);
    }

    public function update(Request $request, $id)
    {
        $seo = Seo::findOrFail($id);
        $data = $request->validate([
            'path' => 'required|string|unique:seos,path,' . $seo->id,
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'robots' => 'nullable|string'
        ]);
        $seo->update($data);
        Cache::forget('seo');
        return redirect()->back()->withSuccess('Data Seo berhasil di update.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'path' => 'required|string|unique:seos',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'robots' => 'nullable|string'
        ]);
        Seo::create($data);
        Cache::forget('seo');
        return redirect()->route('admin.seo.index');
    }

    public function create()
    {
        return view('admin.seo.create');
    }

    public function destroy($id)
    {
        Seo::findOrFail($id)->delete();
        Cache::forget('seo');
        return redirect()->back()->withSuccess('Data seo telah di hapus.');
    }
}
