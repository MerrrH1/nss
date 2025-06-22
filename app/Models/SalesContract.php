<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'status',
        'notes'
    ];

    protected $casts = [
        'contract_date' => 'date'
    ];

    public function buyer() {
        return $this->belongsTo(Buyer::class);
    }

    public function commodity() {
        return $this->belongsTo(Commodity::class);
    }

    public function salesDeliveries() {
        return $this->hasMany(SalesDeliveries::class);
    }

    public function salesInvoices() {
        return $this->hasMany(SalesInvoice::class);
    }

    protected function formattedBuyerName() {
        return Attribute::make(function(string $value, array $attributes) {
            $this->formatCompanyName($attributes['name']);
        });
    }

    protected function formatCompanyName(string $fullName) {
        $cleanName = trim(preg_replace('/\s+/', ' ', $fullName));
        $upperCleanName = strtoupper($cleanName);
        if (str_starts_with($upperCleanName, 'PT. ')) {
            $baseName = trim(substr($cleanName, 4)); // Ambil sisa nama setelah 'PT. '
            return 'PT. ' . $this->getInitials($baseName);
        } elseif (str_starts_with($upperCleanName, 'CV. ')) {
            $baseName = trim(substr($cleanName, 4)); // Ambil sisa nama setelah 'CV. '
            return 'CV. ' . $this->getInitials($baseName);
        }
    }

    private function getInitials(string $text) {
        $stopWords = ['DAN', 'AND', 'OR', 'DI', 'DARI', 'KE', 'PADA', 'UNTUK', 'DENGAN', 'ATAS', 'BAWAH', 'RAYA', 'UTAMA', 'SENTOSA', 'JAYA', 'PERKASA', 'MAKMUR', 'SEJAHTERA'];
        $words = explode(' ', strtoupper($text)); // Pecah teks menjadi kata-kata, ubah ke uppercase

        $initials = '';
        foreach ($words as $word) {
            $word = trim($word);
            if (!empty($word) && !in_array($word, $stopWords)) {
                $initials .= substr($word, 0, 1);
            }
        }
        return $initials;
    }
}
