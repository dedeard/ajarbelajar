<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ["HTML", "CSS", "JavaScript", "Database", "PHP", "Ruby", "Design", "Tool", "Bebas", "Android", "Hosting", "Wordpress", "Codeigniter", "Laravel", "jQuery", "Nodejs", "Vue", "API", "Ajax", "Python", "SEO", "Slim", "Sharing", "Testing", "Firebase", "Responsive", "Progressive Web App", "Flask", "Django", "Reactjs", "Nuxtjs", "Vuex", "Redux", "Nextjs", "GrapHQL", "GO", "Flutter", "Kotlin", "SQLite", "Mysql", "Hugo", "Static site", "Alpinejs", "Tailwindcss", "Laravel Livewire", "Dart"];
        foreach ($categories as $category) {
            Category::getCategoryOrCreate($category);
        }
    }
}
