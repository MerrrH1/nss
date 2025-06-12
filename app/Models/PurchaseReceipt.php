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
        'final_gross_weight_kg',
        'final_tare_weight_kg',
        'final_net_weight_kg',
        'kk_percentage',
        'ka_percentage',
        'ffa_percentage',
        'price_per_kg',
        'claim_amount',
        'total_amount',
        'claim_notes',
        'notes'
    ];

    protected $casts = [
        'receipt_date' => 'date'
    ];

    public function purchaseContract() {
        return $this->belongsTo(PurchaseContract::class);
    }

    public function truck() {
        return $this->belongsTo(Truck::class);
    }

    public function purchaseInvoices() {
        return $this->hasMany(PurchaseInvoice::class);
    }
}
