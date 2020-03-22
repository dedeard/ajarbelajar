<?php

use App\Model\Seo;
use Illuminate\Database\Seeder;

class SeoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Seo::PAGES as $page) {
            Seo::create(['name' => $page]);
        }
    }
}
