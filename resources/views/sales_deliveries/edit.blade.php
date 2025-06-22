<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Unit Pengiriman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Pastikan $salesDeliveries tersedia dari controller --}}
                    <h3 class="text-lg font-medium mb-6">Edit Unit Pengiriman: {{ $salesDeliveries->delivery_number }}</h3>

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

                    {{-- Ubah action ke route update, tambahkan @method('PUT') --}}
                    <form method="POST" action="{{ route('sales_deliveries.update', $salesDeliveries) }}">
                        @csrf
                        @method('PUT') {{-- PENTING untuk method PUT --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Sales Contract Info (Read-only) - Ambil dari $salesDeliveries->salesContract --}}
                            <div class="md:col-span-2 p-4 bg-gray-100 dark:bg-gray-700 rounded-md">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Detail Kontrak:</p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Nomor Kontrak: <span class="font-bold">{{ $salesDeliveries->salesContract->contract_number }}</span>
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Total Kuantitas: <span class="font-bold">{{ number_format($salesDeliveries->salesContract->total_quantity_kg, 0, ',', '.') }} Kg</span>
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Kuantitas Terkirim Saat Ini: <span class="font-bold">{{ number_format($salesDeliveries->salesContract->quantity_delivered_kg, 0, ',', '.') }} Kg</span>
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Sisa Kuantitas Tersedia: <span class="font-bold text-blue-600" id="remaining_contract_quantity">{{ number_format($salesDeliveries->salesContract->total_quantity_kg - $salesDeliveries->salesContract->quantity_delivered_kg, 0, ',', '.') }} Kg</span>
                                </p>
                                {{-- Hidden input ini mungkin tidak perlu di halaman edit jika sales_contract_id sudah dipertahankan oleh $salesDeliveries --}}
                                <input type="hidden" name="sales_contract_id" id="sales_contract_id" value="{{ $salesDeliveries->sales_contract_id }}">
                            </div>


                            {{-- Delivery Number --}}
                            <div>
                                <label for="delivery_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Pengiriman</label>
                                <input type="text" name="delivery_number" id="delivery_number"
                                    value="{{ old('delivery_number', $salesDeliveries->delivery_number) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                @error('delivery_number')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Delivery Date --}}
                            <div>
                                <label for="delivery_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pengiriman</label>
                                <input type="date" name="delivery_date" id="delivery_date"
                                    value="{{ old('delivery_date', $salesDeliveries->delivery_date->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                @error('delivery_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Truck --}}
                            <div>
                                <label for="truck_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Truk</label>
                                <select name="truck_id" id="truck_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                    <option value="">Pilih Truk</option>
                                    @foreach ($trucks as $truck)
                                        <option value="{{ $truck->id }}" {{ old('truck_id', $salesDeliveries->truck_id) == $truck->id ? 'selected' : '' }}>
                                            {{ $truck->plate_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('truck_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Gross Weight --}}
                            <div>
                                <label for="gross_weight_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Bruto (Kg)</label>
                                <input type="number" name="gross_weight_kg" id="gross_weight_kg" step="0.01"
                                    value="{{ old('gross_weight_kg', $salesDeliveries->gross_weight_kg) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                @error('gross_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tare Weight --}}
                            <div>
                                <label for="tare_weight_kg" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Tara (Kg)</label>
                                <input type="number" name="tare_weight_kg" id="tare_weight_kg" step="0.01"
                                    value="{{ old('tare_weight_kg', $salesDeliveries->tare_weight_kg) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                                @error('tare_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Net Weight (Calculated) --}}
                            <div>
                                <label for="net_weight_kg_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Netto (Kg)</label>
                                <input type="text" id="net_weight_kg_display"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 cursor-not-allowed"
                                    value="{{ old('net_weight_kg', $salesDeliveries->net_weight_kg) }}" readonly>
                                <input type="hidden" name="net_weight_kg" id="net_weight_kg" value="{{ old('net_weight_kg', $salesDeliveries->net_weight_kg) }}">
                                @error('net_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- KK Percentage --}}
                            <div>
                                <label for="kk_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">KK (%)</label>
                                <input type="number" name="kk_percentage" id="kk_percentage" step="0.01"
                                    value="{{ old('kk_percentage', $salesDeliveries->kk_percentage) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                @error('kk_percentage')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- KA Percentage --}}
                            <div>
                                <label for="ka_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">KA (%)</label>
                                <input type="number" name="ka_percentage" id="ka_percentage" step="0.01"
                                    value="{{ old('ka_percentage', $salesDeliveries->ka_percentage) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                @error('ka_percentage')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- FFA Percentage --}}
                            <div>
                                <label for="ffa_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">FFA (%)</label>
                                <input type="number" name="ffa_percentage" id="ffa_percentage" step="0.01"
                                    value="{{ old('ffa_percentage', $salesDeliveries->ffa_percentage) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                @error('ffa_percentage')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Final Net Weight (Calculated) --}}
                            <div>
                                <label for="final_net_weight_kg_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Netto Final (Kg)</label>
                                <input type="text" id="final_net_weight_kg_display"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 cursor-not-allowed"
                                    value="{{ old('final_net_weight_kg', $salesDeliveries->final_net_weight_kg) }}" readonly>
                                <input type="hidden" name="final_net_weight_kg" id="final_net_weight_kg" value="{{ old('final_net_weight_kg', $salesDeliveries->final_net_weight_kg) }}">
                                @error('final_net_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p id="quantity_warning" class="mt-1 text-sm text-red-600 dark:text-red-400 hidden">
                                    Berat Netto Final melebihi sisa kuantitas kontrak!
                                </p>
                            </div>

                            {{-- Claim Amount --}}
                            <div>
                                <label for="claim_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Klaim (Rp)</label>
                                <input type="number" name="claim_amount" id="claim_amount" step="0.01"
                                    value="{{ old('claim_amount', $salesDeliveries->claim_amount) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                @error('claim_amount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Notes --}}
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan (Opsional)</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('notes', $salesDeliveries->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" id="submit_button"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Perbarui Unit Pengiriman
                            </button>
                            {{-- Anda mungkin ingin menambahkan tombol batal yang mengarah kembali ke detail kontrak atau daftar sales deliveries --}}
                             <a href="{{ route('sales_deliveries.show', $salesDeliveries) }}"
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