<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseTaxInvoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
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

    public function purchaseInvoice() {
        return $this->belongsTo(PurchaseInvoice::class);
    }
}
