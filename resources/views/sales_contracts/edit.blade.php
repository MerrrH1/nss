<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Sales Contract') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-medium mb-6">Edit Kontrak Penjualan: {{ $salesContract->contract_number }}</h3>
                    {{ (int) $salesContract->price_per_kg }}
                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sales_contracts.update', $salesContract->id) }}">
                        @csrf
                        @method('PUT') {{-- Use PUT method for update operations --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Contract Number --}}
                            <div>
                                <label for="contract_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Kontrak</label>
                                <input type="text" name="contract_number" id="contract_number"
                                    value="{{ old('contract_number', $salesContract->contract_number) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                @error('contract_number')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Buyer --}}
                            <div>
                                <label for="buyer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pelanggan</label>
                                <select name="buyer_id" id="buyer_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach ($buyers as $buyer)
                                        <option value="{{ $buyer->id }}"
                                            {{ old('buyer_id', $salesContract->buyer_id) == $buyer->id ? 'selected' : '' }}>
                                            {{ $buyer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('buyer_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Commodity --}}
                            <div>
                                <label for="commodity_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produk</label>
                                <select name="commodity_id" id="commodity_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach ($commodities as $commodity)
                                        <option value="{{ $commodity->id }}"
                                            {{ old('commodity_id', $salesContract->commodity_id) == $commodity->id ? 'selected' : '' }}>
                                            {{ $commodity->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('commodity_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Contract Date --}}
                            <div>
                                <label for="contract_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Kontrak</label>
                                <input type="date" name="contract_date" id="contract_date"
                                    value="{{ old('contract_date', $salesContract->contract_date->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                @error('contract_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Total Quantity (Kg) --}}
                            <div>
                                <label for="total_quantity_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Kuantitas (Kg)</label>
                                <input type="number" name="total_quantity_kg" id="total_quantity_kg" step="0.01"
                                    value="{{ (int) old('total_quantity_kg', $salesContract->total_quantity_kg) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                @error('total_quantity_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Price per Kg --}}
                            <div>
                                <label for="price_per_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga per Kg (Rp)</label>
                                <input type="number" name="price_per_kg" id="price_per_kg" step="0.01"
                                    value="{{ (int) old('price_per_kg', $salesContract->price_per_kg) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                @error('price_per_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Quantity Delivered (Kg) --}}
                            {{-- Note: This field is often updated automatically based on deliveries,
                                 but if it's meant to be manually editable for adjustments, keep it.
                                 Otherwise, consider removing it from the edit form. --}}
                            <div>
                                <label for="quantity_delivered_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kuantitas Terkirim (Kg)</label>
                                <input type="number" name="quantity_delivered_kg" id="quantity_delivered_kg" step="0.01"
                                    value="{{ (int) old('quantity_delivered_kg', $salesContract->quantity_delivered_kg) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                @error('quantity_delivered_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- notes --}}
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi (Opsional)</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('notes', $salesContract->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Perbarui Kontrak
                            </button>
                            <a href="{{ route('sales_contracts.show', $salesContract->id) }}"
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