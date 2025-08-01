<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Sales Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Informasi Invoice Penjualan</h3>
                        <a href="{{ route('sales_invoices.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kembali ke Daftar Invoice
                        </a>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-8">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Invoice</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $salesInvoice->invoice_number }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pembeli</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $salesInvoice->salesContract->buyer->name }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Invoice</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $salesInvoice->invoice_date->format('d M Y') }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Harga</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ 'Rp ' . number_format($salesInvoice->salesContract->is_bonded_zone == 1 ? $salesInvoice->sub_total : $salesInvoice->sub_total + $salesInvoice->tax_amount, 0, ',', '.') }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pembayaran</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $salesInvoice->payment_date ? \Carbon\Carbon::parse($salesInvoice->payment_date)->format('d M Y') : "Belum Bayar" }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Kontrak Penjualan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    <a href="{{ route('sales_contracts.show', $salesInvoice->salesContract) }}"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">
                                        {{ $salesInvoice->salesContract->contract_number }}
                                    </a>
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Keterangan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $salesInvoice->notes ?? 'Tidak ada keterangan.' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium mb-4">Detail Pengiriman</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                            Nomor Polisi</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                            Kuantitas (Kg)</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                            Harga / Kg (Rp)</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                            Klaim (Rp)</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                            Total Per Pengiriman</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @forelse ($salesInvoice->salesDeliveries as $delivery)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                                {{ $delivery->truck->plate_number }}</td>
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                                {{ number_format($delivery->final_net_weight_kg, 0, ',', '.') }}</td>
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                                {{ 'Rp ' . number_format($delivery->salesContract->price_per_kg, 0, ',', '.') }}</td>
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                                {{ 'Rp ' . number_format($delivery->claim_amount, 0, ',', '.') }}</td>
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                                {{ 'Rp ' . number_format($delivery->total_amount, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                Tidak ada detail pengiriman yang terkait dengan invoice ini.</td>
                                        </tr>
                                    @endforelse
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <td colspan="4" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Subtotal Invoice</td>
                                        <td class="px-6 py-3 text-center text-xs font-medium text-gray-900 dark:text-gray-200">{{ 'Rp ' . number_format($salesInvoice->sub_total, 0, ',', '.') }}</td>
                                    </tr>
                                    @if ($salesInvoice->salesContract->is_bonded_zone == 0) {{-- Only show tax if not bonded zone --}}
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <td colspan="4" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">PPN (11%)</td>
                                        <td class="px-6 py-3 text-center text-xs font-medium text-gray-900 dark:text-gray-200">{{ 'Rp ' . number_format($salesInvoice->tax_amount, 0, ',', '.') }}</td>
                                    </tr>
                                    @endif
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <td colspan="4" class="px-6 py-3 text-right text-base font-bold text-gray-900 dark:text-gray-200">Grand Total</td>
                                        <td class="px-6 py-3 text-center text-base font-bold text-gray-900 dark:text-gray-200">
                                            {{ 'Rp ' . number_format($salesInvoice->salesContract->is_bonded_zone == 1 ? $salesInvoice->sub_total : $salesInvoice->sub_total + $salesInvoice->tax_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3 items-center">
                        @if (!$salesInvoice->payment_date)
                            <form action="{{ route('sales_invoices.mark_as_paid', $salesInvoice) }}" method="POST" class="flex items-center space-x-3">
                                @csrf
                                @method('PATCH') {{-- Use PATCH for updating a resource --}}

                                <label for="payment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Bayar:</label>
                                <input type="date" id="payment_date" name="payment_date" required
                                    class="block w-auto rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    value="{{ old('payment_date', now()->format('Y-m-d')) }}">

                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Tandai Sudah Dibayar
                                </button>
                            </form>
                        @else
                            <span class="text-green-600 dark:text-green-400 font-semibold text-sm">Invoice Sudah Dibayar</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>