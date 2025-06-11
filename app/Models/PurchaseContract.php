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
        'start_date',
        'end_date',
        'total_quantity_kg',
        'price_per_kg',
        'quantity_received_kg',
        'status',
        'notes'
    ];

    protected $casts = [
        'contract_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseReceipts() {
        return $this->hasMany(PurchaseReceipt::class);
    }

    public function purchaseInvoices() {
        return $this->hasMany(PurchaseInvoice::class);
    }
}
