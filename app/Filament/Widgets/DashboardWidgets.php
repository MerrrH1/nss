<?php

namespace App\Filament\Widgets;

use App\Models\SalesDeliveries;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardWidgets extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Penjualan Hari Ini:', SalesDeliveries::whereDate('delivery_date', Carbon::today())->count())
        ];
    }
}
