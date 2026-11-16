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

                    



                    {{-- Back --}}
                    <div class="grid grid-cols-2 items-center mb-4 ">
                        <div class=" w-auto ">
                            <a
                                href="{{ route('assets.index') }}"
                                class="text-sm text-blue-600 hover:underline"
                            >
                                ← Back to Site List
                            </a>

                        </div>
                        <div class="flex justify-end items-center">
                            <div class="flex justify-end mr-3">
                                <button type="button" id="printSelectedAssets" 
                                    class="px-1 py-1 w-28 text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 rounded-lg">
                                    Print Barcode
                                </button>
                            </div>
                            {{-- Export --}}
                            <div class="">
                                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white w-full sm:w-auto font-medium rounded-xl text-sm  py-2.5 text-center inline-flex items-center" type="button">
                                    <span class="text-md text-gray-200">Export</span>
                                </button>
                            </div>
                            <div class="">
                                <button
                                    type="button"
                                    onclick="document.getElementById('importPhotoModal').classList.remove('hidden')"
                                    class="px-4 py-2 text-sm font-medium text-white hover:text-blue-300 whitespace-nowrap">
                                    {{-- class="w-full rounded-b-md bg-indigo-700 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-800"> --}}
                                    
                                    <i class="fa-solid fa-images mr-1"></i>
                                    Import Foto
                                </button>

                            </div>

                            <!-- Dropdown menu Export-->
                            <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-s w-auto dark:bg-gray-700">
                                <ul class=" text-sm text-gray-700 dark:text-white" aria-labelledby="dropdownDefaultButton">
                                    {{-- <div class="w-full bg-gray-400 p-2 text-center rounded-t-md">
                                        <span class="p-2 text-sm text-gray-900 ">Export</span>
                                        
                                    </div> --}}
                                    
                                    {{-- <div class="w-full bg-gray-400 p-2 text-center">
                                        <span class="p-2 text-sm text-gray-900 ">Import</span>
                                        
                                    </div> --}}
                                    <li class="">
                                        <a href="{{ route('assets.outlet.export', array_merge(
                                            ['outlet' => $outlet->id],
                                            request()->only(['category_id', 'search'])
                                        ))}}" 
                                            class="block px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Excel</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('assets.outlet.export-pdf', array_merge(['outlet' => $outlet->id],
                                            request()->only(['category_id', 'source_outlet_id', 'search'])
                                            )) }}" 
                                            class="block px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">PDF</a>
                                    </li>
                                    <li>
                                    </li>
                                </ul>
                            </div>

                            {{-- Filter Category --}}
                            <form action="{{ url()->current() }}" method="GET"
                                class="flex flex-col md:flex-row pr-3 gap-3">
                                <div class="col-span-2 sm:col-span-1">
    
                                    <select
                                        name="category_id"
                                        onchange="this.form.submit()"
                                        class="w-full text-sm md:w-36 rounded-lg  border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
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
                            
                                <div class="flex flex-col justify-center sm:flex-row gap-2 text-sm">
    
                                    {{-- Search --}}
                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="Search Asset Number, Serial Number, Device..."
                                        class="w-full sm:w-72 text-sm rounded-lg border-gray-300
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

                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('import_failed'))
                        <div class="p-4 mb-4 border border-yellow-300 rounded-lg dark:border-yellow-600">
                            <h3 class="mb-3 font-semibold text-yellow-700 dark:text-yellow-400">
                                Detail Foto yang Gagal Diimport
                            </h3>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b dark:border-gray-600">
                                            <th class="px-3 py-2 text-left">Nama File</th>
                                            <th class="px-3 py-2 text-left">Alasan</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach (session('import_failed') as $item)
                                            <tr class="border-b dark:border-gray-600">
                                                <td class="px-3 py-2">{{ $item['file'] }}</td>
                                                <td class="px-3 py-2">{{ $item['reason'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    {{-- Table --}}
                    <div class="overflow-x-auto">

                        <table class="w-full text-sm text-left text-gray-500">

                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">

                                <tr>
                                    <th class="px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAllAssets" class="rounded border-gray-300">
                                    </th>
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
                                        <td class="px-4 py-4 text-center">
                                            <input type="checkbox" class="asset-checkbox rounded border-gray-300" value="{{ $asset->id }}">
                                        </td>
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
                                                    class=" text-xs font-medium rounded-lg hover:text-blue-700"
                                                >
                                                    <svg class="w-6 h-6 text-blue-800 dark:text-blue-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    </svg>
                                                </a>

                                                <a
                                                    href="{{ route('assets.edit', $asset) }}"
                                                    class=" text-xs font-medium text-white  rounded-lg hover:text-yellow-300"
                                                >
                                                    <svg class="w-6 h-6 text-yellow-800 dark:text-yellow-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                                                    </svg>
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
                                                        class=" text-xs font-medium  rounded-lg hover:text-red-700"
                                                    >
                                                        <svg class="w-6 h-6 text-red-800 dark:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                        </svg>
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
        {{-- Modal Import Foto --}}
        <div
            id="importPhotoModal"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
        >
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Import Foto Asset
                    </h3>

                    <button
                        type="button"
                        onclick="document.getElementById('importPhotoModal').classList.add('hidden')"
                        class=" text-gray-500 hover:text-gray-700"
                    >
                        &times;
                    </button>
                </div>

                <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">
                    Import foto fisik dan foto Serial Number untuk Asset
                    yang saat ini berada di {{ $outlet->name }}.
                </p>

                <form
                    action="{{ route('assets.images.import-zip', $outlet) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="mb-4">
                        <label
                            for="zip_file"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >
                            Pilih File ZIP
                        </label>

                        <input
                            type="file"
                            name="zip_file"
                            id="zip_file"
                            accept=".zip"
                            required
                            class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        >

                        {{-- <select name="image_type" class="rounded-lg border-gray-300 dark:bg-gray-700 dark:text-white">
                            <option value="physical">Foto Fisik Asset</option>
                            <option value="serial_number">Foto Serial Number</option>
                        </select> --}}

                        @error('zip_file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="p-3 mb-4 text-xs text-gray-600 bg-gray-100 rounded-lg dark:bg-gray-700 dark:text-gray-300">
                        <p class="font-semibold mb-2">Contoh nama file:</p>

                        <p>2611080305001.jpg</p>
                        <p>2611080305001_SN.jpg</p>
                        <p>2611080305002.jpg</p>
                        <p>2611080305002_SN.jpg</p>

                        <p class="mt-2">
                            Tanpa _SN = Foto fisik. Dengan _SN = Foto Serial Number.
                        </p>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button
                            type="button"
                            onclick="document.getElementById('importPhotoModal').classList.add('hidden')"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                        >
                            Import Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const selectAll = document.getElementById('selectAllAssets');
            const printButton = document.getElementById('printSelectedAssets');

            const getCheckboxes = () => {
                return document.querySelectorAll('.asset-checkbox');
            };

            // Select All
            selectAll?.addEventListener('change', function () {
                getCheckboxes().forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Print selected assets
            printButton?.addEventListener('click', function () {

                const selectedIds = Array.from(getCheckboxes())
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Please select at least one asset.');
                    return;
                }

                const params = new URLSearchParams();

                selectedIds.forEach(id => {
                    params.append('ids[]', id);
                });

                // Default label settings
                params.append('width', 50);
                params.append('height', 30);
                params.append('gap', 2);
                params.append('columns', 1);

                const url = "{{ route('assets.barcode.print') }}" +
                            '?' + params.toString();

                window.open(url, '_blank');
            });

        });
    </script>

</x-app-layout>

