<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesContract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'buyer_id',
        'contract_number',
        'contract_date',
        'start_date',
        'end_date',
        'total_quantity_kg',
        'price_per_kg',
        'tolerated_kk_percentage',
        'tolerated_ka_percentage',
        'tolerated_ffa_percentage',
        'quantity_delivered_kg',
        'status',
        'notes'
    ];

    protected $casts = [
        'contract_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function buyer() {
        return $this->belongsTo(Buyer::class);
    }

    public function salesDeliveries() {
        return $this->hasMany(SalesDeliveries::class);
    }

    public function salesInvoices() {
        return $this->hasMany(SalesInvoice::class);
    }
}
