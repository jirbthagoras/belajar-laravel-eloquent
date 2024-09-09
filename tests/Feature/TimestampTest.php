<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class TimestampTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('delete from comments');
    }


    public function testInsert(): void
    {
        $comment = new Comment();
        $comment->email = 'sampleEmail@test.com';
        $comment->title = 'Sample Title';
        $comment->comment = 'Sample Comment';
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();
        $comment->save();

        self::assertNotNull($comment->id);
    }

    public function testDefaultColumnValue()
    {

        $comment = new Comment();
        $comment->email = 'sampleEmail@test.com';
        $comment->save();

        self::assertNotNull($comment->id);

    }


}
