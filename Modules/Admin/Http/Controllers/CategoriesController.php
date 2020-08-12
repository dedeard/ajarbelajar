<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Category;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class CategoriesController extends Controller
{
  public function __construct()
  {
    $this->middleware(['permission:manage category']);
  }

  public function index()
  {
    SEOMeta::setTitle('Daftar Kategori');
    $categories = Category::orderBy('name')->paginate(20);
    return view('admin::categories.index', [ 'categories' => $categories ]);
  }

  public function create()
  {
    SEOMeta::setTitle('Buat Kategori');
    return view('admin::categories.create');
  }

  public function store(Request $request)
  {
    $data = $request->validate([ 'name' => 'required|string' ]);
    $exists = Category::where('slug', Str::slug($data['name'], '-'))->exists();
    if($exists) return redirect()->back()->withError('Kategori telah ada.');
    Category::create([
      'name' => $data['name'],
      'slug' => Str::slug($data['name'], '-')
    ]);
    Cache::forget('category');
    return redirect()->route('admin.categories.index')->withSuccess('Berhasil membuat Kategori.');
  }

  public function edit($id)
  {
    SEOMeta::setTitle('Edit Kategori');
    $category = Category::findOrFail($id);
    return view('admin::categories.edit', ['category' => $category]);
  }

  public function update(Request $request, $id)
  {
    $category = Category::findOrFail($id);
    $data = $request->validate(['name' => 'required|string']);

    $exists = Category::where('id', '!=', $id)->where('slug', Str::slug($data['name'], '-'))->exists();
    if($exists) return redirect()->back()->withError('Kategori telah ada.');

    $category->update([
      'name' => $data['name'],
      'slug' => Str::slug($data['name'], '-')
    ]);

    Cache::forget('category');
    return redirect()->back()->withSuccess('Berhasil memperbaharui Kategori.');
  }

  public function destroy($id)
  {
    Category::findOrFail($id)->delete();
    Cache::forget('category');
    return redirect()->back()->withSuccess('Berhasil menghapus Kategori.');
  }
}
