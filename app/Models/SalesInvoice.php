<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesInvoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'sales_contract_id',
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

    public function salesContract() {
        return $this->belongsTo(SalesContract::class);
    }

    public function salesDeliveries() {
        return $this->hasMany(SalesDeliveries::class);
    }

    public function salesTaxInvoice() {
        return $this->belongsTo(SalesTaxInvoice::class);
    }
}
