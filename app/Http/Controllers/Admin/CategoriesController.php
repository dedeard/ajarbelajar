<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Model\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.categories.index', [ 'categories' => CategoryResource::collection($categories) ]);
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
        Category::create($data);
        return redirect()->route('admin.categories.index')->withSuccess('Berhasil membuat Kategori.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);
        Category::findOrFail($id)->update($data);
        return redirect()->back()->withSuccess('Berhasil memperbaharui Kategori.');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->withSuccess('Berhasil menghapus Kategori.');
    }
}
