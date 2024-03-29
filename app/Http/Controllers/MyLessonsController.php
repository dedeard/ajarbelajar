<?php

namespace App\Http\Controllers;

use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Jobs\EpisodeProcessJob;
use App\Models\Category;
use App\Models\Episode;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MyLessonsController extends Controller
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

        return view('my-lessons.index', ['lessons' => $lessons, 'tab' => $tab]);
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();

        return view('my-lessons.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:250',
            'category' => 'required|exists:categories,id',
            'description' => 'required|max:3000',
        ]);
        if (isset($data['category'])) {
            $data['category_id'] = $data['category'];
        }
        $lesson = new Lesson($data);
        $request->user()->lessons()->save($lesson);

        return redirect()->route('my-lessons.edit', $lesson->id)->withSuccess('Berhasil membuat pelajaran baru.');
    }

    public function edit(Request $request, $id)
    {
        $tab = $request->input('tab') ?? 'details';
        abort_unless(in_array($tab, ['details', 'cover', 'episodes']), 404);
        $lesson = $request->user()->lessons()->findOrFail($id);

        $categories = null;
        if ($tab === 'details') $categories = Category::select('id', 'name')->orderBy('name')->get();

        return view('my-lessons.edit', compact('categories', 'lesson', 'tab'));
    }

    public function destroy(Request $request, $id)
    {
        $lesson = $request->user()->lessons()->with('episodes')->findOrFail($id);
        foreach ($lesson->episodes as $episode) {
            VideoHelper::destroy($episode->name);
        }
        $lesson->unsearchable();
        $lesson->delete();

        return redirect()->route('my-lessons.index')->withSuccess('Berhasil menghapus pelajaran.');
    }

    public function update(Request $request, $id)
    {
        $lesson = $request->user()->lessons()->findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:250',
            'category' => 'required|exists:categories,id',
            'description' => 'required|max:3000'
        ]);
        $public = $request->get('public');

        $data['public'] = false;
        $data['category_id'] = $data['category'];
        if (isset($public) && $public === 'on') {
            $data['public'] = true;
        }

        if ($data['public'] && !$lesson->posted_at) {
            $data['posted_at'] = now();
            $lesson->update($data);
        } else {
            $lesson->update($data);
        }

        if ($lesson->public) {
            $lesson->searchable();
        } else {
            $lesson->unsearchable();
        }

        return redirect()->back()->withSuccess('Pelajaran berhasil diperbarui');
    }

    public function updateCover(Request $request, $id)
    {
        $lesson = $request->user()->lessons()->findOrFail($id);
        $data = $request->validate([
            'image' => 'required|image|max:4000',
        ]);

        $lesson->generateCovers($data['image']);
        $lesson->searchable();

        return response()->json($lesson->cover_urls);
    }

    public function uploadEpisode(Request $request, $id)
    {
        $lesson = $request->user()->lessons()->findOrFail($id);
        $data = $request->validate([
            'video' => 'required|mimes:mp4,mov,avi,fly,webm|max:' . env('MAX_VIDEO_SIZES', '25000'),
        ]);

        $title = pathinfo($data['video']->getClientOriginalName(), PATHINFO_FILENAME);
        $index = $lesson->episodes()->count();
        $name = VideoHelper::upload($data['video']);

        $episode = new Episode([
            'name' => $name,
            'title' => $title,
            'index' => $index,
        ]);
        $lesson->episodes()->save($episode);
        $lesson->searchable();

        EpisodeProcessJob::dispatch($episode->toArray())->onQueue('episode');

        return response()->json([
            'episode' => $episode
        ]);
    }

    public function updateIndex(Request $request, $id)
    {
        $lesson = $request->user()->lessons()->with('episodes')->findOrFail($id);

        $data = $request->validate([
            'index' => 'required|array|size:' . count($lesson->episodes),
            'index.*' => 'required|integer|distinct|in:' . implode(',', $lesson->episodes->pluck('id')->all()),
        ]);

        $index = $data['index'];
        $filtered_episodes = [];
        $episodes = $lesson->episodes->toArray();

        foreach ($index as $id) {
            $filtered = Arr::where($episodes, fn ($episode) =>  $episode['id'] == $id);
            $filtered = Arr::first($filtered);
            if ($filtered) {
                array_push($filtered_episodes, $filtered);
            }
        }

        foreach ($filtered_episodes as $key => $filtered) {
            $episode = $lesson->episodes->firstWhere('id', $filtered['id']);
            $episode->update(['index' => $key]);
        }

        return response()->noContent();
    }
}
