<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kontrak Pembelian') }}
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

                    <form action="{{ route('purchase_contracts.update', $purchaseContract) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Penting untuk metode UPDATE --}}

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            {{-- Supplier --}}
                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pemasok</label>
                                <select id="supplier_id" name="supplier_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">Pilih Pemasok</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchaseContract->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Contract Number (Biasanya read-only, atau dengan validasi unique:except) --}}
                            <div>
                                <label for="contract_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Kontrak</label>
                                <input type="text" name="contract_number" id="contract_number" value="{{ old('contract_number', $purchaseContract->contract_number) }}" required readonly {{-- Umumnya nomor kontrak tidak diubah --}}
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 bg-gray-100 dark:bg-gray-900">
                                    {{-- Jika ingin bisa diedit, hapus 'readonly' dan tambahkan validasi unique di controller --}}
                            </div>

                            {{-- Commodity --}}
                            <div>
                                <label for="commodity_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Komoditas</label>
                                <select id="commodity_id" name="commodity_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">Pilih Komoditas</option>
                                    @foreach($commodities as $commodity)
                                        <option value="{{ $commodity->id }}" {{ old('commodity_id', $purchaseContract->commodity_id) == $commodity->id ? 'selected' : '' }}>
                                            {{ $commodity->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Contract Date --}}
                            <div>
                                <label for="contract_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Kontrak</label>
                                <input type="date" name="contract_date" id="contract_date" value="{{ old('contract_date', $purchaseContract->contract_date->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Price Per Kg --}}
                            <div>
                                <label for="price_per_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Per Kg (Rp)</label>
                                <input type="number" step="0.01" name="price_per_kg" id="price_per_kg" value="{{ old('price_per_kg', $purchaseContract->price_per_kg) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Total Quantity Kg --}}
                            <div>
                                <label for="total_quantity_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Kuantitas (Kg)</label>
                                <input type="number" step="0.01" name="total_quantity_kg" id="total_quantity_kg" value="{{ old('total_quantity_kg', $purchaseContract->total_quantity_kg) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Tolerated KK Percentage --}}
                            <div>
                                <label for="tolerated_kk_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toleransi KK (%)</label>
                                <input type="number" step="0.01" name="tolerated_kk_percentage" id="tolerated_kk_percentage" value="{{ old('tolerated_kk_percentage', $purchaseContract->tolerated_kk_percentage) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Tolerated KA Percentage --}}
                            <div>
                                <label for="tolerated_ka_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toleransi KA (%)</label>
                                <input type="number" step="0.01" name="tolerated_ka_percentage" id="tolerated_ka_percentage" value="{{ old('tolerated_ka_percentage', $purchaseContract->tolerated_ka_percentage) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Tolerated FFA Percentage --}}
                            <div>
                                <label for="tolerated_ffa_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toleransi FFA (%)</label>
                                <input type="number" step="0.01" name="tolerated_ffa_percentage" id="tolerated_ffa_percentage" value="{{ old('tolerated_ffa_percentage', $purchaseContract->tolerated_ffa_percentage) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Tolerated DOBI Percentage --}}
                            <div>
                                <label for="tolerated_dobi_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toleransi DOBI (%)</label>
                                <input type="number" step="0.01" name="tolerated_dobi_percentage" id="tolerated_dobi_percentage" value="{{ old('tolerated_dobi_percentage', $purchaseContract->tolerated_dobi_percentage) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Quantity Received (Biasanya ini diupdate oleh sistem, tapi bisa juga di form edit jika ada kebutuhan) --}}
                            <div>
                                <label for="quantity_received_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kuantitas Diterima (Kg)</label>
                                <input type="number" step="0.01" name="quantity_received_kg" id="quantity_received_kg" value="{{ old('quantity_received_kg', $purchaseContract->quantity_received_kg) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>

                            {{-- Status --}}
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select id="status" name="status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="pending" {{ old('status', $purchaseContract->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="active" {{ old('status', $purchaseContract->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="completed" {{ old('status', $purchaseContract->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ old('status', $purchaseContract->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>

                            {{-- Notes --}}
                            <div class="sm:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('notes', $purchaseContract->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Perbarui Kontrak Pembelian
                            </button>
                            <a href="{{ route('purchase_contracts.show', $purchaseContract) }}"
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