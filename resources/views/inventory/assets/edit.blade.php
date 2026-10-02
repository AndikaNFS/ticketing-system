<x-app-layout>

    <x-slot name="header">
    </x-slot>
    
    <div class="py-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    Edit Asset
                </h2>
    
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Ubah informasi asset
                </p>
            </div>
    
            <a href="{{ route('assets.show', $asset) }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                ← Kembali
            </a>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Error Validation --}}
            @if ($errors->any())
                <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                     role="alert">

                    <div class="font-medium mb-2">
                        Terdapat kesalahan pada input:
                    </div>

                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif


            {{-- Asset Information --}}
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:border-blue-800">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Device --}}
                    <div>
                        <p class="text-xs text-blue-600 dark:text-blue-400">
                            Device
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-gray-900">
                            {{ $asset->inventory->device }}
                        </p>
                    </div>

                    {{-- Brand --}}
                    <div>
                        <p class="text-xs text-blue-600 dark:text-blue-400">
                            Merk
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-gray-900">
                            {{ $asset->inventory->brand ?? '-' }}
                        </p>
                    </div>

                    {{-- Category --}}
                    <div>
                        <p class="text-xs text-blue-600 dark:text-blue-400">
                            Category
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-gray-900">
                            {{ $asset->inventory->category->name ?? '-' }}
                        </p>
                    </div>

                    {{-- Outlet --}}
                    <div>
                        <p class="text-xs text-blue-600 dark:text-blue-400">
                            Outlet
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-gray-900">
                            {{ $asset->outlet->name ?? '-' }}
                        </p>
                    </div>

                    {{-- Area --}}
                    <div>
                        <p class="text-xs text-blue-600 dark:text-blue-400">
                            Area
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-gray-900">
                            {{ $asset->outlet->area ?? '-' }}
                        </p>
                    </div>

                    {{-- Inventory Quantity --}}
                    <div>
                        <p class="text-xs text-blue-600 dark:text-blue-400">
                            Quantity Inventory
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-gray-900">
                            {{ $asset->inventory->quantity }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- Form --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Informasi Asset
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Serial Number dan Asset Number bersifat opsional.
                    </p>

                </div>


                <form action="{{ route('assets.update', $asset) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-6">

                        {{-- Serial Number --}}
                        <div>
                            <label for="serial_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Serial Number
                            </label>

                            <input
                                type="text"
                                id="serial_number"
                                name="serial_number"
                                value="{{ old('serial_number', $asset->serial_number) }}"
                                placeholder="Masukkan Serial Number jika ada"
                                maxlength="150"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Kosongkan jika asset tidak memiliki Serial Number.
                            </p>

                            @error('serial_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Asset Number --}}
                        <div>
                            <label for="asset_number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Asset Number
                            </label>

                            <input
                                type="text"
                                id="asset_number"
                                name="asset_number"
                                value="{{ old('asset_number', $asset->asset_number) }}"
                                placeholder="Masukkan Asset Number jika ada"
                                maxlength="150"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Kosongkan jika asset belum memiliki nomor asset.
                            </p>

                            @error('asset_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Status --}}
                        <div>
                            <label for="status"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >

                                <option value="">
                                     Pilih Status 
                                </option>

                                <option value="Available"
                                    {{ old('status', $asset->status) === 'Available' ? 'selected' : '' }}>
                                    Available
                                </option>

                                <option value="In Use"
                                    {{ old('status', $asset->status) === 'In Use' ? 'selected' : '' }}>
                                    In Use
                                </option>

                                <option value="Repair"
                                    {{ old('status', $asset->status) === 'Repair' ? 'selected' : '' }}>
                                    Repair
                                </option>

                                <option value="Broken"
                                    {{ old('status', $asset->status) === 'Broken' ? 'selected' : '' }}>
                                    Broken
                                </option>

                                <option value="Lost"
                                    {{ old('status', $asset->status) === 'Lost' ? 'selected' : '' }}>
                                    Lost
                                </option>

                                <option value="Disposed"
                                    {{ old('status', $asset->status) === 'Disposed' ? 'selected' : '' }}>
                                    Disposed
                                </option>

                            </select>

                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Placement --}}
                        <div>
                            <label for="placement"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Placement
                            </label>

                            <input
                                type="text"
                                id="placement"
                                name="placement"
                                value="{{ old('placement', $asset->placement) }}"
                                placeholder="Contoh: Kasir, Ruang IT, Gudang"
                                maxlength="150"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >

                            @error('placement')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Entry Date --}}
                        <div>
                            <label for="entry_date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tanggal Masuk
                            </label>

                            <input
                                type="date"
                                id="entry_date"
                                name="entry_date"
                                value="{{ old('entry_date', $asset->entry_date?->format('Y-m-d')) }}"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >

                            @error('entry_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-700">

                        <a href="{{ route('assets.show', $asset) }}"
                           class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>