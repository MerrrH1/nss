<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Kontrak Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Informasi Kontrak</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Nomor Kontrak:</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ $purchaseContract->contract_number }}</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Pemasok:</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ $purchaseContract->supplier->name }}</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Tanggal Kontrak:</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($purchaseContract->contract_date)->format('d F Y') }}</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Komoditas:</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ $purchaseContract->commodity->name }}</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Total Kuantitas (Kg):</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($purchaseContract->total_quantity_kg, 2, ',', '.') }} Kg</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Harga Per Kg (Rp):</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($purchaseContract->price_per_kg, 0, ',', '.') }}</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Kuantitas Diterima (Kg):</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($purchaseContract->quantity_received_kg, 2, ',', '.') }} Kg</p>
                            </div>
                             <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Status:</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($purchaseContract->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($purchaseContract->status == 'active') bg-blue-100 text-blue-800
                                        @elseif($purchaseContract->status == 'completed') bg-green-100 text-green-800
                                        @elseif($purchaseContract->status == 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($purchaseContract->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Toleransi Kualitas</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Toleransi KK (%):</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($purchaseContract->tolerated_kk_percentage, 2, ',', '.') }}%</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Toleransi KA (%):</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($purchaseContract->tolerated_ka_percentage, 2, ',', '.') }}%</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Toleransi FFA (%):</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($purchaseContract->tolerated_ffa_percentage, 2, ',', '.') }}%</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Toleransi DOBI (%):</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($purchaseContract->tolerated_dobi_percentage, 2, ',', '.') }}%</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Lain-lain</h3>
                        <div class="grid grid-cols-1 text-sm">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Catatan:</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ $purchaseContract->notes ?? '-' }}</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Dibuat Pada:</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($purchaseContract->created_at)->format('d F Y H:i') }}</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                <p class="font-medium text-gray-600 dark:text-gray-400">Terakhir Diperbarui:</p>
                                <p class="font-bold text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($purchaseContract->updated_at)->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        {{-- Tombol Edit (jika ada route untuk edit) --}}
                        <a href="{{ route('purchase_contracts.edit', $purchaseContract) }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Edit
                        </a>
                        {{-- Tombol Kembali --}}
                        <a href="{{ route('purchase_contracts.index') }}"
                           class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>