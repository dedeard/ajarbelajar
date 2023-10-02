<?php

namespace App\Http\Controllers;

use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    public function edit(Request $request, $lessonId, $episodeId)
    {
        $lesson = $request->user()->lessons()->findOrFail($lessonId);
        $episode = $lesson->episodes()->findOrFail($episodeId);

        $tab = $request->input('tab') ?? 'details';
        abort_unless(in_array($tab, ['details', 'subtitles']), 404);

        return view('my-lessons.edit-episode', compact('lesson', 'episode', 'tab'));
    }

    public function update(Request $request, $lessonId, $episodeId)
    {
        $lesson = $request->user()->lessons()->findOrFail($lessonId);
        $episode = $lesson->episodes()->findOrFail($episodeId);

        $data = $request->validate([
            'title' => 'required|string|max:250',
            'description' => 'nullable|max:3000'
        ]);

        $episode->update($data);

        return redirect()->back()->withSuccess('Episode berhasil diperbarui');
    }

    public function destroy(Request $request, $lessonId, $episodeId)
    {
        $lesson = $request->user()->lessons()->findOrFail($lessonId);
        $episode = $lesson->episodes()->findOrFail($episodeId);
        VideoHelper::destroy($episode->name);
        $episode->delete();
        return redirect()->route('my-lessons.edit', ['lesson' => $lessonId, 'tab' => 'episodes'])->withSuccess('Episode berhasil dihapus.');
    }
}
