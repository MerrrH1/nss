<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trucks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
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

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Manajemen Truk</h3>
                        <a href="{{ route('trucks.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Truk Baru
                        </a>
                    </div>

                    {{-- Tabel Daftar Kontrak --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Nomor Polisi</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Nama Pengemudi</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($trucks as $truck)
                                    <tr>
                                        <td
                                            class="px-6 py-4 text-left whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                            <a href="{{ route('trucks.show', $truck) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">
                                                {{ $truck->plate_number }}
                                            </a>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-left break-words whitespace-normal text-sm text-gray-900 dark:text-gray-200">
                                            {{ $truck->driver_name }}</td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('trucks.show', $truck->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-3">Lihat</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Tidak ada truk yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginasi --}}
                    <div class="mt-4">
                        {{ $trucks->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
