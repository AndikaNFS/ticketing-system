<x-app-layout>

    <x-slot name="header">

        
    </x-slot>
    
    
    <div class="py-6">
        <div>
    
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Tambah Asset
            </h2>
    
            <p class="text-sm text-gray-500 mt-1">
                {{ $outlet->name }}
            </p>
        </div>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('error'))

                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50">
                    {{ session('error') }}
                </div>

            @endif


            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

                <form
                    method="POST"
                    action="{{ route('assets.store', $outlet) }}"
                >

                    @csrf


                    {{-- Outlet --}}
                    <div class="mb-5">

                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                            Outlet
                        </label>

                        <input
                            type="text"
                            value="{{ $outlet->name }}"
                            disabled
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        >

                    </div>


                    {{-- Inventory --}}
                    <div class="mb-5">

                        <label
                            for="inventory_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200"
                        >
                            Inventory
                        </label>

                        <select
                            name="inventory_id"
                            id="inventory_id"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        >

                            <option value="">
                                 Pilih Inventory 
                            </option>

                            @foreach ($inventories as $inventory)

                                @php
                                    // $assetCount = $inventory->assets()->count();
                                    // $remaining = $inventory->quantity - $assetCount;
                                @endphp

                                <option
                                    value="{{ $inventory->id }}"
                                    {{ old('inventory_id') == $inventory->id ? 'selected' : '' }}
                                    {{ $inventory->assets_count >= $inventory->quantity ? 'disabled' : '' }}
                                >
                                    {{ $inventory->device }}
                                    {{ $inventory->brand ? ' - ' . $inventory->brand : '' }}
                                    | Asset {{ $inventory->assets_count }}/{{ $inventory->quantity }}
                                </option>

                            @endforeach

                        </select>

                        @if ($inventories->isEmpty())

                            <p class="mt-2 text-sm text-red-600">
                                Tidak ada Inventory Tracked yang tersedia untuk outlet ini.
                            </p>

                        @endif

                        @error('inventory_id')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Serial Number --}}
                    <div class="mb-5">

                        <label
                            for="serial_number"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200"
                        >
                            Serial Number
                        </label>

                        <input
                            type="text"
                            name="serial_number"
                            id="serial_number"
                            value="{{ old('serial_number') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        >

                        <p class="mt-1 text-xs text-gray-500">
                            Kosongkan jika barang tidak memiliki Serial Number.
                        </p>

                        @error('serial_number')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Asset Number --}}
                    <div class="mb-5">

                        <label
                            for="asset_number"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200"
                        >
                            Asset Number
                        </label>

                        <input
                            type="text"
                            name="asset_number"
                            id="asset_number"
                            value="{{ old('asset_number') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        >

                        <p class="mt-1 text-xs text-gray-500">
                            Optional. Bisa digunakan sebagai kode Asset internal.
                        </p>

                        @error('asset_number')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Status --}}
                    <div class="mb-5">

                        <label
                            for="status"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200"
                        >
                            Status
                        </label>

                        <select
                            name="status"
                            id="status"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        >

                            @foreach ([
                                'Available',
                                'In Use',
                                'Repair',
                                'Broken',
                                'Lost',
                                'Disposed'
                            ] as $status)

                                <option
                                    value="{{ $status }}"
                                    {{ old('status', 'Available') === $status ? 'selected' : '' }}
                                >
                                    {{ $status }}
                                </option>

                            @endforeach

                        </select>

                        @error('status')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Placement --}}
                    <div class="mb-5">

                        <label
                            for="placement"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200"
                        >
                            Placement
                        </label>

                        <input
                            type="text"
                            name="placement"
                            id="placement"
                            value="{{ old('placement') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        >

                        @error('placement')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Entry Date --}}
                    <div class="mb-5">

                        <label
                            for="entry_date"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200"
                        >
                            Tanggal Masuk
                        </label>

                        <input
                            type="date"
                            name="entry_date"
                            id="entry_date"
                            value="{{ old('entry_date', now()->format('Y-m-d')) }}"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        >

                        @error('entry_date')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3">

                        <a
                            href="{{ route('assets.outlet', $outlet) }}"
                            class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                        >
                            Simpan Asset
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>