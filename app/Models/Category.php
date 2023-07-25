<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, HasSlug;

    public $timestamps = false;

    protected $fillable = ['slug', 'name'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    static function getCategoryOrCreate(String $name): Category
    {
        return self::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
