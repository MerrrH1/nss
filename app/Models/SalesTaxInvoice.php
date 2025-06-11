<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesTaxInvoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sales_invoice_id',
        'tax_invoice_number',
        'tax_invoice_date',
        'dpp_amount',
        'ppn_amount',
        'notes'
    ];

    protected $casts = [
        'tax_invoice_date' => 'date'
    ];

    public function salesInvoice() {
        return $this->belongsTo(SalesInvoice::class);
    }
}
