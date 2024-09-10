<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review = new Review();
        $review->product_id = '1';
        $review->customer_id = 'EKO';
        $review->rating = 5;
        $review->comment = "Bagus PAKE BUANGET";
        $review->save();

        $review = new Review();
        $review->product_id = '2';
        $review->customer_id = 'EKO';
        $review->rating = 3;
        $review->comment = "Lumayan";
        $review->save();

        $review = new Review();
        $review->product_id = '3';
        $review->customer_id = 'FARHAN';
        $review->rating = 3;
        $review->comment = "Lumayan";
        $review->save();
    }
}
