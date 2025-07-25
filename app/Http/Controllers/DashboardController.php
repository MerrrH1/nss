<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoice;
use App\Models\PurchaseReceipt;
use App\Models\SalesDeliveries;
use App\Models\SalesInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', 'this_month');

        $startDate = null;
        $endDate = Carbon::now();

        switch ($periode) {
            case "today":
                $startDate = Carbon::now()->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                break;
            case "this_week":
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case "this_month":
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case "custom":
                $start = $request->input('start_date');
                $end = $request->input('end_date');

                if (!$start || !$end) {
                    return redirect()->back()->with('error', 'Tanggal awal dan akhir harus diisi untuk periode custom.');
                }

                $startDate = Carbon::parse($start);
                $endDate = Carbon::parse($end);
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
        }

        $totalSales = SalesDeliveries::whereBetween('delivery_date', [$startDate, $endDate])->where('status', '=', 'completed')->sum('total_amount');
        $totalPurchases = PurchaseReceipt::whereBetween('receipt_date', [$startDate, $endDate])->sum('total_amount');
        $netProfit = $totalSales - $totalPurchases;

        $yesterdaySales = SalesDeliveries::where('delivery_date', '=', Carbon::yesterday())->sum('total_amount');
        $yesterdayPurchases = PurchaseReceipt::where('receipt_date', '=', Carbon::yesterday())->sum('total_amount');
        $percentageChangeSales = ($yesterdaySales != 0) ? (($totalSales - $yesterdaySales) / $yesterdaySales) * 100 : 0;
        $percentageChangePurchases = ($yesterdayPurchases != 0) ? (($totalPurchases - $yesterdayPurchases) / $yesterdayPurchases) * 100 : 0;
        $statusSales = $percentageChangeSales >= 0 ? "+" . round($percentageChangeSales, 2) . "%" : "-" . round(abs($percentageChangeSales), 2) . "%";
        $statusPurchases = $percentageChangePurchases >= 0 ? "+" . round($percentageChangePurchases, 2) . "%" : "-" . round(abs($percentageChangePurchases), 2) . "%";

        $outstandingReceivables = SalesInvoice::where('payment_status', '=', 'unpaid')->sum('total_amount');
        $outstandingPayables = PurchaseInvoice::where('payment_status', '=', 'unpaid')->sum('total_amount');
        $receivableDueCount = SalesInvoice::where('payment_status', '=', 'unpaid')->count();
        $payableDueCount = PurchaseInvoice::where('payment_status', '=', 'unpaid')->count();

        return view('dashboard', compact(
            'periode',
            'totalSales',
            'totalPurchases',
            'netProfit',
            'statusSales',
            'statusPurchases',
            'yesterdaySales',
            'outstandingReceivables',
            'outstandingPayables',
            'receivableDueCount',
            'payableDueCount'
        ));
    }
}
