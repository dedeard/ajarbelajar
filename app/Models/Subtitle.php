<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Subtitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'episode_id',
        'url',
        'code',
        'name'
    ];

    public function episode(): BelongsTo
    {
        return $this->belongsTo(Episode::class);
    }

    public static function generate(string $code, UploadedFile $file): Subtitle
    {
        $languageName = Arr::first(config('languages'), fn ($i) => $i['code'] == $code)['name'];
        $filename = "/subtitles/" . Str::uuid() . ".vtt";
        Storage::put($filename, $file->getContent());
        return new self([
            'name' => $languageName,
            'code' => $code,
            'url' => Storage::url($filename)
        ]);
    }
}
