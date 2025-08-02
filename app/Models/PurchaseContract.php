<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseContract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'contract_number',
        'contract_date',
        'commodity_id',
        'total_quantity_kg',
        'price_per_kg',
        'tolerated_kk_percentage',
        'tolerated_ka_percentage',
        'tolerated_ffa_percentage',
        'tolerated_dobi_percentage',
        'quantity_received_kg',
        'status',
        'notes'
    ];

    protected $casts = [
        'contract_date' => 'date',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function commodity() {
        return $this->belongsTo(Commodity::class);
    }

    public function purchaseReceipts() {
        return $this->hasMany(PurchaseReceipt::class);
    }

    public function purchaseInvoices() {
        return $this->hasMany(PurchaseInvoice::class);
    }
}
