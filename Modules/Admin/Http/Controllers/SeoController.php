<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Seo;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:manage seo');
  }

  public function index()
  {
    SEOMeta::setTitle('Daftar SEO');
    $seos = Seo::all();
    return view('admin::seo.index', [ 'seos' => $seos ]);
  }

  public function create()
  {
    SEOMeta::setTitle('Buat SEO');
    return view('admin::seo.create');
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

  public function edit($id)
  {
    SEOMeta::setTitle('Edit SEO');
    $seo = Seo::findOrFail($id);
    return view('admin::seo.edit', ['seo' => $seo]);
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

  public function destroy($id)
  {
    Seo::findOrFail($id)->delete();
    Cache::forget('seo');
    return redirect()->back()->withSuccess('Data seo telah di hapus.');
  }
}
