<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Voucher extends Model
{
    use HasUuids, SoftDeletes;

    public $fillable = [
        'name',
        'is_active
    ];

    protected $table = 'vouchers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function scopeActive(Builder $builder):void
    {
        $builder->where('is_active', true);
    }

    public function scopeNonActive(Builder $builder):void
    {
        $builder->where('is_active', false);
    }

    public function uniqueIds()
    {

        return [$this->primaryKey, "voucher_code"];

    }
}
