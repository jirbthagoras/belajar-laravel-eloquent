<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CRUDTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::table('categories')->delete();

    }


    public function testInsert()
    {

        $category = new Category();

        $category->id = 'GADGET';
        $category->name = 'Gadget';
        $result = $category->save();

        self::assertTrue($result);

    }

    public function testInsertManyCategories()
    {

        $categories = [];

        for($i = 0; $i < 10; $i++)
        {

            $categories[] = [
                'id' => "ID-$i",
                'name' => "NAME-$i",
            ];

        }

        $result = Category::query()->insert($categories);

        self::assertTrue($result);

        $total = Category::query()->count();
        self::assertEquals(10, $total);

    }

    public function testFind()
    {

        $this->seed(CategorySeeder::class);

        $category = Category::query()->find('FOOD');

        self::assertNotNull($category);

    }


}
