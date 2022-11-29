<?php

use Illuminate\Database\Seeder;

use App\Models\Articles\Article;
use App\Models\Picture;

class SampleArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Article::class, 12)->create()->each(function($item) {
        	$item->images()->saveMany(factory(Picture::class, 2)->make());
        });
    }
}
