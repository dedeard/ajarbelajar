<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    const PAGES = [
        'home' => 'Halaman utama',
        'article' => 'Daftar artikel',
        'video' => 'Daftar vidio',
        'category' => 'Kategori',
        'minitutor' => 'Daftar minitutor',
        'joinminitutor' => 'Jadi minitutor',
    ];

    public function index()
    {
        $data = [
            'pages' => self::PAGES
        ];
        return view('admin.seo.index', $data);
    }

    public function edit($slug)
    {
        if(empty(self::PAGES[$slug])) return abort(404);
        $data = [
            'name' => self::PAGES[$slug],
            'slug' => $slug,
            'data' => setting('seo.' . $slug)
        ];
        return view('admin.seo.edit', $data);
    }

    public function update(Request $request, $slug)
    {
        if(empty(self::PAGES[$slug])) return abort(404);
        $data = $request->validate(['title' => 'required|string', 'description' => 'required|string']);
        setting(['seo.' . $slug . '.title' => $data['title']])->save();
        setting(['seo.' . $slug . '.description' => $data['description']])->save();
        return redirect()->back()->withSuccess('Data berhasil di update.');
    }
}
