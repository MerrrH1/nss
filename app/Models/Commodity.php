<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commodity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description'
    ];

    public function salesContracts() {
        return $this->hasMany(SalesContract::class);
    }

    public function purchaseContracts() {
        return $this->hasMany(PurchaseContract::class);
    }
}
