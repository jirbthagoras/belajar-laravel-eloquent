<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = new Product();
        $product->id = '1';
        $product->name = 'Products 1';
        $product->description = 'Description 1';
        $product->category_id = 'FOOD';
        $product->price = 200;
        $product->save();

        $product = new Product();
        $product->id = '2';
        $product->name = 'Products 2';
        $product->description = 'Description 2';
        $product->category_id = 'FOOD';
        $product->save();

        $product = new Product();
        $product->id = '3';
        $product->name = 'Products 3';
        $product->description = 'Description 3';
        $product->category_id = 'LINGERIE';
        $product->save();
    }
}
