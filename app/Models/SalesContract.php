<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class SalesContract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'buyer_id',
        'contract_number',
        'contract_date',
        'commodity_id',
        'total_quantity_kg',
        'price_per_kg',
        'tolerated_kk_percentage',
        'tolerated_ka_percentage',
        'tolerated_ffa_percentage',
        'tolerated_dobi_percentage',
        'quantity_delivered_kg',
        'payment_term',
        'status',
        'notes'
    ];

    protected $casts = [
        'contract_date' => 'date'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }

    public function salesDeliveries()
    {
        return $this->hasMany(SalesDeliveries::class)->orderBy('delivery_date');
    }

    public function salesInvoices()
    {
        return $this->hasMany(SalesInvoice::class, 'sales_contract_id');
    }

    public function isInvoiced($salesContract = null): bool
    {
        // Use the current model instance if no specific salesContract is passed
        $contract = $salesContract ?? $this;

        if ($contract->payment_term === "bulk_payment") {
            Log::info($contract);
            // Logika untuk 'bulk_payment':
            // Asumsi: kontrak bulk_payment dianggap ter-invoice jika setidaknya ada SATU invoice utama
            // yang terkait dengan kontrak ini.
            return $contract->salesInvoices()->exists();

            // Alternatif (jika setiap delivery harus ter-invoice terpisah untuk bulk_payment):
            // $completedDeliveriesCount = $contract->salesDeliveries()
            //     ->where('status', 'completed')
            //     ->distinct('delivery_date') // Menghitung tanggal delivery yang unik
            //     ->count();
            //
            // $invoicedDeliveriesCount = $contract->salesInvoiceDeliveries()
            //     ->distinct('delivery_date') // Atau kolom lain yang menandakan delivery_id yang di-invoice
            //     ->count();
            //
            // return $completedDeliveriesCount > 0 && $completedDeliveriesCount === $invoicedDeliveriesCount;


        } elseif ($contract->payment_term === "dp50") {
            // Logika untuk 'dp50':
            // Asumsi: kontrak dp50 dianggap ter-invoice jika ada 2 invoice utama (DP + Pelunasan)
            // yang terkait dengan kontrak ini.
            $actualMainInvoiceCount = $contract->salesInvoices()->count();
            $expectedInvoiceCount = 2; // DP + Pelunasan

            return $actualMainInvoiceCount >= $expectedInvoiceCount;

            // Jika Anda ingin memeriksa berdasarkan SalesInvoiceDelivery untuk DP
            // $dpInvoiced = $contract->salesInvoiceDeliveries()->where('type', 'dp')->exists(); // Asumsi ada kolom 'type'
            // $finalInvoiced = $contract->salesInvoiceDeliveries()->where('type', 'final')->exists();
            // return $dpInvoiced && $finalInvoiced;

        }

        // Jika payment_term tidak dikenali, defaultnya belum ter-invoice
        return false;
    }
}
