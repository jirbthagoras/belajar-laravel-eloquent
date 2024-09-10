<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = new Wallet();
        $customer->amount = 1000000;
        $customer->customer_id = 'EKO';
        $customer->save();
    }
}
