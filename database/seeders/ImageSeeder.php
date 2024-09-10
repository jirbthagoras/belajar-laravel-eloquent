<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $image1 = new Image();
        $image1->url = "https://Elang1.png";
        $image1->imageable_id = "EKO";
        $image1->imageable_type = Customer::class;
        $image1->save();

        $image2 = new Image();
        $image2->url = "https://Elang2.png";
        $image2->imageable_id = "1";
        $image2->imageable_type = Product::class;
        $image2->save();
    }
}
