<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Sales Contract') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                        <h3 class="text-lg font-medium">Detail Kontrak Penjualan: {{ $salesContract->contract_number }}
                        </h3>
                        <a href="{{ route('sales_contracts.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-700 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar
                        </a>
                    </div>

                    {{-- Sales Contract Details --}}
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-8">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Kontrak</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $salesContract->contract_number }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pelanggan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $salesContract->buyer->name }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Kontrak</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $salesContract->contract_date->format('d M Y') }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Produk</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $salesContract->commodity->name }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kuantitas</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ number_format($salesContract->total_quantity_kg, 0, ',', '.') }} Kg</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Harga per Kg</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">Rp
                                    {{ number_format($salesContract->price_per_kg, 0, ',', '.') }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kuantitas Terkirim</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ number_format($salesContract->quantity_delivered_kg, 0, ',', '.') }} Kg</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Sisa Kuantitas</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ number_format($salesContract->total_quantity_kg - $salesContract->quantity_delivered_kg, 0, ',', '.') }}
                                    Kg</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if ($salesContract->status == 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($salesContract->status == 'completed') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                        {{ ucfirst($salesContract->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi Kontrak</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $salesContract->notes ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('sales_contracts.edit', $salesContract) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Kontrak
                        </a>
                        @if ($salesContract->quantity_delivered_kg == 0)
                            <form action="{{ route('sales_contracts.destroy', $salesContract->id) }}" method="POST"
                                class="inline-block ml-3"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontrak ini? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Hapus Kontrak
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Delivery Units Section --}}
                    <div class="mt-10">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Unit Pengiriman Terkait
                        </h3>
                        @php
                            $remainingForDelivery =
                                $salesContract->total_quantity_kg - $salesContract->quantity_delivered_kg;
                        @endphp
                        @if ($remainingForDelivery > 0 && $salesContract->status === 'active')
                            <div class="flex justify-between mb-5"> {{-- Added a flex container with justify-between --}}
                                <a href="{{ route('sales_deliveries.createSalesDelivery', $salesContract) }}"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Unit Pengiriman
                                </a>

                                <a href="{{ route('sales_contract.closeContract', $salesContract) }}"
                                    onclick="event.preventDefault(); confirmCloseContract(this);" {{-- Added onclick event --}}
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tutup Kontrak
                                </a>
                            </div>

                            <script>
                                function confirmCloseContract(element) {
                                    if (confirm('Apakah Anda yakin ingin menutup kontrak ini? Tindakan ini tidak dapat dibatalkan.')) {
                                        window.location.href = element.href;
                                    }
                                }
                            </script>
                        @endif
                        @if ($salesContract->salesDeliveries->isEmpty())
                            <p class="text-gray-600 dark:text-gray-400">Tidak ada unit pengiriman yang terkait dengan
                                kontrak ini.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                                Tanggal Pengiriman</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                                No. Truk</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                                Netto Kirim (Kg)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                                Netto Bongkar (Kg)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                                KK (%)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                                KA (%)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                                FFA (%)</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                                Jumlah Klaim</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                                Jumlah Total</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        @foreach ($salesContract->salesDeliveries as $salesDelivery)
                                            <tr
                                                class="{{ $salesDelivery->status == 'completed' ? 'text-green-500' : ($salesDelivery->status == 'cancelled' ? 'text-red-400' : 'text-gray-900 dark:text-gray-200') }}">
                                                <td
                                                    class="px-6 py-4 text-center whitespace-nowrap text-sm {{ $salesDelivery->status == 'completed' ? 'text-green-500' : ($salesDelivery->status == 'cancelled' ? 'text-red-400' : 'text-gray-900 dark:text-gray-200') }}">
                                                    {{ $salesDelivery->delivery_date->format('d M Y') }}</td>
                                                <td
                                                    class="px-6 py-4 text-center whitespace-nowrap text-sm {{ $salesDelivery->status == 'completed' ? 'text-green-500' : ($salesDelivery->status == 'cancelled' ? 'text-red-400' : 'text-gray-900 dark:text-gray-200') }}">
                                                    {{ $salesDelivery->truck->plate_number ?? 'N/A' }}
                                                    {{-- Assuming a 'plate_number' attribute on Truck --}}
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-center whitespace-nowrap text-sm {{ $salesDelivery->status == 'completed' ? 'text-green-500' : ($salesDelivery->status == 'cancelled' ? 'text-red-400' : 'text-gray-900 dark:text-gray-200') }}">
                                                    {{ number_format($salesDelivery->net_weight_kg, 0, ',', '.') }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-center whitespace-nowrap text-sm {{ $salesDelivery->status == 'completed' ? 'text-green-500' : ($salesDelivery->status == 'cancelled' ? 'text-red-400' : 'text-gray-900 dark:text-gray-200') }}">
                                                    {{ number_format($salesDelivery->final_net_weight_kg, 0, ',', '.') }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-center whitespace-nowrap text-sm {{ $salesDelivery->status == 'completed' ? 'text-green-500' : ($salesDelivery->status == 'cancelled' ? 'text-red-400' : 'text-gray-900 dark:text-gray-200') }}">
                                                    {{ number_format($salesDelivery->kk_percentage, 2, ',', '.') }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-center whitespace-nowrap text-sm {{ $salesDelivery->status == 'completed' ? 'text-green-500' : ($salesDelivery->status == 'cancelled' ? 'text-red-400' : 'text-gray-900 dark:text-gray-200') }}">
                                                    {{ number_format($salesDelivery->ka_percentage, 2, ',', '.') }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-center whitespace-nowrap text-sm {{ $salesDelivery->status == 'completed' ? 'text-green-500' : ($salesDelivery->status == 'cancelled' ? 'text-red-400' : 'text-gray-900 dark:text-gray-200') }}">
                                                    {{ number_format($salesDelivery->ffa_percentage, 2, ',', '.') }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-center whitespace-nowrap text-sm {{ $salesDelivery->status == 'completed' ? 'text-green-500' : ($salesDelivery->status == 'cancelled' ? 'text-red-400' : 'text-gray-900 dark:text-gray-200') }}">
                                                    Rp {{ number_format($salesDelivery->claim_amount, 0, ',', '.') }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-center whitespace-nowrap text-sm {{ $salesDelivery->status == 'completed' ? 'text-green-500' : ($salesDelivery->status == 'cancelled' ? 'text-red-400' : 'text-gray-900 dark:text-gray-200') }}">
                                                    Rp {{ number_format($salesDelivery->total_amount, 0, ',', '.') }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-center whitespace-nowrap text-right text-sm font-medium">
                                                    @if ($salesDelivery->status == 'pending')
                                                        <a href="{{ route('sales_deliveries.unload', $salesDelivery->id) }}"
                                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600 mr-3">Edit</a>
                                                        <a href="{{ route('sales_deliveries.cancel', $salesDelivery->id) }}"
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Tolak</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
