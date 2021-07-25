<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Category extends Model
{

    protected $fillable = ['slug', 'name'];

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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function articles()
    {
        return $this->hasMany(Post::class)->where('type', 'article');
    }

    public function videos()
    {
        return $this->hasMany(Post::class)->where('type', 'video');
    }
}
