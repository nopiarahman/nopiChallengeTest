<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image = Image::factory(5)->create();

        foreach (Image::all() as $image) {
            $product =Product::all()->shuffle()->first();
            $image->product()->attach($product->id);
        }
    }
}
