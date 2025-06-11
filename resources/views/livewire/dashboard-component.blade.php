<div class="mx-40">
    <div class="p-6 space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-2xl shadow">
                <h2 class="text-lg font-semibold">Total Pengguna</h2>
                <p class="text-2xl font-bold text-blue-600">{{ $totalUsers }}</p>
            </div>

            <div class="bg-white p-4 rounded-2xl shadow">
                <h2 class="text-lg font-semibold">Total Penjualan</h2>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>

            <div class="bg-white p-4 rounded-2xl shadow">
                <h2 class="text-lg font-semibold">Total Pembelian</h2>
                <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

</div>
