<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Wallet;
use Cassandra\Custom;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class CardinalityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();


        DB::delete('delete from images');
        DB::delete('delete from customers_likes_products');
        DB::delete('DELETE FROM reviews');
        DB::delete('DELETE FROM customers');
        DB::delete('DELETE FROM products');
        DB::delete('DELETE FROM categories');
        DB::delete('DELETE FROM wallets');
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

    public function testInsertRelationship()
    {

        $customer = new Customer();
        $customer->id = "EKO";
        $customer->name = 'Eko';
        $customer->email = 'sample@gmail.com';
        $customer->save();

        $wallet = new Wallet();
        $wallet->amount = 1000000;
        $customer->wallet()->save($wallet);

        self::assertTrue(true);

    }

    public function testInsertRelationshipOneToMany()
    {

        $category = new Category();
        $category->id = '1';
        $category->name = 'category-1';
        $category->description = 'Description 1';
        $category->is_active = true;
        $category->save();

        $product = new Product();
        $product->id = '1';
        $product->name = 'Product-1';
        $product->description = 'Description 1';
        $category->products()->save($product);

        $product = new Product();
        $product->id = '2';
        $product->name = 'Product-2';
        $product->description = 'Description 2';
        $category->products()->save($product);

        self::assertTrue(true);

    }

    public function testQueryRelationship()
    {

        $this->testInsertRelationshipOneToMany();

        $category = Category::query()->find("1");

        assertNotNull($category);

        $isOutOfStock = $category->products()->where('stock', '<=', 0)->get();

        self::assertNotNull($isOutOfStock);
        self::assertCount(2, $isOutOfStock);

    }

    public function testHasOneOfMany()
    {

        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $category = Category::query()->find("FOOD");

        $cheapestProduct = $category->cheapestProduct;

        self::assertNotNull($cheapestProduct);
        self::assertEquals('2', $cheapestProduct->id);

        $mostExpensiveProduct = $category->mostExpensiveProduct;
        self::assertNotNull($mostExpensiveProduct);
        self::assertEquals('1', $mostExpensiveProduct->id);

    }

    public function testHasOneThrough()
    {

        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::query()->find("EKO");
        assertNotNull($customer);

        $virtualAccount = $customer->virtualAccount;

        assertNotNull($virtualAccount);
        self::assertEquals('BCA', $virtualAccount->bank);

    }

    public function testHasManyThrough()
    {

        $this->seed([CategorySeeder::class, ProductSeeder::class, CustomerSeeder::class, ReviewSeeder::class]);

        $category = Category::query()->find("LINGERIE");
        self::assertNotNull($category);

        $products = $category->products;
        assertCount(1, $products);

        $reviews = $category->reviews;
        self::assertNotNull($reviews);
        self::assertCount(1, $reviews);



    }

    public function testInsertManytoMany()
    {

        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::query()->find("EKO");

        $customer->likeProducts()->attach('1');

        self::assertNotNull($customer);

    }

    public function testQueryManyToMany()
    {

        $this->testInsertManytoMany();

        $customer = Customer::query()->find("EKO");

        $likedProducts = $customer->likeProducts;

        assertNotNull($likedProducts);

        var_dump($likedProducts[0]->id);
        var_dump($likedProducts[0]->name);

        assertEquals("1", $likedProducts[0]->id);
        self::assertEquals("Products 1", $likedProducts[0]->name);
    }

    public function testPivot()
    {

        $this->testInsertManytoMany();

        $customer = Customer::query()->find("EKO");

        assertNotNull($customer);

        $products = $customer->likeProducts;

        $pivot = $products[0]->pivot;

        assertNotNull($pivot);
        assertNotNull($pivot->customer_id);
        assertNotNull($pivot->product_id);
        assertNotNull($pivot->created_at);



    }

    public function testIntermediateTeableCondition()
    {

        $this->testInsertManytoMany();

        $costumer = Customer::query()->find("EKO");
        $products = $costumer->likeProductsLastWeek;

        foreach ($products as $product) {

            $pivot = $product->pivot;

            self::assertNotNull($pivot);

        }

    }

    public function testPivotModel()
    {

        $this->testInsertManytoMany();

        $customer = Customer::query()->find("EKO");

        $products = $customer->likeProducts;

        foreach ($products as $product) {

            $pivot = $product->pivot;

            $customer = $pivot->customer;

            assertNotNull($customer);

            $products = $pivot->product;
            assertNotNull($product);

        }

    }

    public function testOneToOnePolymorphic()
    {

        $this->seed([CategorySeeder::class,ProductSeeder::class, ImageSeeder::class]);

        $product = Product::query()->find('1');

        $product->image();

        self::assertNotNull($product);

    }


}
