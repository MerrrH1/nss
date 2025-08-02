{{-- resources/views/sales_invoices/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Invoice Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

                    <form method="POST" action="{{ route('sales_invoices.store') }}" id="invoiceForm">
                        @csrf

                        {{-- Nomor Invoice --}}
                        <div class="mb-4">
                            <label for="invoice_number"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Invoice</label>
                            <input type="text" name="invoice_number" id="invoice_number"
                                value="{{ old('invoice_number') }}"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required>
                            @error('invoice_number')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Pilihan Pengiriman untuk 'bulk_payment' --}}
                        @if ($invoiceType === 'bulk_payment')
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih
                                    Pengiriman Selesai untuk Invoice:</label>
                                @if ($completedDeliveries->isNotEmpty())
                                    <div
                                        class="mt-1 border rounded-md p-3 max-h-60 overflow-y-auto bg-gray-50 dark:bg-gray-700">
                                        @foreach ($completedDeliveries as $delivery)
                                            <div class="flex items-start mb-2">
                                                <input type="checkbox" name="selected_deliveries[]"
                                                    value="{{ $delivery->id }}" id="delivery-{{ $delivery->id }}"
                                                    class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:checked:bg-indigo-600"
                                                    data-net-weight="{{ $delivery->final_net_weight_kg }}"
                                                    data-delivery-date="{{ $delivery->delivery_date->format('Y-m-d') }}"
                                                    {{ in_array($delivery->id, old('selected_deliveries', [])) ? 'checked' : '' }}>
                                                <label for="delivery-{{ $delivery->id }}"
                                                    class="ml-2 text-sm text-gray-900 dark:text-gray-200">
                                                    Pengiriman Tanggal: {{ $delivery->delivery_date->format('d M Y') }}
                                                    - Truk: {{ $delivery->truck->plate_number ?? 'N/A' }} <br>
                                                    Netto Bongkar:
                                                    {{ number_format($delivery->final_net_weight_kg, 0, ',', '.') }} Kg
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Tidak ada pengiriman
                                        selesai yang tersedia dan belum di-invoice untuk kontrak ini.</p>
                                @endif
                            </div>
                        @endif

                        {{-- Tanggal Invoice --}}
                        <div class="mb-4">
                            <label for="invoice_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                Invoice</label>
                            <input type="date" name="invoice_date" id="invoice_date"
                                value="{{ old('invoice_date', date('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required>
                            @error('invoice_date')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Jatuh Tempo --}}
                        <div class="mb-4">
                            <label for="due_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Jatuh
                                Tempo</label>
                            <input type="date" name="due_date" id="due_date"
                                value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required>
                            @error('due_date')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Sub Total (Display) --}}
                        <div class="mb-4">
                            <label for="sub_total_display"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sub Total
                                (Rp)</label>
                            <input type="text" id="sub_total_display"
                                value="{{ old('sub_total', number_format($suggestedAmount, 0, ',', '.')) }}"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                @if ($invoiceType !== 'bulk_payment') readonly @endif>
                            @error('sub_total')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="sub_total" id="sub_total"
                            value="{{ (int) old('sub_total', $suggestedAmount) }}">

                        {{-- Pajak (Display) --}}
                        <div class="mb-4">
                            <label for="tax_amount_display"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pajak (Rp)</label>
                            <input type="text" id="tax_amount_display"
                                value="{{ (int) old('tax_amount', number_format($suggestedAmount * 0.11, 0, ',', '.')) }}"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                @if ($invoiceType !== 'bulk_payment') readonly @endif>
                            @error('tax_amount')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="tax_amount" id="tax_amount"
                            value="{{ old('tax_amount', $suggestedAmount * 0.11) }}">

                        {{-- Total Jumlah Invoice (Display) --}}
                        <div class="mb-4">
                            <label for="total_amount_display"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Jumlah Invoice
                                (Rp)</label>
                            <input type="text" id="total_amount_display"
                                value="{{ old('total_amount', number_format($suggestedAmount, 0, ',', '.')) }}"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                readonly> {{-- Total Amount always read-only --}}
                            @error('total_amount')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="total_amount" id="total_amount"
                            value="{{ (int) old('total_amount', $suggestedAmount) }}">

                        {{-- Catatan --}}
                        <div class="mb-4">
                            <label for="notes"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan
                                (Opsional)</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Buat Invoice
                            </button>
                            <a href="{{ route('sales_contracts.show', $salesContract) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi pembantu untuk memformat angka menjadi format ID (e.g., 1.000.000)
        function formatNumber(number) {
            if (isNaN(number) || number === null || number === undefined) {
                return '';
            }
            // Menggunakan toLocaleString untuk format angka Indonesia
            return number.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            });
        }

        // Fungsi pembantu untuk membersihkan format angka dari string (e.g., "1.000.000,00" menjadi 1000000.00)
        function cleanNumber(string) {
            if (typeof string !== 'string' || string === null) {
                return NaN;
            }
            // Hapus titik sebagai pemisah ribuan dan ganti koma menjadi titik untuk desimal
            const cleaned = string.replace(/\./g, '').replace(/,/g, '.');
            return parseFloat(cleaned);
        }

        // Fungsi utama untuk menghitung dan memperbarui nilai invoice
        function calculateAndDisplayInvoiceAmounts() {
            const salesContractPaymentTerm = '{{ $salesContract->payment_term }}';
            const pricePerKg = {{ $salesContract->price_per_kg ?? 0 }};
            const taxRate = 0.11; // 11% PPN

            const subTotalDisplay = document.getElementById('sub_total_display');
            const taxAmountDisplay = document.getElementById('tax_amount_display');
            const totalAmountDisplay = document.getElementById('total_amount_display');

            const subTotalHidden = document.getElementById('sub_total');
            const taxAmountHidden = document.getElementById('tax_amount');
            const totalAmountHidden = document.getElementById('total_amount');

            let currentSubTotal = 0;

            if (salesContractPaymentTerm === 'bulk_payment') {
                const deliveryCheckboxes = document.querySelectorAll('input[name="selected_deliveries[]"]');
                let totalNetWeight = 0;
                let latestDeliveryDate = null;

                deliveryCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        totalNetWeight += parseFloat(checkbox.dataset.netWeight || 0);

                        // Ambil tanggal pengiriman terbaru untuk dijadikan tanggal invoice
                        const currentDeliveryDate = checkbox.dataset.deliveryDate;
                        if (currentDeliveryDate) {
                            if (!latestDeliveryDate || currentDeliveryDate > latestDeliveryDate) {
                                latestDeliveryDate = currentDeliveryDate;
                            }
                        }
                    }
                });

                // Perbarui tanggal invoice dengan tanggal pengiriman terbaru yang dipilih
                const invoiceDateInput = document.getElementById('invoice_date');
                if (invoiceDateInput) {
                    if (latestDeliveryDate) {
                        invoiceDateInput.value = latestDeliveryDate;
                    } else {
                        // Jika tidak ada pengiriman yang dipilih, set ke tanggal hari ini
                        invoiceDateInput.value = new Date().toISOString().slice(0, 10);
                    }
                    // Update tanggal jatuh tempo setelah tanggal invoice berubah
                    updateDueDate();
                }

                currentSubTotal = totalNetWeight * pricePerKg;

            } else {
                // Untuk dp50, full_payment, sub_total, tax_amount, dan total_amount sudah dihitung di backend
                // dan diset sebagai nilai awal. Cukup pastikan ditampilkan dengan format yang benar.
                currentSubTotal = cleanNumber(subTotalHidden.value);
            }

            const calculatedTaxAmount = currentSubTotal * taxRate;
            const calculatedTotalAmount = currentSubTotal + calculatedTaxAmount;

            // Set nilai ke hidden input (untuk dikirim ke backend)
            subTotalHidden.value = currentSubTotal.toFixed(2);
            taxAmountHidden.value = calculatedTaxAmount.toFixed(2);
            totalAmountHidden.value = calculatedTotalAmount.toFixed(2);

            // Tampilkan nilai yang sudah diformat ke user
            subTotalDisplay.value = formatNumber(currentSubTotal);
            taxAmountDisplay.value = formatNumber(calculatedTaxAmount);
            totalAmountDisplay.value = formatNumber(calculatedTotalAmount);

            // Jika bukan bulk_payment, input sub_total dan tax_amount seharusnya read-only
            if (salesContractPaymentTerm !== 'bulk_payment') {
                if (subTotalDisplay) subTotalDisplay.readOnly = true;
                if (taxAmountDisplay) taxAmountDisplay.readOnly = true;
            } else {
                if (subTotalDisplay) subTotalDisplay.readOnly = true; // Juga read-only karena dihitung
                if (taxAmountDisplay) taxAmountDisplay.readOnly = true; // Juga read-only karena dihitung
            }
        }

        // Fungsi untuk memperbarui Tanggal Jatuh Tempo berdasarkan Tanggal Invoice
        function updateDueDate() {
            const invoiceDateInput = document.getElementById('invoice_date');
            const dueDateInput = document.getElementById('due_date');

            if (!invoiceDateInput || !dueDateInput) {
                return;
            }

            const invoiceDateValue = invoiceDateInput.value;

            if (invoiceDateValue) {
                const invoiceDate = new Date(invoiceDateValue);
                // Menambahkan 30 hari ke tanggal invoice
                invoiceDate.setDate(invoiceDate.getDate() + 1);

                const year = invoiceDate.getFullYear();
                const month = String(invoiceDate.getMonth() + 1).padStart(2, '0');
                const day = String(invoiceDate.getDate()).padStart(2, '0');

                dueDateInput.value = `${year}-${month}-${day}`;
            } else {
                // Jika tanggal invoice kosong, kosongkan tanggal jatuh tempo
                dueDateInput.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Panggil fungsi perhitungan saat DOM dimuat untuk inisialisasi
            calculateAndDisplayInvoiceAmounts();
            updateDueDate(); // Pastikan due date terisi saat pertama kali halaman dimuat

            const salesContractPaymentTerm = '{{ $salesContract->payment_term }}';

            // Tambahkan event listener untuk checkbox pengiriman jika payment_term adalah 'bulk_payment'
            if (salesContractPaymentTerm === 'bulk_payment') {
                const deliveryCheckboxes = document.querySelectorAll('input[name="selected_deliveries[]"]');
                deliveryCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', calculateAndDisplayInvoiceAmounts);
                });
            }

            // Event listener untuk Tanggal Invoice
            const invoiceDateInput = document.getElementById('invoice_date');
            if (invoiceDateInput) {
                invoiceDateInput.addEventListener('change', updateDueDate);
            }

            // Pastikan nilai tersembunyi diperbarui sebelum form disubmit
            const invoiceForm = document.getElementById('invoiceForm');
            if (invoiceForm) {
                invoiceForm.addEventListener('submit', function() {
                    // Panggil lagi untuk memastikan nilai terakhir sudah dihitung dan diset ke hidden input
                    calculateAndDisplayInvoiceAmounts();
                });
            }
        });
    </script>
</x-app-layout>
