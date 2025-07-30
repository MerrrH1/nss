<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-, $truck->xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Truk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-medium mb-6">Edit Truk:
                    </h3>
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

                    <form method="POST" action="{{ route('trucks.update', $truck->id) }}">
                        @csrf
                        @method('PUT') {{-- Use PUT method for update operations --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="plate_number"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Polisi</label>
                                <input type="text" name="plate_number" id="plate_number"
                                    value="{{ old('plate_number', $truck->plate_number) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('plate_number') border-red-500 @enderror">
                                @error('plate_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="driver_name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pengemudi</label>
                                <input type="text" name="driver_name" id="driver_name"
                                    value="{{ old('driver_name', $truck->driver_name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('driver_name') border-red-500 @enderror">
                                @error('driver_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="notes"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                                <input type="text" name="notes" id="notes"
                                    value="{{ old('notes', $truck->notes) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 @error('notes') border-red-500 @enderror">
                                @error('notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-, $truck->xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Perbarui Kontrak
                            </button>
                            <a href="{{ route('trucks.show', $truck->id) }}"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-, $truck->xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
