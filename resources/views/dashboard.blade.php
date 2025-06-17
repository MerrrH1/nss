<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="mb-6">
                        <label for="periode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Periode:</label>
                        <select id="periode" name="periode" class="mt-1 block w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <option value="today">Hari Ini</option>
                            <option value="this_week">Minggu Ini</option>
                            <option value="this_month" selected>Bulan Ini</option>
                            <option value="custom">Kustom</option>
                        </select>
                    </div>

                    <hr class="my-6 border-gray-300 dark:border-gray-700">

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Ringkasan Keuangan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg shadow-md">
                            <p class="text-sm font-medium text-blue-700 dark:text-blue-200">Total Penjualan</p>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-500 mt-1">{{ Number::currency($totalSales, 'IDR', 'id', 0) }}</p>
                            <p class="text-xs text-blue-600 dark:text-blue-300 mt-2">({{ $statusSales }} dari kemarin)</p>
                        </div>
                        {{-- Kartu Total Pembelian --}}
                        <div class="bg-red-100 dark:bg-red-900 p-4 rounded-lg shadow-md">
                            <p class="text-sm font-medium text-red-700 dark:text-red-200">Total Pembelian</p>
                            <p class="text-2xl font-bold text-red-900 dark:text-red-500 mt-1">{{ Number::currency($totalPurchases, 'IDR', 'id', 0) }}</p>
                            <p class="text-xs text-red-600 dark:text-red-300 mt-2">({{ $statusPurchases }} dari kemarin)</p>
                        </div>
                        {{-- Kartu Laba Bersih --}}
                        <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg shadow-md">
                            <p class="text-sm font-medium text-green-700 dark:text-green-200">Laba Bersih</p>
                            <p class="text-2xl font-bold text-green-900 dark:text-green-500 mt-1">{{ Number::currency($netProfit, 'IDR', 'id', 0) }}</p>
                            <p class="text-xs text-green-600 dark:text-green-300 mt-2">(Status: {{ $netProfit >= 0 ? "Positif" : "Negatif" }})</p>
                        </div>
                        {{-- Kartu Piutang Belum Tertagih --}}
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg shadow-md">
                            <p class="text-sm font-medium text-yellow-700 dark:text-yellow-200">Piutang Belum Tertagih</p>
                            <p class="text-2xl font-bold text-yellow-900 dark:text-yellow-500 mt-1">{{ Number::currency($outstandingReceivables, 'IDR', 'id', 0) }}</p>
                            <p class="text-xs text-yellow-600 dark:text-yellow-300 mt-2">({{ $receivableDueCount }} Jatuh Tempo)</p>
                        </div>
                        {{-- Kartu Utang Belum Terbayar --}}
                        <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-lg shadow-md">
                            <p class="text-sm font-medium text-purple-700 dark:text-purple-200">Utang Belum Terbayar</p>
                            <p class="text-2xl font-bold text-purple-900 dark:text-purple-500 mt-1">{{ Number::currency($outstandingPayables, 'IDR', 'id', 0) }}</p>
                            <p class="text-xs text-purple-600 dark:text-purple-300 mt-2">({{ $payableDueCount }} Jatuh Tempo)</p>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-300 dark:border-gray-700">

                    {{-- Bagian 2: Statistik Transaksi & Visualisasi --}}
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Statistik & Analisis</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        {{-- Grafik Tren Penjualan & Pembelian --}}
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md h-80 flex items-center justify-center">
                            <p class="text-gray-600 dark:text-gray-300">Placeholder: Grafik Tren Penjualan & Pembelian</p>
                            {{-- Di sini Anda akan mengintegrasikan library charting seperti Chart.js atau ApexCharts --}}
                        </div>
                        {{-- Grafik Distribusi Produk / Produk Terlaris --}}
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md h-80 flex items-center justify-center">
                            <p class="text-gray-600 dark:text-gray-300">Placeholder: Grafik Distribusi Produk</p>
                            {{-- Di sini Anda akan mengintegrasikan grafik pie chart --}}
                        </div>
                    </div>

                    {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-3">Produk Terlaris (Penjualan)</h4>
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">No</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Produk</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Jumlah</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Omzet</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">1</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">TBS</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">XXX Kg</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">Rp ...,...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-3">Pelanggan Teratas</h4>
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">No</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Nama Pelanggan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Total Penjualan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">1</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">Pelanggan A</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">Rp ...,...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}

                    <hr class="my-6 border-gray-300 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Operasional & Aktivitas</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-3">Transaksi Terbaru</h4>
                            <ul class="divide-y divide-gray-200 dark:divide-gray-600 max-h-60 overflow-y-auto">
                                <li class="py-3 flex justify-between items-center text-sm">
                                    <div>
                                        <p class="text-gray-900 dark:text-gray-200">Penjualan ke Pelanggan A</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">15 Juni 2025 - TBS (1000 Kg)</p>
                                    </div>
                                    <span class="text-green-600 dark:text-green-400 font-bold">Rp 5.000.000</span>
                                </li>
                                <li class="py-3 flex justify-between items-center text-sm">
                                    <div>
                                        <p class="text-gray-900 dark:text-gray-200">Pembelian dari Pemasok B</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">14 Juni 2025 - CPO (500 Ltr)</p>
                                    </div>
                                    <span class="text-red-600 dark:text-red-400 font-bold">- Rp 3.000.000</span>
                                </li>
                                {{-- Tambahkan item transaksi lain sesuai data --}}
                            </ul>
                        </div>
                    </div>
                    <div class="bg-orange-100 dark:bg-orange-900 p-4 rounded-lg shadow-md mb-8">
                        <h4 class="font-semibold text-orange-800 dark:text-orange-200 mb-3">Peringatan Penting</h4>
                        <ul class="list-disc list-inside text-orange-700 dark:text-orange-300">
                            <li>Piutang dari Pelanggan X sebesar Rp 1.500.000 jatuh tempo pada 17 Juni 2025.</li>
                            <li>Stok TBS Anda berada di bawah batas minimum. Segera lakukan pembelian.</li>
                        </ul>
                    </div>

                    {{-- Konten Dashboard Berakhir Di Sini --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>