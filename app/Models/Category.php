<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'name'];

    /**
     * Get a category or create if it's empty.
     */
    static function getCategoryOrCreate(String $str)
    {
        $slug = Str::slug($str, '-');
        $category = Category::where('slug', $slug);

        if($category->exists()) {
            $category = $category->first();
        } else {
            $category = Category::create([
                'name' => $str,
                'slug' => $slug
            ]);
        }

        return $category;
    }

    /**
     * Return Playlists reation.
     */
    public function playlists() : HasMany
    {
        return $this->hasMany(Playlist::class);
    }

    /**
     * Return Articles reation.
     */
    public function articles() : HasMany
    {
        return $this->hasMany(Article::class);
    }
}