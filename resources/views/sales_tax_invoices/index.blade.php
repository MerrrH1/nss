<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Faktur Pajak Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Manajemen Faktur Pajak Penjualan</h3>
                        {{-- TOMBOL CREATE BARU DITAMBAHKAN DI SINI --}}
                        <a href="{{ route('sales_tax_invoices.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah Faktur Pajak Baru
                        </a>
                    </div>

                    {{-- Tabel Daftar Faktur Pajak --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Nomor Faktur Pajak</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Tanggal Faktur Pajak</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        DPP Amount</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        PPN Amount</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Tanggal Pembayaran</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($salesTaxInvoices as $taxInvoice)
                                    <tr>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                            <a href="{{ route('sales_tax_invoices.show', $taxInvoice->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">
                                                {{ $taxInvoice->tax_invoice_number }}
                                            </a>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                            {{ \Carbon\Carbon::parse($taxInvoice->tax_invoice_date)->format('d M Y') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                            {{ 'Rp ' . number_format($taxInvoice->dpp_amount, 0, ',', '.') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                            {{ 'Rp ' . number_format($taxInvoice->ppn_amount, 0, ',', '.') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm {{ $taxInvoice->payment_date ? "text-gray-900 dark:text-gray-200" : "text-red-900 dark:text-red-200"}}">
                                            {{ $taxInvoice->payment_date ? \Carbon\Carbon::parse($taxInvoice->payment_date)->format('d M Y') : 'Belum Bayar' }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('sales_tax_invoices.show', $taxInvoice->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-3">Lihat</a>
                                            {{-- Add Edit/Delete buttons if needed --}}
                                            {{-- <a href="{{ route('sales_tax_invoices.edit', $taxInvoice->id) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600 mr-3">Edit</a>
                                            <form action="{{ route('sales_tax_invoices.destroy', $taxInvoice->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus faktur pajak ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Hapus</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Tidak ada faktur pajak penjualan yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginasi --}}
                    <div class="mt-4">
                        {{ $salesTaxInvoices->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>