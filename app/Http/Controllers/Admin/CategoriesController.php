<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:manage category']);
    }

    public function index()
    {
        SEOMeta::setTitle('Daftar Kategori');
        $categories = Category::orderBy('name')->paginate(20);
        return view('categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        SEOMeta::setTitle('Buat Kategori');
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string']);
        $exists = Category::where('slug', Str::slug($data['name'], '-'))->exists();
        if ($exists) return redirect()->back()->withError('Kategori sudah ada.');
        Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'], '-')
        ]);
        return redirect()->route('categories.index')->withSuccess('Kategori telah dibuat.');
    }

    public function edit($id)
    {
        SEOMeta::setTitle('Edit Kategori');
        $category = Category::findOrFail($id);
        return view('categories.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate(['name' => 'required|string']);

        $exists = Category::where('id', '!=', $id)->where('slug', Str::slug($data['name'], '-'))->exists();
        if ($exists) return redirect()->back()->withError('Kategori sudah ada.');

        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'], '-')
        ]);

        return redirect()->back()->withSuccess('Kategori telah diperbarui.');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->withSuccess('Kategori telah dihapus.');
    }
}
