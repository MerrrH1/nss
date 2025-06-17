<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Kontrak Penjualan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('sales_contracts.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Kembali ke Daftar Kontrak
                        </a>
                    </div>

                    {{-- Pesan Error Validasi --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Terjadi kesalahan!</strong>
                            <span class="block sm:inline">Mohon periksa kembali input Anda.</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sales_contracts.store') }}" method="POST">
                        @csrf

                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Informasi Umum
                                Kontrak</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="contract_number"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Kontrak
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="contract_number" id="contract_number"
                                        value="{{ old('contract_number') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('contract_number') border-red-500 @enderror">
                                    @error('contract_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="buyer_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pelanggan
                                        <span class="text-red-500">*</span></label>
                                    <select name="buyer_id" id="buyer_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('buyer_id') border-red-500 @enderror">
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($buyers as $buyer)
                                            <option value="{{ $buyer->id }}"
                                                {{ old('buyer_id') == $buyer->id ? 'selected' : '' }}>
                                                {{ $buyer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('buyer_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="contract_date"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                        Kontrak <span class="text-red-500">*</span></label>
                                    <input type="date" name="contract_date" id="contract_date"
                                        value="{{ old('contract_date', date('Y-m-d')) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('contract_date') border-red-500 @enderror">
                                    @error('contract_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="status"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status <span
                                            class="text-red-500">*</span></label>
                                    <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('status') border-red-500 @enderror">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                            Selesai</option>
                                        <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>
                                            Batal</option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="total_quantity_kg"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tonase
                                        (Kg)</label>
                                    <input type="number" step="0.01" name="total_quantity_kg" id="total_quantity_kg"
                                        value="{{ old('total_quantity_kg') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('total_quantity_kg') border-red-500 @enderror">
                                    @error('total_quantity_kg')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="price_per_kg"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga per Kg
                                        (Rp)</label>
                                    <input type="number" step="0.01" name="price_per_kg" id="price_per_kg"
                                        value="{{ old('price_per_kg') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('price_per_kg') border-red-500 @enderror">
                                    @error('price_per_kg')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="commodity_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Komoditas
                                        <span class="text-red-500">*</span></label>
                                    <select name="commodity_id" id="commodity_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('commodity_id') border-red-500 @enderror">
                                        <option value="">-- Pilih Komoditas --</option>
                                        @foreach ($commodities as $commodity)
                                            <option value="{{ $commodity->id }}"
                                                {{ old('commodity_id') == $commodity->id ? 'selected' : '' }}>
                                                {{ $commodity->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('commodity_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="tolerated_kk_percentage"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Spesifikasi
                                        Kadar Kotoran (%)</label>
                                    <input type="number" step="0.01" name="tolerated_kk_percentage"
                                        id="tolerated_kk_percentage" value="{{ old('tolerated_kk_percentage') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('tolerated_kk_percentage') border-red-500 @enderror">
                                    @error('tolerated_kk_percentage')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="tolerated_ka_percentage"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Spesifikasi
                                        Kadar Air (%)</label>
                                    <input type="number" step="0.01" name="tolerated_ka_percentage"
                                        id="tolerated_ka_percentage" value="{{ old('tolerated_ka_percentage') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('tolerated_ka_percentage') border-red-500 @enderror">
                                    @error('tolerated_ka_percentage')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="tolerated_ffa_percentage"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Spesifikasi
                                        FFA (%)</label>
                                    <input type="number" step="0.01" name="tolerated_ffa_percentage"
                                        id="tolerated_ffa_percentage" value="{{ old('tolerated_ffa_percentage') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('tolerated_ffa_percentage') border-red-500 @enderror">
                                    @error('tolerated_ffa_percentage')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-6">
                                <label for="notes"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan/Keterangan</label>
                                <textarea name="notes" id="notes" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Bagian Detail Produk & Harga (Opsional, jika kontrak memiliki banyak item) --}}
                        {{-- Ini membutuhkan JavaScript untuk menambahkan/menghapus baris secara dinamis --}}
                        {{-- Contoh struktur dasar item, perlu JS untuk membuatnya dinamis: --}}
                        {{-- <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Detail Produk Kontrak</h3>
                            <div id="contract-items-container">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                                    <div>
                                        <label for="product_id_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produk</label>
                                        <select name="items[0][product_id]" id="product_id_0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                                            <option value="">Pilih Produk</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->unit }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="volume_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Volume</label>
                                        <input type="number" step="0.01" name="items[0][volume]" id="volume_0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                                    </div>
                                    <div>
                                        <label for="unit_price_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Satuan</label>
                                        <input type="number" step="0.01" name="items[0][unit_price]" id="unit_price_0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                                    </div>
                                    <div>
                                        <label for="price_condition_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kondisi Harga</label>
                                        <select name="items[0][price_condition]" id="price_condition_0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                                            <option value="Fixed">Tetap</option>
                                            <option value="Index">Mengikuti Indeks</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-item-btn" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                Tambah Item Produk
                            </button>
                        </div> --}}

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Simpan Kontrak
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Script JS untuk menambah item dinamis (jika diaktifkan) --}}
{{-- @push('scripts')
<script>
    let itemIndex = 1; // Mulai dari 1 karena 0 sudah ada secara statis (jika di uncomment)
    document.getElementById('add-item-btn').addEventListener('click', function () {
        const container = document.getElementById('contract-items-container');
        const newItem = document.createElement('div');
        newItem.classList.add('grid', 'grid-cols-1', 'md:grid-cols-4', 'gap-4', 'bg-gray-50', 'dark:bg-gray-700', 'p-4', 'rounded-lg', 'mb-4'); // Tambahkan kelas untuk styling
        newItem.innerHTML = `
            <div>
                <label for="product_id_${itemIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produk</label>
                <select name="items[${itemIndex}][product_id]" id="product_id_${itemIndex}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Pilih Produk</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->unit }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="volume_${itemIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Volume</label>
                <input type="number" step="0.01" name="items[${itemIndex}][volume]" id="volume_${itemIndex}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
            </div>
            <div>
                <label for="unit_price_${itemIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Satuan</label>
                <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" id="unit_price_${itemIndex}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
            </div>
            <div>
                <label for="price_condition_${itemIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kondisi Harga</label>
                <select name="items[${itemIndex}][price_condition]" id="price_condition_${itemIndex}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
                    <option value="Fixed">Tetap</option>
                    <option value="Index">Mengikuti Indeks</option>
                </select>
            </div>
            <div class="md:col-span-4 text-right">
                <button type="button" class="remove-item-btn text-red-600 hover:text-red-900">Hapus Item</button>
            </div>
        `;
        container.appendChild(newItem);

        // Menambahkan event listener untuk tombol hapus item
        newItem.querySelector('.remove-item-btn').addEventListener('click', function() {
            newItem.remove();
        });

        itemIndex++;
    });
</script>
@endpush --}}
