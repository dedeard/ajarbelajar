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
     * Return Posts reation.
     */
    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }
}
