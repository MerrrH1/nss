<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReceipt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'purchase_contract_id',
        'truck_id',
        'receipt_number',
        'receipt_date',
        'gross_weight_kg',
        'tare_weight_kg',
        'net_weight_kg',
        'quality_deduction_percentage',
        'final_net_weight_kg',
        'price_per_kg',
        'total_amount',
        'notes'
    ];
}
