<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesDeliveries extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sales_contract_id',
        'truck_id',
        'delivery_number',
        'delivery_date',
        'gross_weight_kg',
        'tare_weight_kg',
        'net_weight_kg',
        'final_gross_weight_kg',
        'final_tare_weight_kg',
        'final_net_weight_kg',
        'kk_percentage',
        'ka_percentage',
        'ffa_percentage',
        'dobi',
        'claim_amount',
        'total_amount',
        'claim_notes',
        'status',
        'notes'
    ];

    protected $casts = [
        'delivery_date' => 'date'
    ];

    public function salesContract()
    {
        return $this->belongsTo(SalesContract::class);
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function salesInvoices()
    {
        return $this->hasMany(SalesInvoice::class);
    }
}
