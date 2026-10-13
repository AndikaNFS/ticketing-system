<x-app-layout>

    <x-slot name="header">
    </x-slot>
    
    <div class="py-6">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Inventory
        </h2>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="mb-5 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>
            @endif


            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

                <div class="mb-6">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Inventory
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ $inventory->device }}
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('inventories.update', $inventory) }}"
                >

                    @csrf
                    @method('PUT')


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Device --}}
                        <div>

                            <label
                                for="device"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Device
                            </label>

                            <input
                                type="text"
                                id="device"
                                name="device"
                                value="{{ old('device', $inventory->device) }}"
                                required
                                maxlength="150"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                        </div>


                        {{-- Brand --}}
                        <div>

                            <label
                                for="brand"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Merk
                            </label>

                            <input
                                type="text"
                                id="brand"
                                name="brand"
                                value="{{ old('brand', $inventory->brand) }}"
                                maxlength="100"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                        </div>


                        {{-- Category --}}
                        <div>

                            <label
                                for="category_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Category
                            </label>

                            <select
                                id="category_id"
                                name="category_id"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                                @foreach ($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        @selected(old('category_id', $inventory->category_id) == $category->id)
                                    >
                                        {{ $category->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Outlet --}}
                        <div>

                            <label
                                for="outlet_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Outlet
                            </label>

                            <select
                                id="outlet_id"
                                name="outlet_id"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                                @foreach ($outlets as $outlet)

                                    <option
                                        value="{{ $outlet->id }}"
                                        @selected(old('outlet_id', $inventory->outlet_id) == $outlet->id)
                                    >
                                        {{ $outlet->name }}
                                    </option>

                                @endforeach

                            </select>

                            @if ($inventory->assets->count() > 0)

                                <p class="mt-2 text-xs text-yellow-600 dark:text-yellow-400">
                                    Inventory ini sudah memiliki
                                    {{ $inventory->assets->count() }} Asset.
                                    Outlet tidak dapat dipindahkan dari Inventory.
                                    Gunakan Transfer Asset untuk memindahkan Asset.
                                </p>

                            @endif

                        </div>


                        {{-- Source Outlet --}}
                        <div>

                            <label
                                for="source_outlet_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Asal Barang
                            </label>

                            <select
                                id="source_outlet_id"
                                name="source_outlet_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                                <option value="">
                                     Tidak Ada 
                                </option>

                                @foreach ($outlets as $outlet)

                                    <option
                                        value="{{ $outlet->id }}"
                                        @selected(old('source_outlet_id', $inventory->source_outlet_id) == $outlet->id)
                                    >
                                        {{ $outlet->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Quantity --}}
                        <div>

                            <label
                                for="quantity"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Quantity
                            </label>

                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                value="{{ old('quantity', $inventory->quantity) }}"
                                min="{{ max(1, $inventory->assets->count()) }}"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                            @if ($inventory->assets->count() > 0)

                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Asset saat ini:
                                    {{ $inventory->assets->count() }}
                                    / {{ $inventory->quantity }}
                                </p>

                            @endif

                        </div>


                        {{-- Tracking --}}
                        <div>

                            <label
                                for="is_tracked"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Dicatat sebagai Asset?
                            </label>

                            <select
                                id="is_tracked"
                                name="is_tracked"
                                required
                                @disabled($inventory->assets->count() > 0)
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       disabled:opacity-60 disabled:cursor-not-allowed
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                                <option
                                    value="1"
                                    @selected(old('is_tracked', $inventory->is_tracked) == 1)
                                >
                                    Ya - Tracked
                                </option>

                                <option
                                    value="0"
                                    @selected(old('is_tracked', $inventory->is_tracked) == 0)
                                >
                                    Tidak - Bulk
                                </option>

                            </select>

                            {{-- Penting: disabled select tidak dikirim browser --}}
                            @if ($inventory->assets->count() > 0)
                                <input
                                    type="hidden"
                                    name="is_tracked"
                                    value="{{ $inventory->is_tracked ? 1 : 0 }}"
                                >
                            @endif

                        </div>


                        {{-- Placement --}}
                        <div>

                            <label
                                for="placement"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Placement
                            </label>

                            <input
                                type="text"
                                id="placement"
                                name="placement"
                                value="{{ old('placement', $inventory->placement) }}"
                                maxlength="150"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                        </div>


                        {{-- Entry Date --}}
                        <div>

                            <label
                                for="entry_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Tanggal Masuk
                            </label>

                            <input
                                type="date"
                                id="entry_date"
                                name="entry_date"
                                value="{{ old('entry_date', $inventory->entry_date?->format('Y-m-d')) }}"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                        </div>


                        {{-- Description --}}
                        <div class="md:col-span-2">

                            <label
                                for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >{{ old('description', $inventory->description) }}</textarea>

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 mt-6">

                        <a
                            href="{{ route('inventories.show', $inventory) }}"
                            class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300
                                   rounded-lg hover:bg-gray-100
                                   dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                        >
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>