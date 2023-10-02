<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subtitle;
use App\Rules\VttRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubtitlesController extends Controller
{
    public function store(Request $request, $episodeId)
    {
        $user = $request->user();
        $lesson = $user->lessons()->whereHas('episodes', fn ($q) => $q->where('id', $episodeId))->firstOrFail();
        $episode = $lesson->episodes()->find($episodeId);
        $codes = implode(',', array_map(fn ($item) => $item['code'], config('languages')));

        $data = $request->validate([
            'language' => ['required', 'in:' . $codes, Rule::unique('subtitles', 'code')->where(fn ($q) => $q->where('episode_id', $episodeId))],
            'file' => ['required', 'max:512', new VttRule],
        ]);

        $subtitle = Subtitle::generate($data['language'], $data['file']);
        $episode->subtitles()->save($subtitle);

        return redirect()->back()->withSuccess('Subtitle berhasil dibuat.');
    }

    public function destroy(Request $request, $subtitleId)
    {
        $user = $request->user();
        $user->lessons()->whereHas('episodes', function ($q) use ($subtitleId) {
            return $q->whereHas('subtitles', fn ($q) => $q->where('id', $subtitleId));
        })->firstOrFail();

        Subtitle::where("id", $subtitleId)->delete();

        return redirect()->back()->withSuccess('Subtitle berhasil hapus.');
    }
}
