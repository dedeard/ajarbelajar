<?php

namespace App\Models;

use App\Helpers\HeroHelper;
use App\Helpers\VideoHelper;
use Illuminate\Database\Eloquent\Model;

class RequestPost extends Model
{
    protected $fillable = [
        'category_id',
        'minitutor_id',
        'requested_at',
        'title',
        'hero',
        'type',
        'description',
        'body',
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    protected $casts = [
        'requested_at' => 'datetime',
    ];

    public function minitutor()
    {
        return $this->belongsTo(Minitutor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * Atributes
     */
    public function getHeroUrlAttribute()
    {
        if($this->hero) {
            return HeroHelper::getUrl($this->hero);
        }
        $keyed = collect(HeroHelper::SIZES)->mapWithKeys(function($item, $key){
            return [$key => null];
        });
        return $keyed->all();
    }

    public function getVideoUrlAttribute()
    {
        if($this->body) {
            return VideoHelper::getUrl($this->body);
        }
        return null;
    }
}
