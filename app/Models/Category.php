<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['slug', 'name'];

    static function getCategoryOrCreate(String $name): Category
    {
        $slug = Str::slug($name, '-');
        $category = Category::where('slug', $slug);

        if ($category->exists()) {
            $category = $category->first();
        } else {
            $category = Category::create([
                'name' => $name,
                'slug' => $slug
            ]);
        }
        return $category;
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
