<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'plate_number',
        'driver_name',
        'capacity_kg'
    ];

    public function purchaseReceipts() {
        return $this->hasMany(PurchaseReceipt::class);
    }

    public function salesDeliveries() {
        return $this->hasMany(SalesDeliveries::class);
    }
}
