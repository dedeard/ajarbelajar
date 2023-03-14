<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\CoverHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Episode;
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
            'description' => 'required|max:3000',
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

    public function update(Request $request, $id)
    {
        $lesson = $request->user()->lessons()->findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:250',
            'category' => 'required|exists:categories,id',
        ]);
        $public = $request->get('public');

        $data['public'] = false;
        if (isset($public) && $public === 'on') $data['public'] = true;

        if ($data['public'] && !$lesson->posted_at) {
            $data['posted_at'] = now();
            $lesson->update($data);
            // event(new LessonPublished($this->lesson));
        } else {
            $lesson->update($data);
        }

        return redirect()->back()->withSuccess('Pelajaran berhasil diperbarui');
    }

    public function updateCover(Request $request, $id)
    {
        $lesson = $request->user()->lessons()->findOrFail($id);
        $data = $request->validate([
            'image' => 'required|image|max:4000'
        ]);

        $name = CoverHelper::generate($data['image'], $lesson->cover);
        $lesson->update(['cover' => $name]);

        return response()->json($lesson->cover_url);
    }


    public function updateDescription(Request $request, $id)
    {
        $lesson = $request->user()->lessons()->findOrFail($id);
        $data = $request->validate(['description' => 'required|max:3000']);
        $lesson->update($data);
        return response()->noContent();
    }

    public function uploadEpisode(Request $request, $id)
    {
        $lesson = $request->user()->lessons()->findOrFail($id);
        $data = $request->validate([
            'video' => 'required|mimes:mp4,mov,avi,fly|max:' . env('MAX_VIDEO_SIZES', '25000'),
        ]);

        $getID3 = new \getID3();
        $tmp_name = $data['video']->getRealPath();
        $title = pathinfo($data['video']->getClientOriginalName(), PATHINFO_FILENAME);
        $seconds = $getID3->analyze($tmp_name)['playtime_seconds'];
        $index = $lesson->episodes()->count();
        $name = VideoHelper::upload($data['video']);

        $episode = new Episode([
            'name' => $name,
            'title' => $title,
            'index' => $index,
            'seconds' => $seconds,
        ]);
        $lesson->episodes()->save($episode);

        return response()->json([
            'message' => 'Episode berhasil dibuat',
        ]);
    }
}
