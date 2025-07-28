<?php

namespace App\Filament\Widgets;

use App\Models\PurchaseReceipt;
use App\Models\SalesDeliveries;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardWidgets extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today();

        $totalPembelianHariIni = PurchaseReceipt::whereDate('receipt_date', $today)->sum('total_amount'); // Asumsi ada kolom 'total_amount'
        $totalPenjualanHariIni = SalesDeliveries::whereDate('delivery_date', $today)->sum('total_amount'); // Asumsi ada kolom 'total_amount'
        $jumlahPembelianHariIni = PurchaseReceipt::whereDate('receipt_date', $today)->count();
        $jumlahPenjualanHariIni = SalesDeliveries::whereDate('delivery_date', $today)->count();

        return [
            Stat::make('Total Pembelian Hari Ini', 'Rp ' . number_format($totalPembelianHariIni, 0, ',', '.'))
                ->description('Total nilai transaksi pembelian')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('info'),
            Stat::make('Total Penjualan Hari Ini', 'Rp ' . number_format($totalPenjualanHariIni, 0, ',', '.'))
                ->description('Total nilai transaksi penjualan')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),
            Stat::make('Jumlah Pembelian Hari Ini', $jumlahPembelianHariIni . ' Transaksi')
                ->description('Jumlah transaksi pembelian')
                ->descriptionIcon('heroicon-o-receipt-refund')
                ->color('primary'),
            Stat::make('Jumlah Penjualan Hari Ini', $jumlahPenjualanHariIni . ' Transaksi')
                ->description('Jumlah transaksi penjualan')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('warning'),
            // Tambahkan statistik lainnya di sini
        ];
    }
}
