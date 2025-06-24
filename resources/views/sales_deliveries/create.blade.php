<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Unit Pengiriman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-6">Tambah Unit Pengiriman untuk Kontrak:
                        {{ $salesContract->contract_number }}</h3>
                    <div class="mb-5 justify-self-end">
                        <a href="{{ route('sales_contracts.show', $salesContract) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-700 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Kontrak {{ $salesContract->contract_number }}
                        </a>
                    </div>
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sales_deliveries.store', $salesContract) }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2 p-4 bg-gray-100 dark:bg-gray-700 rounded-md">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Detail Kontrak:</p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Nomor Kontrak: <span class="font-bold">{{ $salesContract->contract_number }}</span>
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Total Kuantitas: <span
                                        class="font-bold">{{ number_format($salesContract->total_quantity_kg, 0, ',', '.') }}
                                        Kg</span>
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Kuantitas Terkirim Saat Ini: <span
                                        class="font-bold">{{ number_format($salesContract->quantity_delivered_kg, 0, ',', '.') }}
                                        Kg</span>
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Sisa Kuantitas Tersedia: <span class="font-bold text-blue-600"
                                        id="remaining_contract_quantity">{{ number_format($salesContract->total_quantity_kg - $salesContract->quantity_delivered_kg, 0, ',', '.') }}
                                        Kg</span>
                                </p>
                                <input type="hidden" name="sales_contract_id" id="sales_contract_id"
                                    value="{{ $salesContract->id }}">
                            </div>

                            <div>
                                <label for="delivery_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                    Pengiriman</label>
                                <input type="date" name="delivery_date" id="delivery_date"
                                    value="{{ old('delivery_date', date('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    required>
                                @error('delivery_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="truck_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Truk</label>
                                <select name="truck_id" id="truck_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    required>
                                    <option value="">Pilih Truk</option>
                                    @foreach ($trucks as $truck)
                                        <option value="{{ $truck->id }}"
                                            {{ old('truck_id') == $truck->id ? 'selected' : '' }}>
                                            {{ $truck->plate_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('truck_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gross_weight_kg"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Bruto
                                    (Kg)</label>
                                <input type="number" name="gross_weight_kg" id="gross_weight_kg" step="0.01"
                                    value="{{ old('gross_weight_kg') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    required>
                                @error('gross_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tare_weight_kg"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Tara
                                    (Kg)</label>
                                <input type="number" name="tare_weight_kg" id="tare_weight_kg" step="0.01"
                                    value="{{ old('tare_weight_kg') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    required>
                                @error('tare_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan
                                    (Opsional)</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" id="submit_button"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Tambahkan Unit Pengiriman
                            </button>
                            <a href="{{ route('sales_contracts.show', $salesContract) }}"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
