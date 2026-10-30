<x-app-layout>

    <div class="py-1">
        
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-2">


            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->has('file'))
                <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800">
                    @foreach ($errors->get('file') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
            {{-- @if (session('import_failures'))
                <div class="mt-4 overflow-hidden rounded-lg border border-red-300 dark:border-red-700">
                    <div class="bg-red-50 px-4 py-3 dark:bg-red-900/30">
                        <h3 class="font-semibold text-red-800 dark:text-red-300">
                            Import Error Detailsss
                        </h3>

                        <p class="mt-1 text-sm text-red-700 dark:text-red-300">
                            Check the following Excel rows and columns, then correct your file.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-300 dark:text-gray-700">
                            <thead class="bg-gray-100 text-xs uppercase dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3">Excel Row</th>
                                    <th class="px-4 py-3">Column</th>
                                    <th class="px-4 py-3">Value</th>
                                    <th class="px-4 py-3">Description</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach (session('import_failures') as $failure)
                                    @foreach ($failure['errors'] as $error)
                                        <tr class="border-t dark:border-gray-700">
                                            <td class="px-4 py-3">
                                                {{ $failure['row'] }}
                                            </td>

                                            <td class="px-4 py-3 font-medium">
                                                {{ $failure['column'] }}
                                            </td>

                                            <td class="px-4 py-3">
                                                {{ filled($failure['value'])
                                                    ? $failure['value']
                                                    : '(kosong)' }}
                                            </td>

                                            <td class="px-4 py-3 text-red-600 dark:text-red-400">
                                                {{ $error }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif --}}

                <div class="flex items-center justify-between">
                    <div class="mb-3 ">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                            Quantity List
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            IT Inventory and Asset Data
                        </p>
                    </div>


                    
                    <div class="flex flex-wrap gap-2">
                        {{-- <a href="{{ route('inventories.export') }}"
                        class="rounded-lg bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-green-800">
                            Export to Excel
                        </a>

                        <a href="{{ route('inventories.download-template') }}"
                        class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">
                            Download Template
                        </a> --}}

                        {{-- <form action="{{ route('inventories.import') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="flex flex-wrap items-center gap-2">
                            @csrf

                            <input type="file"
                                name="file"
                                accept=".xlsx,.xls,.csv"
                                required
                                class="block max-w-xs text-sm text-gray-900 dark:text-gray-200">

                            <button type="submit"
                                    class="rounded-lg bg-indigo-700 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-800">
                                Submit
                            </button>
                        </form> --}}
                    </div>

                    <div class="flex">
                        {{-- Export --}}
                        <div class="">
                            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white w-full sm:w-auto font-medium rounded-xl text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                                <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Filter -->
                        <div class="">
                            <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white w-full sm:w-auto font-medium rounded-full text-sm px-5 py-2.5 text-center" type="button">
                                <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z"/>
                                </svg>  
                            </button>
                        </div>

                        <div class="">
                            {{-- Create Item --}}
                            <a href="{{ route('inventories.create') }}" class="block text-white w-full ml-3 sm:w-auto bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-2.5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                </svg>
                            </a>
                        </div>

                    </div>

                    <!-- Dropdown menu Export-->
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-s w-80 dark:bg-gray-700">
                        <ul class=" text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                            <div class="w-full bg-gray-400 p-2 text-center rounded-t-md">
                                <span class="p-2 text-sm text-gray-900 dark:text-gray-200">Export</span>

                            </div>
                            <li class="">
                                <a href="{{ route('inventories.export')}}" 
                                    class="block px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Excel</a>
                            </li>
                            <li class="">
                                <a href="{{ route('inventories.download-template')}}" class="block px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Download Template</a>
                            </li>

                            <div class="w-full bg-gray-400 p-2 text-center">
                                <span class="p-2 text-sm text-gray-900 dark:text-gray-200">Import</span>

                            </div>
                            <li>
                                <form action="{{ route('inventories.import') }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                    class="flex flex-wrap items-center gap-2">
                                    @csrf

                                    <input type="file"name="file" accept=".xlsx,.xls,.csv" required
                                        class="block py-2 max-w-xs text-sm text-gray-900 dark:text-gray-200">
                                    <button type="submit"
                                            class="w-full rounded-b-md bg-indigo-700 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-800">
                                        Submit
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    


                    {{-- <a href="{{ route('inventories.create') }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        + Add Item
                    </a> --}}

                    

                    <!-- Main modal -->
                    <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative bg-gray-700 p-4 w-full rounded-xl max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative   border border-default rounded-xl border-gray-500 shadow-sm p-4 md:p-6">
                                <!-- Modal header -->
                                <div class="flex items-center text-gray-200 dark:text-gray-200 justify-between pb-4 md:pb-5">
                                    <h3 class="text-lg font-medium text-heading">
                                        Search & Filter Quantity List
                                    </h3>
                                    <button type="button" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="crud-modal">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form action="{{ route('inventories.index') }}" method="GET>
                                    <div class="grid gap-4 grid-cols-2 py-4 md:py-6">
                                        <div class="col-span-2 mb-3">
                                            <label for="search"
                                                class="mb-2 block text-sm font-medium text-gray-300 dark:text-gray-200">
                                                Search
                                            </label>

                                            <input
                                                type="text" name="search" id="search"
                                                value="{{ request('search') }}"
                                                placeholder="Item, brand, category, site..."
                                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                            >

                                        </div>
                                        <div class="col-span-2 mb-3 sm:col-span-1">
                                            <label for="category_id"
                                                class="mb-2 block text-sm font-medium text-gray-300 dark:text-gray-200">
                                                Category
                                            </label>

                                            <select
                                                name="category_id"
                                                id="category_id"
                                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                            >
                                                <option value="">All Categories</option>

                                                @foreach ($categories as $category)
                                                    <option
                                                        value="{{ $category->id }}"
                                                        @selected((string) request('category_id') === (string) $category->id)
                                                    >
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-2 mb-3 sm:col-span-1">
                                               <label for="outlet_id"
                                                    class="mb-2 block text-sm font-medium text-gray-300 dark:text-gray-200">
                                                    Site
                                                </label>

                                                <select
                                                    name="outlet_id"
                                                    id="outlet_id"
                                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                                >
                                                    <option value="">All Sites</option>

                                                    @foreach ($outlets as $outlet)
                                                        <option
                                                            value="{{ $outlet->id }}"
                                                            @selected((string) request('outlet_id') === (string) $outlet->id)
                                                        >
                                                            {{ $outlet->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="col-span-2">
                                            <label for="entry_date"
                                                class="mb-2 block text-sm font-medium text-gray-300 dark:text-gray-200">
                                                Entry Date
                                            </label>

                                            <input
                                                type="date"
                                                name="entry_date"
                                                id="entry_date"
                                                value="{{ request('entry_date') }}"
                                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                            >
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 pt-4 md:pt-6">
                                        <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                                            {{-- <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg> --}}
                                            Submit
                                        </button>
                                       <a
                                            href="{{ route('inventories.index') }}"
                                            class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-200 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
                                        >
                                            Reset
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 


                </div>

                {{-- Search and Filter --}}
                {{-- <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                    <form action="{{ route('inventories.index') }}" method="GET">

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

                            Search
                            <div>
                                <label for="search"
                                    class="mb-2 block text-sm font-medium text-gray-300 dark:text-gray-200">
                                    Search
                                </label>

                                <input
                                    type="text"
                                    name="search"
                                    id="search"
                                    value="{{ request('search') }}"
                                    placeholder="Item, brand, category, outlet..."
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                >
                            </div>

                            Category
                            <div>
                                <label for="category_id"
                                    class="mb-2 block text-sm font-medium text-gray-300 dark:text-gray-700">
                                    Category
                                </label>

                                <select
                                    name="category_id"
                                    id="category_id"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                >
                                    <option value="">All Categories</option>

                                    @foreach ($categories as $category)
                                        <option
                                            value="{{ $category->id }}"
                                            @selected((string) request('category_id') === (string) $category->id)
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            Outlet
                            <div>
                                <label for="outlet_id"
                                    class="mb-2 block text-sm font-medium text-gray-300 dark:text-gray-700">
                                    Site
                                </label>

                                <select
                                    name="outlet_id"
                                    id="outlet_id"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                >
                                    <option value="">All Sites</option>

                                    @foreach ($outlets as $outlet)
                                        <option
                                            value="{{ $outlet->id }}"
                                            @selected((string) request('outlet_id') === (string) $outlet->id)
                                        >
                                            {{ $outlet->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            Date From
                            <div>
                                <label for="entry_date"
                                    class="mb-2 block text-sm font-medium text-gray-300 dark:text-gray-700">
                                    Entry Date
                                </label>

                                <input
                                    type="date"
                                    name="entry_date"
                                    id="entry_date"
                                    value="{{ request('entry_date') }}"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                >
                            </div>

                        </div>

                        Buttons
                        <div class="mt-4 flex flex-wrap gap-2">

                            <button
                                type="submit"
                                class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300"
                            >
                                Search / Filter
                            </button>

                            <a
                                href="{{ route('inventories.index') }}"
                                class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
                            >
                                Reset
                            </a>

                        </div>

                    </form>

                    

                </div> --}}

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
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
                                        Site
                                    </th>
                                    {{-- <th class="px-6 py-3">
                                        SN
                                    </th> --}}
                                    <th class="px-6 py-3">
                                        Qty
                                    </th>
                                    <th class="px-6 py-3">
                                        Tracking
                                    </th>
                                    {{-- <th class="px-6 py-3">
                                        Placement
                                    </th> --}}
                                    <th class="px-6 py-3">
                                        Entry Date
                                    </th>
                                    <th class="px-6 py-3">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inventories as $inventory)
                                    <tr class="bg-white border-b">
                                        {{-- NO --}}
                                        <td class="px-6 py-4">
                                            {{ $inventories->firstItem() + $loop->index }}
                                        </td>
                                        {{-- Device --}}
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $inventory->device }}
                                        </td>
                                        {{-- Brand --}}
                                        <td class="px-6 py-4">
                                            {{ $inventory->brand ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 ">
                                            {{ $inventory->type }}
                                        </td>
                                        {{-- Category --}}
                                        <td class="px-6 py-4">
                                            {{ $inventory->category?->name ?? '-' }}
                                        </td>
                                        {{-- Outlet --}}
                                        <td class="px-6 py-4">
                                            {{ $inventory->outlet?->name ?? '-' }}
                                        </td>
                                        {{-- Quantity --}}
                                        <td class="px-6 py-4">
                                            <span class="font-medium">
                                                {{ $inventory->quantity }}
                                            </span>
                                            @if ($inventory->is_tracked)
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $inventory->assets_count}} / {{ $inventory->quantity }} Asset
                                                </div>
                                            @endif
                                        </td>

                                        {{-- <td class="px-6 py-4">
                                            {{ $inventory->quantity }}

                                            @if ($inventory->is_tracked)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $inventory->assets_count ?? $inventory->assets->count() }}
                                                / {{ $inventory->quantity }} Asset
                                            </div>
                                            @endif
                                        </td> --}}

                                        {{-- Tracking --}}
                                        <td class="px-6 py-4">
                                            @if ($inventory->is_tracked)
                                                <span class="px-2.5 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                                    Tracked
                                                </span>
                                                {{-- {{ $inventory->assets->first()?->status ?? '-' }} --}}
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">
                                                    Bulk
                                                </span>
                                            @endif
                                        </td>
                                        {{-- Placement --}}
                                        {{-- <td class="px-6 py-4">
                                            {{ $inventory->placement ?? '-' }}
                                        </td> --}}
                                        {{-- Entry Date --}}
                                        <td class="px-6 py-4">
                                            {{ $inventory->entry_date?->format('Y-m-d') ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-2">
                                                <a href="{{ route('inventories.show', $inventory) }}"
                                                   class="px-3 py-2 text-xs text-white bg-blue-600 rounded-lg">
                                                    Details
                                                </a>
                                                <a href="{{ route('inventories.edit', $inventory) }}"
                                                   class="px-3 py-2 text-xs text-white bg-yellow-500 rounded-lg">
                                                    Edit
                                                </a>
                                                {{-- <form action="{{ route('inventories.destroy', $inventory) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this inventory item?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-3 py-2 text-xs text-white bg-red-600 rounded-lg">
                                                        Delete
                                                    </button> --}}
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10"
                                            class="px-6 py-8 text-center">

                                            No inventory data available.

                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination --}}
                    {{-- @if ($inventories->hasPages())
                        <div class="mt-4">
                            {{ $inventories->links() }}
                        </div>
                    @endif --}}
                    {{-- Bottom Table Controls --}}
                    <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        {{-- Rows per page --}}
                        <form
                            method="GET"
                            action="{{ route('inventories.index') }}"
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
                                of {{ $inventories->total() }} entries
                            </span>
                        </form>

                        {{-- Pagination --}}
                        <div>
                            {{ $inventories->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>