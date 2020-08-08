<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
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
        $categories = Category::orderBy('name')->paginate(20);
        return view('admin.categories.index', [ 'categories' => $categories ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        $category = Category::where('slug', Str::slug($data['name'], '-'));
        if(!$category->exists()) {
            Category::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name'], '-')
            ]);
        }
        Cache::forget('category');
        return redirect()->route('admin.categories.index')->withSuccess('Berhasil membuat Kategori.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        if($category->slug !== Str::slug($data['name'], '-')) {
            $exists = Category::where('slug', Str::slug($data['name'], '-'))->exists();
            if($exists) return redirect()->back()->withError('Kategori telah ada.');
            Category::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name'], '-')
            ]);

        } else {
            $category->update($data);
        }
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
