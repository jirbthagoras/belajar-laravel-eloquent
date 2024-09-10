<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = new Customer();
        $customer->id = 'EKO';
        $customer->name = 'Eko';
        $customer->email = 'eko@pzn.com';
        $customer->save();

        $customer = new Customer();
        $customer->id = 'FARHAN';
        $customer->name = 'Farhan';
        $customer->email = 'farhan@pzn.com';
        $customer->save();
    }
}
