<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TestUUID extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('delete from vouchers');

    }


    public function testCreateVoucher(): void
    {
        $voucher = new Voucher();

        $voucher->name = "Sample Voucher";
        $voucher->voucher_code = "123123123123";
        $voucher->save();

        self::assertTrue(true);
    }

    public function testUUIDNonPrimaryKey()
    {

        $voucher = new Voucher();

        $voucher->name = "Sample Voucher";
        $voucher->save();

        self::assertTrue(true);

    }

    public function testSoftDelete()
    {

        $this->seed(VoucherSeeder::class);

        $voucher =  Voucher::query()->where('name', 'Sample Voucher')->first();
        $voucher->delete();

        $voucher =  Voucher::query()->where('name', 'Sample Voucher')->first();
        self::assertNull($voucher);

    }

    public function testQueryTrashedData()
    {

        $this->testSoftDelete();

        $voucher = Voucher::withTrashed()->where('name', 'Sample Voucher')->first();
        self::assertNotNull($voucher);

    }

    public function testLocalScope()
    {

        Voucher::query()->create([
            'name' => 'Sample Voucher',
            'is_active' => true,
        ]);

        $total = Voucher::query()->active()->count();
        self::assertEquals(1, $total);

    }


}
