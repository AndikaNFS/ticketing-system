<x-app-layout>

    {{-- <x-slot name="header">

        
    </x-slot>
     --}}
    
    <div class="py-6">
        <div class="w-auto text-center mb-3">
    
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">
                Add Asset
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


                    {{-- Site --}}
                    <div class="mb-5">

                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                            Site
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
                                 Select Inventory 
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
                                No tracked inventory is available for this outlet.
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
                            Leave blank if the item does not have a serial number.
                        </p>

                        @error('serial_number')

                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Asset Number --}}
                    {{-- <div class="mb-5">

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

                    </div> --}}

                    {{-- Asset Number --}}
                        <div>
                            <label for="asset_number"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Asset Number
                            </label>

                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    id="asset_number"
                                    name="asset_number"
                                    value="{{ old('asset_number') }}"
                                    data-outlet-id="{{ $outlet->id }}"
                                    readonly
                                    placeholder="Click Generate to create asset number"
                                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg
                                        block w-full p-2.5 cursor-not-allowed
                                        dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                {{-- @if (!$asset->asset_number || auth()->user()->hasRole('superadmin')) --}}
                                <button
                                    type="button"
                                    id="generateAssetNumber"
                                    data-url="{{ route('assets.generate-asset-number-create') }}"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600
                                        rounded-lg hover:bg-blue-700 whitespace-nowrap"
                                        >
                                    Generate
                                </button>
                                {{-- @endif --}}
                            </div>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{-- The Asset Number is generated automatically based on Entry Date, Category ID, & Outlet. --}}
                            </p>

                            <p id="assetNumberMessage" class="mt-1 text-sm"></p>
                            

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
                                'Unavailable'
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
                            Entry Date
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
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                        >
                            Save Asset
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const generateButton = document.getElementById('generateAssetNumber');
    const assetNumberInput = document.getElementById('asset_number');
    const message = document.getElementById('assetNumberMessage');

    const inventoryInput = document.getElementById('inventory_id');
    const entryDateInput = document.getElementById('entry_date');

    if (!generateButton) {
        console.error('Generate button tidak ditemukan.');
        return;
    }

    async function generateAssetNumber() {
        const entryDate = entryDateInput.value;
        const inventoryId = inventoryInput.value;
        const outletId = @json($outlet->id);

        if (!entryDate || !inventoryId || !outletId) {
            message.textContent = 'Please select Inventory and ensure that the Entry Date is available.';
            message.className = 'mt-1 text-sm text-red-600';
            return;
        }

        generateButton.disabled = true;
        generateButton.textContent = 'Generating...';
        message.textContent = '';

        try {
            const response = await fetch(generateButton.dataset.url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({
                    entry_date: entryDate,
                    inventory_id: inventoryId,
                    outlet_id: outletId,
                }),
            });

            const data = await response.json();

            // Periksa response dari Controller
            if (!response.ok) {
                throw new Error(data.message || 'Failed to create Asset Number.');
            }

            // Masukkan hasil generate ke input
            assetNumberInput.value = data.asset_number;

            message.textContent = 'Asset Number successfully created: ' + data.asset_number;
            message.className = 'mt-1 text-sm text-green-600';

            @if (!auth()->user()->hasRole('superadmin'))
                generateButton.style.display = 'none';
            @else
                generateButton.disabled = false;
                generateButton.textContent = 'Generate';
            @endif

        } catch (error) {
            console.error('Generate Asset Number Error:', error);

            message.textContent = error.message;
            message.className = 'mt-1 text-sm text-red-600';

            generateButton.disabled = false;
            generateButton.textContent = 'Generate';
        }
    }

    // Otomatis generate ketika Inventory dipilih
    inventoryInput.addEventListener('change', function () {
        generateAssetNumber();
    });

    // Generate manual melalui tombol
    generateButton.addEventListener('click', function () {
        generateAssetNumber();
    });
});
</script>

</x-app-layout>