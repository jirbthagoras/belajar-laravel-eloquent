<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CardinalityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('DELETE FROM products');
        DB::delete('DELETE FROM categories');
        DB::delete('DELETE FROM wallets');
        DB::delete('DELETE FROM customers');
    }


    public function testOneToOne(): void
    {
        $this->seed(CustomerSeeder::class);
        $this->seed(WalletSeeder::class);

        $customer = Customer::query()->find('EKO');
        self::assertNotNull($customer);

        $wallet = $customer->wallet;
        self::assertNotNull($wallet);

        var_dump($customer);


    }

    public function testQueryCategory()
    {

        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $category = Category::query()->find("FOOD");
        self::assertNotNull($category);

        $products = $category->products;
        self::assertNotNull($category);



    }

    public function testQueryProducts()
    {

        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $products = Product::query()->find("1");
        self::assertNotNull($products);

        $category = $products->categories;
        self::assertNotNull($category);

    }


}
