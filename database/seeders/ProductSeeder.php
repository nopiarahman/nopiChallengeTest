<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::factory(10)->create();

        foreach (Product::all() as $product) {
            $category =Category::all()->shuffle()->first();
            $product->category()->attach($category->id);
        }
    }
}
