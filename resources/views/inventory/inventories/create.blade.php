<x-app-layout>

    <x-slot name="header">

        
    </x-slot>
    
    <div class="py-6">
        <div class="">

        </div>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 mb-3">
            Add Device
        </h2>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <form action="{{ route('inventories.store') }}"
                          method="POST">

                        @csrf

                        {{-- Device --}}

                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium  text-gray-900 dark:text-gray-200">
                                Device
                            </label>

                            <input type="text"
                                   name="device"
                                   value="{{ old('device') }}"
                                   required
                                   class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                            @error('device')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Brand --}}

                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                Merk
                            </label>

                            <input type="text"
                                   name="brand"
                                   value="{{ old('brand') }}"
                                   class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                        </div>


                        {{-- Category --}}

                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                Category
                            </label>

                            <select name="category_id"
                                    required
                                    class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                                <option value="">
                                     Select Category 
                                </option>

                                @foreach ($categories as $category)

                                    <option value="{{ $category->id }}"
                                        @selected(old('category_id') == $category->id)>

                                        {{ $category->name }}

                                    </option>

                                @endforeach

                            </select>

                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Outlet --}}

                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                Outlet
                            </label>

                            <select name="outlet_id"
                                    required
                                    class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                                <option value="">
                                     Select Outlet 
                                </option>

                                @foreach ($outlets as $outlet)

                                    <option value="{{ $outlet->id }}"
                                        @selected(old('outlet_id') == $outlet->id)>

                                        {{ $outlet->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Source Outlet --}}

                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                Source Outlet
                            </label>

                            <select name="sources_outlet_id"
                                    class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                                <option value="">
                                     None / Unknown 
                                </option>

                                @foreach ($outlets as $outlet)

                                    <option value="{{ $outlet->id }}"
                                        @selected(old('sources_outlet_id') == $outlet->id)>

                                        {{ $outlet->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Tracked --}}

                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                Recorded as an Asset?
                            </label>

                            <div class="flex gap-6">

                                <label class="flex items-center gap-2">

                                    <input type="radio"
                                           name="is_tracked"
                                           value="1"
                                           {{ old('is_tracked', '1') == '1' ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                           {{-- onchange="toggleInventoryType()"> --}}

                                    <span class="ms-2 text-sm text-gray-900 dark:text-gray-300">Ya</span>

                                </label>

                                <label class="flex items-center gap-2">

                                    <input type="radio"
                                           name="is_tracked"
                                           value="0"
                                           {{ old('is_tracked') === '0' ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                           {{-- onchange="toggleInventoryType()"> --}}

                                    <span class="ms-2 text-sm text-gray-900 dark:text-gray-300">No</span>
                                </label>
                            </div>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                If Yes, each unit can be tracked as an individual asset.
                                Serial number is optional.
                            </p>

                            @error('is_tracked')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- Serialized Fields --}}

                        {{-- <div id="serialized-fields">

                            <div class="mb-5">

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                    Serial Number
                                </label>

                                <input type="text"
                                       name="serial_number"
                                       value="{{ old('serial_number') }}"
                                       class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                                @error('serial_number')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            <div class="mb-5">

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                    Asset Number
                                </label>

                                <input type="text"
                                       name="asset_number"
                                       value="{{ old('asset_number') }}"
                                       class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                            </div>


                            <div class="mb-5">

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                    Status
                                </label>

                                <select name="status"
                                        class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                                    @foreach ([
                                        'Available',
                                        'In Use',
                                        'Repair',
                                        'Broken',
                                        'Lost',
                                        'Disposed'
                                    ] as $status)

                                        <option value="{{ $status }}"
                                            @selected(old('status', 'Available') === $status)>
                                            {{ $status }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div> --}}


                        {{-- Quantity --}}
                        <div>
                            <label for="quantity"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200 text-gray-900 dark:text-white">
                                Quantity
                            </label>

                            <input
                                type="number"
                                name="quantity"
                                id="quantity"
                                min="1"
                                value="{{ old('quantity', 1) }}"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                    dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                If tracked as assets, this quantity becomes the target number of assets.
                            </p>

                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- <div id="quantity-field"
                             class="mb-5 hidden">

                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                Quantity
                            </label>

                            <input type="number"
                                   name="quantity"
                                   value="{{ old('quantity', 1) }}"
                                   min="1"
                                   class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                            @error('quantity')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div> --}}


                        {{-- Placement --}}

                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                Placement
                            </label>

                            <input type="text"
                                   name="placement"
                                   value="{{ old('placement') }}"
                                   placeholder="Example: Office"
                                   class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                        </div>


                        {{-- Entry Date --}}

                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                Entry Date
                            </label>

                            <input type="date"
                                   name="entry_date"
                                   value="{{ old('entry_date', now()->format('Y-m-d')) }}"
                                   required
                                   class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">

                        </div>


                        {{-- Description --}}

                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                Description
                            </label>

                            <textarea name="description"
                                      rows="4"
                                      class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">{{ old('description') }}</textarea>

                        </div>


                        <div class="flex justify-end gap-2">

                            <a href="{{ route('inventories.index') }}"
                               class="px-4 py-2 bg-gray-200 rounded-lg">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-4 py-2 text-white bg-blue-600 rounded-lg">
                                Save
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    {{-- <script>

        function toggleInventoryType()
        {
            const serialized =
                document.querySelector(
                    'input[name="is_tracked"]:checked'
                ).value === '1';

            const serializedFields =
                document.getElementById('serialized-fields');

            const quantityField =
                document.getElementById('quantity-field');

            if (serialized) {

                serializedFields.classList.remove('hidden');

                quantityField.classList.add('hidden');

            } else {

                serializedFields.classList.add('hidden');

                quantityField.classList.remove('hidden');

            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleInventoryType();
        });

    </script> --}}

</x-app-layout>