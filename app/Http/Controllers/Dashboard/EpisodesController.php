<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    public function edit(Request $request, $lessonId, $episodeId)
    {
        $lesson = $request->user()->lessons()->findOrFail($lessonId);
        $episode = $lesson->episodes()->findOrFail($episodeId);
        return view('dashboard.lessons.edit-episode', compact('lesson', 'episode'));
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
        $episode->delete();
        return redirect()->route('dashboard.lessons.edit', ['lesson' => $lessonId, 'tab' => 'episodes'])->withSuccess('Episode berhasil dihapus.');
    }
}
