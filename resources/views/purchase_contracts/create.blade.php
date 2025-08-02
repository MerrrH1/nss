<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Kontrak Pembelian Baru') }}
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

                    <form action="{{ route('purchase_contracts.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            {{-- Supplier --}}
                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pemasok</label>
                                <select id="supplier_id" name="supplier_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">Pilih Pemasok</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Contract Number --}}
                            <div>
                                <label for="contract_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Kontrak</label>
                                <input type="text" name="contract_number" id="contract_number" value="{{ old('contract_number') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Commodity --}}
                            <div>
                                <label for="commodity_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Komoditas</label>
                                <select id="commodity_id" name="commodity_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">Pilih Komoditas</option>
                                    @foreach($commodities as $commodity)
                                        <option value="{{ $commodity->id }}" {{ old('commodity_id') == $commodity->id ? 'selected' : '' }}>
                                            {{ $commodity->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Contract Date --}}
                            <div>
                                <label for="contract_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Kontrak</label>
                                <input type="date" name="contract_date" id="contract_date" value="{{ old('contract_date', now()->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- HAPUS valid_until_date karena tidak ada di tabel Anda --}}
                            {{-- <div>
                                <label for="valid_until_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berlaku Hingga Tanggal</label>
                                <input type="date" name="valid_until_date" id="valid_until_date" value="{{ old('valid_until_date', now()->addYear()->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div> --}}

                            {{-- Price Per Kg --}}
                            <div>
                                <label for="price_per_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Per Kg (Rp)</label>
                                <input type="number" step="0.01" name="price_per_kg" id="price_per_kg" value="{{ old('price_per_kg') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Total Quantity Kg --}}
                            <div>
                                <label for="total_quantity_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Kuantitas (Kg)</label>
                                <input type="number" step="0.01" name="total_quantity_kg" id="total_quantity_kg" value="{{ old('total_quantity_kg') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Tolerated KK Percentage --}}
                            <div>
                                <label for="tolerated_kk_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toleransi KK (%)</label>
                                <input type="number" step="0.01" name="tolerated_kk_percentage" id="tolerated_kk_percentage" value="{{ old('tolerated_kk_percentage', 0) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Tolerated KA Percentage --}}
                            <div>
                                <label for="tolerated_ka_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toleransi KA (%)</label>
                                <input type="number" step="0.01" name="tolerated_ka_percentage" id="tolerated_ka_percentage" value="{{ old('tolerated_ka_percentage', 0) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Tolerated FFA Percentage --}}
                            <div>
                                <label for="tolerated_ffa_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toleransi FFA (%)</label>
                                <input type="number" step="0.01" name="tolerated_ffa_percentage" id="tolerated_ffa_percentage" value="{{ old('tolerated_ffa_percentage', 0) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Tolerated DOBI Percentage --}}
                            <div>
                                <label for="tolerated_dobi_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toleransi DOBI (%)</label>
                                <input type="number" step="0.01" name="tolerated_dobi_percentage" id="tolerated_dobi_percentage" value="{{ old('tolerated_dobi_percentage', 0) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- HAPUS Is Bonded Zone karena tidak ada di tabel Anda --}}
                            {{-- <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Zona Berikat?</label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input id="is_bonded_zone_yes" name="is_bonded_zone" type="radio" value="1"
                                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                            {{ old('is_bonded_zone') == '1' ? 'checked' : '' }}>
                                        <label for="is_bonded_zone_yes" class="ml-3 block text-sm font-medium text-gray-900 dark:text-gray-200">Ya</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="is_bonded_zone_no" name="is_bonded_zone" type="radio" value="0"
                                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                            {{ old('is_bonded_zone') == '0' || old('is_bonded_zone') === null ? 'checked' : '' }}>
                                        <label for="is_bonded_zone_no" class="ml-3 block text-sm font-medium text-gray-900 dark:text-gray-200">Tidak</label>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- Notes --}}
                            <div class="sm:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan Kontrak Pembelian
                            </button>
                            <a href="{{ route('purchase_contracts.index') }}"
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