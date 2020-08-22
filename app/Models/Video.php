<?php

namespace App\Models;

use App\Helpers\VideoHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Video extends Model
{
    protected $fillable = [
        'name',
        'index'
    ];

    protected static function booted()
    {
        static::deleted(function($video) {
            if ($video->name && Storage::exists('videos/' . $video->name)) {
                Storage::delete('videos/' . $video->name);
            }
        });
    }

    public function videoable() : MorphTo
    {
        return $this->morphTo();
    }

    public function getUrl() : String
    {
        if($this->name) {
            return Storage::url('videos/' . $this->name);
        }
        return '';
    }

    public static function upload($data) : String
    {
        $name = now()->format('hisdmY') . Str::random(60) . '.' . $data->extension();
        Storage::put('videos/' . $name, file_get_contents($data));
        return $name;
    }
}
