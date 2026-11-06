<x-app-layout>

    {{-- <x-slot name="header">

        
    </x-slot> --}}
    
    
    <div class="py-6">
        <div class="flex items-center justify-between mb-3">
    
            <div>
    
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                    Asset - {{ $outlet->name }}
                </h2>
    
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Assets located at this site
                </p>
    
            </div>
    
            <a
                href="{{ route('assets.create', $outlet) }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
            >
                + Add Asset
            </a>
    
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Success --}}
            @if (session('success'))

                <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Alert Error --}}
            @if (session('error'))

                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50">
                    {{ session('error') }}
                </div>

            @endif


            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">

                <div class="p-6">

                    {{-- Outlet Information --}}
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            <div>
                                <p class="text-xs text-gray-500">
                                    Site
                                </p>

                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $outlet->name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">
                                    Area
                                </p>

                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $outlet->area ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">
                                    Total Asset
                                </p>

                                <p class="font-semibold text-blue-600">
                                    {{ $outlet->assets()->count() }}
                                </p>
                            </div>

                        </div>

                    </div>

                    
                    {{-- <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-300">
                                    Outlet
                                </p>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $outlet->name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-300">
                                    Area
                                </p>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $outlet->area ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-300">
                                    Inventory Type
                                </p>
                                <p class="font-semibold text-blue-600">
                                    {{ $totalInventories }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-300">
                                    Asset Individual
                                </p>
                                <p class="font-semibold text-blue-600">
                                    {{ $totalIndividualAssets }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-300">
                                    Total Unit Bulk
                                </p>
                                <p class="font-semibold text-blue-600">
                                    {{ $totalBulkUnits }}
                                </p>
                            </div>
                        </div>
                    </div> --}}



                    {{-- Back --}}
                    <div class="grid grid-cols-2 items-center mb-4 ">
                        {{-- <div class=""> --}}
                            <a
                                href="{{ route('assets.index') }}"
                                class="text-sm text-blue-600 hover:underline"
                            >
                                ← Back to Site List
                            </a>

                        {{-- </div> --}}
                        <div class="flex justify-end items-center">
                            {{-- Filter Category --}}
                            <form action="{{ url()->current() }}" method="GET"
                                class="flex flex-col md:flex-row pr-3 gap-3">
                                <div class="col-span-2 sm:col-span-1">
    
                                    <select
                                        name="category_id"
                                        onchange="this.form.submit()"
                                        class="w-full md:w-40 rounded-lg  border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    >
                                        <option value="">All Category</option>
    
                                        @foreach ($categories as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                {{ request('category_id') == $category->id ? 'selected' : '' }}
                                            >
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>    
    
                            {{-- Search --}}
                            <form action="{{ route('assets.outlet', $outlet) }}" method="GET"
                            class="">
                            
                                <div class="flex flex-col justify-center sm:flex-row gap-2">
    
                                    {{-- Search --}}
                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="Search Asset Number, Serial Number, Device..."
                                        class="w-full sm:w-96 rounded-lg border-gray-300
                                            dark:border-gray-600 dark:bg-gray-700
                                            dark:text-white"
                                    >
    
    
                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg
                                            hover:bg-blue-700"
                                    >
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                                        </svg>
    
                                    </button>
    
                                    @if ($search)
                                        <a
                                            href="{{ route('assets.outlet', $outlet) }}"
                                            class="px-4 py-2 bg-gray-500 text-white rounded-lg
                                                hover:bg-gray-600 text-center"
                                        >
                                            Reset
                                        </a>
                                    @endif
                                </div>
                            </form>

                        </div>

                    </div>


                    {{-- Table --}}
                    <div class="overflow-x-auto">

                        <table class="w-full text-sm text-left text-gray-500">

                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">

                                <tr>

                                    <th class="px-6 py-3">
                                        No
                                    </th>

                                    <th class="px-6 py-3">
                                        Item Name
                                    </th>

                                    <th class="px-6 py-3">
                                        Merk
                                    </th>

                                    <th class="px-6 py-3">
                                        Type
                                    </th>

                                    <th class="px-6 py-3">
                                        Category
                                    </th>

                                    <th class="px-6 py-3">
                                        Serial Number
                                    </th>

                                    <th class="px-6 py-3">
                                        Asset Number
                                    </th>

                                    <th class="px-6 py-3 min-w-px">
                                        Status
                                    </th>

                                    <th class="px-6 py-3">
                                        Placement
                                    </th>

                                    <th class="px-6 py-3">
                                        Qty Image
                                    </th>

                                    <th class="px-6 py-3">
                                        Description
                                    </th>

                                    <th class="px-6 py-3 text-center">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($assets as $asset)

                                    <tr class="bg-white border-b hover:bg-gray-50">

                                        <td class="px-6 py-4">
                                            {{ $assets->firstItem() + $loop->index }}
                                        </td>


                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $asset->inventory?->device ?? '-' }}
                                        </td>


                                        <td class="px-6 py-4">
                                            {{ $asset->inventory?->brand ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $asset->inventory?->type ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $asset->inventory?->category?->name ?? '-' }}
                                        </td>


                                        <td class="px-6 py-4">
                                            {{ $asset->serial_number ?? '-' }}
                                        </td>


                                        <td class="px-6 py-4">
                                            {{ $asset->asset_number ?? '-' }}
                                        </td>


                                        <td class="px-6 py-4">

                                            @php
                                                $statusClass = match ($asset->status) {
                                                    'Available' => 'bg-green-100 text-green-800',
                                                    'In Use' => 'bg-blue-100 text-blue-800',
                                                    'Repair' => 'bg-yellow-100 text-yellow-800',
                                                    'Broken' => 'bg-red-100 text-red-800',
                                                    'Lost' => 'bg-gray-200 text-gray-800',
                                                    'Disposed' => 'bg-gray-300 text-gray-900',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span class="px-2.5 py-1 inline-block whitespace-nowrap text-xs font-medium rounded-full {{ $statusClass }}">
                                                {{ $asset->status }}
                                            </span>

                                        </td>


                                        <td class="px-6 py-4">
                                            {{ $asset->placement ?? '-' }}
                                        </td>

                                        
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center  px-2.5 py-1 text-xs font-medium text-blue-800  dark:text-blue-400">
                                                {{ $asset->images_count }} Images
                                            </span>
                                            
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            {{ $asset->description ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">

                                            <div class="flex items-center justify-center gap-2">

                                                <a
                                                    href="{{ route('assets.show', $asset) }}"
                                                    class="px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                                                >
                                                    Details
                                                </a>

                                                <a
                                                    href="{{ route('assets.edit', $asset) }}"
                                                    class="px-3 py-2 text-xs font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('assets.destroy', $asset) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this asset?')"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                                                    >
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="8"
                                            class="px-6 py-12 text-center"
                                        >

                                            <p class="text-lg font-medium text-gray-900">
                                                No assets found
                                            </p>

                                            <p class="text-sm text-gray-500 mt-1">
                                                Add an asset to this site.
                                            </p>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                            {{-- Modal Image --}}
                                
                        </table>
                        

                    </div>


                    
                    {{-- Inventory Table --}}
                    {{-- <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                            Inventory List
                        </h3>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700
                                            text-gray-700 dark:text-gray-200">
                                    <tr>
                                        <th class="px-4 py-3">No</th>
                                        <th class="px-4 py-3">Device</th>
                                        <th class="px-4 py-3">Category</th>
                                        <th class="px-4 py-3">Merk</th>
                                        <th class="px-4 py-3">Tipe</th>
                                        <th class="px-4 py-3">Quantity</th>
                                        <th class="px-4 py-3">Placement</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($inventories as $inventory)
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="px-4 py-3">
                                                {{ $loop->iteration }}
                                            </td>

                                            <td class="px-4 py-3 font-medium text-gray-900
                                                    dark:text-white">
                                                {{ $inventory->device }}
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $inventory->category?->name ?? '-' }}
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $inventory->brand ?? '-' }}
                                            </td>

                                            <td class="px-4 py-3">
                                                @if ($inventory->is_tracked)
                                                    <span class="px-2 py-1 text-xs rounded-full
                                                                bg-blue-100 text-blue-800">
                                                        Tracked
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full
                                                                bg-gray-100 text-gray-800">
                                                        Bulk
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $inventory->quantity }}
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ $inventory->placement ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-8 text-center">
                                                No inventory items found for this outlet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div> --}}



                   <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        {{-- Rows per page --}}
                        <form
                            method="GET"
                            action="{{ route('assets.outlet', $outlet->id) }}"
                            class="flex items-center gap-2"
                        >
                            {{-- Preserve existing filters --}}
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                            <input type="hidden" name="outlet_id" value="{{ request('outlet_id') }}">
                            <input type="hidden" name="entry_date" value="{{ request('entry_date') }}">

                            <label for="per_page" class="whitespace-nowrap text-sm text-gray-300 dark:text-gray-700">
                                Rows per page:
                            </label>

                            <select
                                id="per_page"
                                name="per_page"
                                onchange="this.form.submit()"
                                class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm
                                    text-gray-900 focus:border-blue-500 focus:ring-blue-500
                                    dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            >
                                @foreach ([10, 20, 50, 100] as $size)
                                    <option
                                        value="{{ $size }}"
                                        {{ (int) request('per_page', 10) === $size ? 'selected' : '' }}
                                    >
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>

                            <span class="whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                of {{ $assets->total() }} entries
                            </span>
                        </form>

                        {{-- Pagination --}}
                        <div>
                            {{ $assets->links() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    

</x-app-layout>

