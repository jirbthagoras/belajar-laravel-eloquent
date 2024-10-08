<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::query()->first();
        $comment = new Comment();
        $comment->email = "eko@pzn.com";
        $comment->title = "Sample Title";
        $comment->comment = "Sample Comment";
        $comment->commentable_id = $product->id;
        $comment->commentable_type = Product::class;
        $comment->save();

        $voucher = Voucher::query()->first();
        $comment = new Comment();
        $comment->email = "eko@pzn.com";
        $comment->title = "Sample Title";
        $comment->comment = "Sample Comment";
        $comment->commentable_id = $voucher->id;
        $comment->commentable_type = Voucher::class;
        $comment->save();
    }
}
