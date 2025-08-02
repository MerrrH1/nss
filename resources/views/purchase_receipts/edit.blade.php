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
                    {{-- Pastikan $salesDelivery tersedia dari controller --}}
                    <h3 class="text-lg font-medium mb-6">Edit Unit Pengiriman:</h3>

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

                    {{-- Ubah action ke route update, tambahkan @method('PUT') --}}
                    <form method="POST" action="{{ route('sales_deliveries.update', $salesDelivery) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2 p-4 bg-gray-100 dark:bg-gray-700 rounded-md">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Detail Kontrak:</p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Nomor Kontrak: <span
                                        class="font-bold">{{ $salesDelivery->salesContract->contract_number }}</span>
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Total Kuantitas: <span
                                        class="font-bold">{{ number_format($salesDelivery->salesContract->total_quantity_kg, 0, ',', '.') }}
                                        Kg</span>
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Kuantitas Terkirim Saat Ini: <span
                                        class="font-bold">{{ number_format($salesDelivery->salesContract->quantity_delivered_kg, 0, ',', '.') }}
                                        Kg</span>
                                </p>
                                <p class="text-sm text-gray-900 dark:text-gray-200">
                                    Sisa Kuantitas Tersedia: <span class="font-bold text-blue-600"
                                        id="remaining_contract_quantity">{{ number_format($salesDelivery->salesContract->total_quantity_kg - $salesDelivery->salesContract->quantity_delivered_kg, 0, ',', '.') }}
                                        Kg</span>
                                </p>
                                <input type="hidden" name="sales_contract_id" id="sales_contract_id"
                                    value="{{ $salesDelivery->sales_contract_id }}">
                            </div>

                            <div>
                                <label for="delivery_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                    Pengiriman</label>
                                <input type="date" name="delivery_date" id="delivery_date"
                                    value="{{ old('delivery_date', $salesDelivery->delivery_date->format('Y-m-d')) }}"
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
                                            {{ old('truck_id', $salesDelivery->truck_id) == $truck->id ? 'selected' : '' }}>
                                            {{ $truck->plate_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('truck_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Gross Weight (Initial) --}}
                            <div>
                                <label for="gross_weight_kg_display"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Bruto
                                    (Kg)</label>
                                <input type="text" name="gross_weight_kg_display" id="gross_weight_kg_display"
                                    value="{{ (int) old('gross_weight_kg_display', $salesDelivery->gross_weight_kg) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    required>
                                @error('gross_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <input type="hidden" name="gross_weight_kg" id="gross_weight_kg"
                                value="{{ (int) old('gross_weight_kg', $salesDelivery->gross_weight_kg) }}" required>

                            {{-- Tare Weight (Initial) --}}
                            <div>
                                <label for="tare_weight_kg_display"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Tara
                                    (Kg)</label>
                                <input type="text" name="tare_weight_kg_display" id="tare_weight_kg_display"
                                    value="{{ (int) old('tare_weight_kg_display', $salesDelivery->tare_weight_kg) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    required>
                                @error('tare_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <input type="hidden" name="tare_weight_kg" id="tare_weight_kg"
                                value="{{ (int) old('tare_weight_kg', $salesDelivery->tare_weight_kg) }}" required>

                            {{-- Net Weight (Calculated Initial) --}}
                            <div>
                                <label for="net_weight_kg_display"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Netto
                                    (Kg)</label>
                                <input type="text" id="net_weight_kg_display"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 cursor-not-allowed"
                                    readonly>
                                {{-- The net_weight_kg hidden input is updated by JS, no need for old() here --}}
                                <input type="hidden" name="net_weight_kg" id="net_weight_kg"
                                    value="{{ (int) old('net_weight_kg', $salesDelivery->net_weight_kg) }}" required>
                                @error('net_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Final Gross Weight --}}
                            <div>
                                <label for="final_gross_weight_kg_display"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Bruto Final
                                    (Kg)</label>
                                <input type="text" name="final_gross_weight_kg_display"
                                    id="final_gross_weight_kg_display"
                                    value="{{ old('final_gross_weight_kg_display', $salesDelivery->final_gross_weight_kg) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    required>
                                @error('final_gross_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <input type="hidden" name="final_gross_weight_kg" id="final_gross_weight_kg"
                                value="{{ (int) old('final_gross_weight_kg', $salesDelivery->final_gross_weight_kg) }}"
                                required>

                            {{-- Final Tare Weight --}}
                            <div>
                                <label for="final_tare_weight_kg_display"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Tara Final
                                    (Kg)</label>
                                <input type="text" name="final_tare_weight_kg_display"
                                    id="final_tare_weight_kg_display"
                                    value="{{ old('final_tare_weight_kg_display', $salesDelivery->final_tare_weight_kg) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                    required>
                                @error('final_tare_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <input type="hidden" name="final_tare_weight_kg" id="final_tare_weight_kg"
                                value="{{ (int) old('final_tare_weight_kg', $salesDelivery->final_tare_weight_kg) }}"
                                required>

                            {{-- Final Net Weight (Calculated) --}}
                            <div>
                                <label for="final_net_weight_kg_display"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Netto
                                    Final (Kg)</label>
                                <input type="text" id="final_net_weight_kg_display"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 cursor-not-allowed"
                                    readonly>
                                <input type="hidden" name="final_net_weight_kg" id="final_net_weight_kg"
                                    value="{{ old('final_net_weight_kg', $salesDelivery->final_net_weight_kg) }}"
                                    required>
                                @error('final_net_weight_kg')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- KK Percentage --}}
                            <div>
                                <label for="kk_percentage"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">KK (%)</label>
                                <input type="number" name="kk_percentage" id="kk_percentage" step="0.01"
                                    value="{{ old('kk_percentage', $salesDelivery->kk_percentage) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                @error('kk_percentage')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- KA Percentage --}}
                            <div>
                                <label for="ka_percentage"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">KA (%)</label>
                                <input type="number" name="ka_percentage" id="ka_percentage" step="0.01"
                                    value="{{ old('ka_percentage', $salesDelivery->ka_percentage) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                @error('ka_percentage')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- FFA Percentage --}}
                            <div>
                                <label for="ffa_percentage"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">FFA (%)</label>
                                <input type="number" name="ffa_percentage" id="ffa_percentage" step="0.01"
                                    value="{{ old('ffa_percentage', $salesDelivery->ffa_percentage) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                @error('ffa_percentage')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="dobi"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">DOBI (%)</label>
                                <input type="number" name="dobi" id="dobi" step="0.01"
                                    value="{{ old('dobi', $salesDelivery->dobi) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                @error('dobi')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Notes --}}
                            <div class="md:col-span-2">
                                <label for="notes"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan
                                    (Opsional)</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('notes', $salesDelivery->notes) }}</textarea>
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
                            <a href="{{ route('sales_contracts.show', $salesDelivery->salesContract) }}"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                        </div>
                    </form>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const grossWeightHidden = document.getElementById('gross_weight_kg');
                            const tareWeightHidden = document.getElementById('tare_weight_kg');
                            const netWeightHidden = document.getElementById('net_weight_kg');

                            const grossWeightDisplay = document.getElementById('gross_weight_kg_display');
                            const tareWeightDisplay = document.getElementById('tare_weight_kg_display');
                            const netWeightDisplay = document.getElementById('net_weight_kg_display');

                            const finalGrossWeightHidden = document.getElementById('final_gross_weight_kg');
                            const finalTareWeightHidden = document.getElementById('final_tare_weight_kg');
                            const finalNetWeightHidden = document.getElementById('final_net_weight_kg');

                            const finalGrossWeightDisplay = document.getElementById('final_gross_weight_kg_display');
                            const finalTareWeightDisplay = document.getElementById('final_tare_weight_kg_display');
                            const finalNetWeightDisplay = document.getElementById('final_net_weight_kg_display');

                            function formatRibuan(angka) {
                                angka = String(angka).replace(/\D/g, '');
                                return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }

                            function updateNetWeight(grossHidden, tareHidden, netHidden, netDisplay) {
                                const gross = parseInt(grossHidden.value || 0);
                                const tare = parseInt(tareHidden.value || 0);
                                const net = gross - tare;
                                netHidden.value = net;
                                netDisplay.value = formatRibuan(net);
                            }

                            function handleDisplayInput(displayEl, hiddenEl, updateNetFn) {
                                displayEl.addEventListener('input', function() {
                                    const cleaned = this.value.replace(/\D/g, '');
                                    hiddenEl.value = cleaned;
                                    this.value = formatRibuan(cleaned);
                                    if (updateNetFn) updateNetFn();
                                });

                                // Initial formatting on load
                                displayEl.value = formatRibuan(hiddenEl.value);
                            }

                            // console.log(handleDisplayInput(grossWeightDisplay, grossWeightHidden, () => updateNetWeight(grossWeightHidden,
                            //     tareWeightHidden, netWeightHidden, netWeightDisplay));
                            // Apply to initial gross and tare
                            handleDisplayInput(grossWeightDisplay, grossWeightHidden, () => updateNetWeight(grossWeightHidden,
                                tareWeightHidden, netWeightHidden, netWeightDisplay));
                            handleDisplayInput(tareWeightDisplay, tareWeightHidden, () => updateNetWeight(grossWeightHidden,
                                tareWeightHidden, netWeightHidden, netWeightDisplay));

                            // Apply to final gross and tare
                            handleDisplayInput(finalGrossWeightDisplay, finalGrossWeightHidden, () => updateNetWeight(
                                finalGrossWeightHidden, finalTareWeightHidden, finalNetWeightHidden, finalNetWeightDisplay));
                            handleDisplayInput(finalTareWeightDisplay, finalTareWeightHidden, () => updateNetWeight(
                                finalGrossWeightHidden, finalTareWeightHidden, finalNetWeightHidden, finalNetWeightDisplay));

                            // Initial calculations for net weights on page load
                            updateNetWeight(grossWeightHidden, tareWeightHidden, netWeightHidden, netWeightDisplay);
                            updateNetWeight(finalGrossWeightHidden, finalTareWeightHidden, finalNetWeightHidden,
                                finalNetWeightDisplay);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
