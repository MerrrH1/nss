<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sales Deliveries') }}
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
                        <h3 class="text-lg font-medium">Manajemen Pengiriman Penjualan</h3>
                    </div>

                    {{-- Tabel Daftar Kontrak --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        No. Kontrak</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Tujuan</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Tanggal</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Netto Muat</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Netto Bongkar</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Total</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($salesDeliveries as $delivery)
                                    <tr>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                            <a href="{{ route('sales_contracts.show', $delivery->salesContract) }}"parameters: 
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">
                                                {{ $delivery->salesContract->contract_number }}
                                            </a>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                            {{ $delivery->salesContract->buyer->name }}</td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                            {{ $delivery->delivery_date->format('d M Y') }}</td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                            {{ number_format($delivery->net_weight_kg, 0, ',', '.') }} Kg</td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                            {{ number_format($delivery->final_net_weight_kg, 0, ',', '.') }} Kg</td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                            Rp {{ number_format($delivery->total_amount, 0, ',', '.') }}</td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('sales_deliveries.show', $delivery->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-3">Lihat</a>
                                            {{-- <a href="{{ route('sales_deliveries.edit', $delivery->id) }}"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600 mr-3">Edit</a>
                                            <form action="{{ route('sales_deliveries.destroy', $delivery->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontrak ini?');">
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
                                            Tidak ada kontrak penjualan yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginasi --}}
                    <div class="mt-4">
                        {{ $salesDeliveries->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
