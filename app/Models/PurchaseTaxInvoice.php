<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseTaxInvoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'purchase_invoice_id',
        'tax_invoice_number',
        'tax_invoice_date',
        'dpp_amount',
        'ppn_amount',
        'payment_status',
        'payment_date',
        'notes'
    ];

    protected $casts = [
        'tax_invoice_date' => 'date',
        'payment_date' => 'date'
    ];

    public function purchaseInvoice() {
        return $this->belongsTo(PurchaseInvoice::class);
    }
}
