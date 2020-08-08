<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Ilmu Komputer',
            'Ilmu Kedokteran',
            'Sosial Politik',
            'Keuangan',
            'Kehutanan'
        ];

        foreach($categories as $category){
            Category::create(['name' => $category, 'slug' => \Str::slug($category)]);
        }
    }
}
