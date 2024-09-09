<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

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

    public function testUpdate()
    {

        $this->seed(CategorySeeder::class);

        $category = Category::query()->find("FOOD");

        $category->name = "FOOD UPDATED";

        $result = $category->save();

        self::assertTrue($result);

    }

    public function testSelect()
    {

        for($i = 0; $i < 5; $i++)
        {

            $category = new Category();
            $category->id = "ID-$i";
            $category->name = "NAME-$i";

            $category->save();

        }

        $categories = Category::query()->whereNull('description')->get();

        self::assertEquals(5, $categories->count());



        $categories->each(function ($item){

            self::assertNull($item->description);

        });

    }

    public function testUpdateSelectedResult()
    {

        $this->testSelect();

        $categories = Category::query()->whereNull('description')->get();

        $categories->each(function ($category){

           $category->description = "Updated";
           $category->update();

        });

        $categories = Category::query()->whereNull('description')->get();

        assertNull($categories->first());

    }

    public function testUpdateMany()
    {

        $this->testSelect();

        Category::query()->whereNull('description')->update([
            'description' => "Updated",
        ]);

        $categories = Category::query()->whereNotNull('description')->get();

        self::assertEquals(5, $categories->count());

    }

    public function testDelete()
    {

        $this->seed(CategorySeeder::class);

        $category = Category::query()->find("FOOD");
        $result = $category->delete();

        assertTrue($result);

    }

    public function testDeleteMany()
    {

        $this->testSelect();

        Category::query()->whereNull('description')->delete([]);

        $categories = Category::query()->count();

        assertEquals(0, $categories);

    }

    public function testFillable()
    {

        $request = [
            'id' => 'FOOD',
            'name' => 'Food Enak',
            'description' => 'Food Category',
        ];

        $result = Category::query()->create($request);

        self::assertNotNull($result);

    }

    public function testUpdateWithFillable()
    {

        $this->seed(CategorySeeder::class);

        $request = [
            'id' => 'FOOD UPDATED',
            'name' => 'Food Updated',
            'description' => 'Food Desc Updated'
        ];

        $result = Category::query()->find("FOOD")->update($request);

        self::assertNotNull($result);

    }

    public function testWithoutGlobalScope()
    {

        Category::query()->create([
            'id' => 'food',
            'name' => 'Food Enak',
            'description' => 'Food Category',
            'is_active' => false,
        ]);

        $category = Category::query()->withoutGlobalScopes([IsActiveScope::class])->find("FOOD");
        self::assertNotNull($category);

    }

    public function testGlobalScope()
    {

        Category::query()->create([
            'id' => 'food',
            'name' => 'Food Enak',
            'description' => 'Food Category',
            'is_active' => false,
        ]);

        $category = Category::query()->find("FOOD");
        self::assertNull($category);

    }


}
