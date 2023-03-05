<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\CoverHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab') ?? 'all';
        abort_unless(in_array($tab, ['all', 'public', 'draft']), 404);

        $user = $request->user();
        $query = $user->lessons()->orderBy('updated_at', 'desc');

        switch ($tab) {
            case 'public':
                $query->where('public', true);
                break;
            case 'draft':
                $query->where('public', false);
                break;
        }

        $lessons = $query->paginate(10);
        return view('dashboard.lessons.index', ['lessons' => $lessons, 'tab' => $tab]);
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return view('dashboard.lessons.create', ['categories' => $categories]);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:250',
            'category' => 'required|exists:categories,id',
            'description' => 'required|string|max:2500',
        ]);
        if (isset($data['category'])) $data['category_id'] = $data['category'];
        $lesson = new Lesson($data);
        $request->user()->lessons()->save($lesson);
        return redirect()->route('dashboard.lessons.edit', $lesson->id)->withSuccess('Berhasil membuat pelajaran baru.');
    }

    public function edit(Request $request, $id)
    {
        $tab = $request->input('tab');
        abort_unless(in_array($tab ?? 'info', ['info', 'cover', 'episodes']), 404);
        $lesson = $request->user()->lessons()->findOrFail($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return view('dashboard.lessons.edit', ['categories' => $categories, 'lesson' => $lesson, 'tab' => $tab ?? 'info']);
    }

    public function destroy(Request $request, $id)
    {
        $lesson = $request->user()->lessons()->with('episodes')->findOrFail($id);
        foreach ($lesson->episodes as $episode) {
            VideoHelper::destroy($episode->name);
        }
        CoverHelper::destroy($lesson->cover);
        $lesson->delete();
        return redirect()->route('dashboard.lessons.index')->withSuccess('Berhasil menghapus pelajaran.');
    }
}
