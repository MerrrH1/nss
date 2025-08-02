<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Faktur Pajak Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Informasi Faktur Pajak</h3>
                        <a href="{{ route('sales_tax_invoices.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kembali ke Daftar Faktur Pajak
                        </a>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-8">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Faktur Pajak</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $salesTaxInvoice->tax_invoice_number }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Invoice Penjualan
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    @if ($salesTaxInvoice->salesInvoice)
                                        <a href="{{ route('sales_invoices.show', $salesTaxInvoice->salesInvoice->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">
                                            {{ $salesTaxInvoice->salesInvoice->invoice_number }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Faktur Pajak
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($salesTaxInvoice->tax_invoice_date)->format('d M Y') }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1"></div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">DPP Amount</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ 'Rp ' . number_format($salesTaxInvoice->dpp_amount, 0, ',', '.') }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">PPN Amount</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ 'Rp ' . number_format($salesTaxInvoice->ppn_amount, 0, ',', '.') }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pembayaran</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $salesTaxInvoice->payment_date ? \Carbon\Carbon::parse($salesTaxInvoice->payment_date)->format('d M Y') : 'Belum Dibayar' }}
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Keterangan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $salesTaxInvoice->notes ?? 'Tidak ada keterangan.' }}</dd>
                            </div>
                            @if ($salesTaxInvoice->deleted_at)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dihapus Pada</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                        {{ \Carbon\Carbon::parse($salesTaxInvoice->deleted_at)->format('d M Y H:i:s') }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3 items-center">
                        @if ($salesTaxInvoice->payment_status !== 'paid')
                            <form action="{{ route('tax_invoices.mark_as_paid', $salesTaxInvoice) }}" method="POST"
                                class="flex items-center space-x-3">
                                @csrf
                                @method('PATCH') {{-- Use PATCH for updating a resource --}}

                                <label for="payment_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                    Bayar:</label>
                                <input type="date" id="payment_date" name="payment_date" required
                                    class="block w-auto rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    value="{{ old('payment_date', now()->format('Y-m-d')) }}">

                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Tandai Sudah Dibayar
                                </button>
                            </form>
                        @else
                            <span class="text-green-600 dark:text-green-400 font-semibold text-sm">Faktur Pajak Sudah
                                Dibayar</span>
                        @endif

                        <div class="mt-6 flex justify-end space-x-3">
                            {{-- Add action buttons here, e.g., Edit, Delete --}}
                            {{-- <a href="{{ route('sales_tax_invoices.edit', $salesTaxInvoice->id) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Edit Faktur Pajak
                        </a>
                        <form action="{{ route('sales_tax_invoices.destroy', $salesTaxInvoice->id) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus faktur pajak ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Hapus Faktur Pajak
                            </button>
                        </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
