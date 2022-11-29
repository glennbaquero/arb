<?php

use Illuminate\Database\Seeder;

use App\Models\Samples\SampleItem;
use App\Models\Picture;

class SampleItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SampleItem::class, 12)->create()->each(function($item) {
        	$item->images()->saveMany(factory(Picture::class, 2)->make());
        });
    }
}
