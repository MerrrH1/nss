<div class="p-6 mx-32">
    <button wire:click="create" class="mb-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah
        Customer</button>

    <table class="w-full text-left border">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">#</th>
                <th class="p-2">Nama</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr class="border-t">
                    <td class="p-2 text-white">{{ $loop->iteration }}</td>
                    <td class="p-2 text-white">{{ $customer->name }}</td>
                    <td class="p-2">
                        <button wire:click="showDetail({{ $customer->id }})"
                            class="text-blue-600 hover:underline">Detail</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4">
                    @if ($isDetail)
                        Detail Customer
                    @elseif ($isEdit)
                        Edit Customer
                    @else
                        Tambah Customer
                    @endif
                </h2>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama</label>
                    @if ($isDetail)
                        <p class="mt-1">{{ $name }}</p>
                    @else
                        <input type="text" wire:model="name" class="w-full border rounded px-3 py-2 mt-1">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Nomor Telepon</label>
                    @if ($isDetail)
                        <p class="mt-1">{{ $phone }}</p>
                    @else
                        <input type="text" wire:model="phone" class="w-full border rounded px-3 py-2 mt-1">
                        @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Email</label>
                    @if ($isDetail)
                        <p class="mt-1">{{ $email }}</p>
                    @else
                        <input type="email" wire:model="email" class="w-full border rounded px-3 py-2 mt-1">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Alamat</label>
                    @if ($isDetail)
                        <p class="mt-1">{{ $address }}</p>
                    @else
                        <input type="text" wire:model="address" class="w-full border rounded px-3 py-2 mt-1">
                        @error('address')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">NPWP</label>
                    @if ($isDetail)
                        <p class="mt-1">{{ $tax_number }}</p>
                    @else
                        <input type="text" wire:model="tax_number" class="w-full border rounded px-3 py-2 mt-1">
                        @error('tax_number')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Nomor Rekening</label>
                    @if ($isDetail)
                        <p class="mt-1">{{ $account_number }}</p>
                    @else
                        <input type="text" wire:model="account_number" class="w-full border rounded px-3 py-2 mt-1">
                        @error('account_number')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <div class="flex justify-end space-x-2">
                    <button wire:click="$set('showModal', false)" class="px-4 py-2 bg-gray-300 rounded">Tutup</button>

                    @if (!$isDetail)
                        <button wire:click="save" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

</div>
