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
            'name' => 'required|string|unique:seos,name,' . $seo->id,
            'title' => 'required|string',
            'description' => 'required|string',
            'keywords' => 'required|string',
            'robots' => 'required|string',
            'distribution' => 'required|string',
        ]);
        $seo->update($data);
        Cache::forget('seo');
        Cache::rememberForever('seo', function () {
            return Seo::all();
        });
        return redirect()->back()->withSuccess('Data Seo berhasil di update.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:seos',
            'title' => 'required|string',
            'description' => 'required|string',
            'keywords' => 'required|string',
            'robots' => 'required|string',
            'distribution' => 'required|string',
        ]);
        Seo::create($data);
        Cache::forget('seo');
        Cache::rememberForever('seo', function () {
            return Seo::all();
        });
        return redirect()->route('admin.seo.index');
    }

    public function create()
    {
        return view('admin.seo.create');
    }
}
