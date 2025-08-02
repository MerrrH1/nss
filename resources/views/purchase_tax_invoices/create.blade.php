<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Faktur Pajak Penjualan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sales_tax_invoices.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="sales_invoice_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Invoice Penjualan Terkait</label>
                                <select id="sales_invoice_id" name="sales_invoice_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">Pilih Invoice Penjualan</option>
                                    {{-- Loop melalui salesInvoices yang belum memiliki TaxInvoice, jika Anda mengirimkannya dari controller --}}
                                    {{-- @foreach($salesInvoices as $salesInvoice)
                                        <option value="{{ $salesInvoice->id }}" {{ old('sales_invoice_id') == $salesInvoice->id ? 'selected' : '' }}>
                                            {{ $salesInvoice->invoice_number }}
                                        </option>
                                    @endforeach --}}
                                    {{-- Contoh statis atau dari database yang belum punya faktur pajak --}}
                                    <option value="1">INV-2023001 (Contoh)</option>
                                    <option value="2">INV-2023002 (Contoh)</option>
                                </select>
                            </div>

                            <div>
                                <label for="tax_invoice_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Faktur Pajak</label>
                                <input type="text" name="tax_invoice_number" id="tax_invoice_number" value="{{ old('tax_invoice_number') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            <div>
                                <label for="tax_invoice_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Faktur Pajak</label>
                                <input type="date" name="tax_invoice_date" id="tax_invoice_date" value="{{ old('tax_invoice_date', now()->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            <div>
                                <label for="dpp_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">DPP Amount</label>
                                <input type="number" step="0.01" name="dpp_amount" id="dpp_amount" value="{{ old('dpp_amount') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            <div>
                                <label for="ppn_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PPN Amount</label>
                                <input type="number" step="0.01" name="ppn_amount" id="ppn_amount" value="{{ old('ppn_amount') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan Faktur Pajak
                            </button>
                            <a href="{{ route('sales_tax_invoices.index') }}"
                                class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>