<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseInvoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'contract_number',
        'invoice_date',
        'due_date',
        'sub_total',
        'tax_amount',
        'total_amount',
        'payment_status',
        'payment_date',
        'notes'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'payment_date' => 'date'
    ];

    public function purchaseContract() {
        return $this->belongsTo(PurchaseContract::class);
    }
}