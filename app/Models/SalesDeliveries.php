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

    public static function boot()
    {
        parent::boot();

        static::saving(function ($receipt) {
            $receipt->calculateClaimAmount();
        });
    }

    public function calculateClaimAmount()
    {
        $this->claim_amount = 0;
        $this->claim_notes = null;

        if ($this->salesContract) {
            $contract = $this->salesContract;
            $claimDetails = [];

            $basePrice = $this->price_per_kg ?: $contract->price_per_kg;
            $totalAmount = $this->final_net_weight_kg * $basePrice;

            if ($this->kk_percentage > $contract->tolerated_kk_percentage) {
                $excessKk = $this->kk_percentage - $contract->tolerated_kk_percentage;
                $claim = $totalAmount * $excessKk;
                $this->claim_amount += $claim;
                $claimDetails[] = "Klaim KK: " . number_format($excessKk, 2) . "% kelebihan, sebesar Rp " . number_format($claim, 0);
            }

            if ($this->ka_percentage > $contract->tolerated_ka_percentage) {
                $excessKa = $this->ka_percentage - $contract->tolerated_ka_percentage;
                $claim = $totalAmount * $excessKa;
                $this->claim_amount += $claim;
                $claimDetails[] = "Klaim KA: " . number_format($excessKa, 2) . "% kelebihan, sebesar Rp " . number_format($claim, 0);
            }

            if ($this->ffa_percentage > $contract->tolerated_ffa_percentage) {
                $excessFfa = $this->ffa_percentage - $contract->tolerated_ffa_percentage;
                $claim = $totalAmount * $excessFfa;
                $this->claim_amount += $claim;
                $claimDetails[] = "Klaim FFA: " . number_format($excessFfa, 2) . "% kelebihan, sebesar Rp " . number_format($claim, 0);
            }

            if (!empty($claimDetails)) {
                $this->claim_notes = join("; ", $claimDetails);
            }
        }
    }
}
