<?php

namespace App;

use App\Models\PurchaseContract;
use App\Models\SalesContract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class Helpers
{
    /**
     * Get the month in Roman numerals from a Carbon date instances.
     * 
     * @param \Carbon\Carbon $date
     * @return string
     */
    public static function getRomanMonth($date)
    {
        $romans = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];
        return $romans[$date->month] ?? (string) $date->month;
    }

    /**
     * Get the initials from a given string.
     *
     * @param string $name The string from which to extract initials.
     * @return string The extracted initials in uppercase.
     */
    public static function getInitials($name, $bussinessEntity = false)
    {
        $words = preg_split('/\s+/', strtolower($name)); // Pisah berdasarkan spasi

        $blacklistWords = ['and', 'or'];
        if (!$bussinessEntity) {
            // Blacklist tanpa titik untuk fleksibilitas
            $blacklistWords = array_merge($blacklistWords, ['pt', 'cv', 'ud']);
        }

        $initials = '';
        foreach ($words as $word) {
            $cleanWord = rtrim($word, '.'); // Hilangkan titik jika ada
            if (!empty($cleanWord) && !in_array($cleanWord, $blacklistWords)) {
                $initials .= strtoupper($cleanWord[0]);
            }
        }

        return $initials;
    }
}
