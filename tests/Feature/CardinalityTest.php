<?php

namespace Tests\Feature;

use App\Models\Customer;
use Database\Seeders\CustomerSeeder;
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
}
