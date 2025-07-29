<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Penjual Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('suppliers.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Kembali ke Daftar Penjual
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

                    <form action="{{ route('suppliers.store') }}" method="POST">
                        @csrf

                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Informasi Umum
                                Penjual</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Penjual</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('address') border-red-500 @enderror">
                                    @error('address')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
                                        Telepon</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('phone') border-red-500 @enderror">
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="contact_person"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kontak</label>
                                    <input type="text" name="contact_person" id="contact_person"
                                        value="{{ old('contact_person') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('contact_person') border-red-500 @enderror">
                                    @error('contact_person')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="npwp"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">NPWP</label>
                                    <input type="text" name="npwp" id="npwp" value="{{ old('npwp') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('npwp') border-red-500 @enderror">
                                    @error('npwp')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-5 flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Simpan Penjual
                                </button>
                            </div>
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
