<x-app-layout>

    <div class="py-6">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- @if (session('success'))

            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50">
                    {{ session('success') }}
                </div>

            @endif

            @if (session('error'))

                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50">
                    {{ session('error') }}
                </div>
                
            @endif

                        
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-4 rounded-lg bg-yellow-100 p-4 text-yellow-800">
                    {{ session('warning') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}

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
                        <table class="w-full text-left text-sm text-gray-700 dark:text-gray-300">
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
                        <a href="{{ route('inventories.export') }}"
                        class="rounded-lg bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-green-800">
                            Export to Excel
                        </a>

                        <a href="{{ route('inventories.download-template') }}"
                        class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">
                            Download Template
                        </a>

                        <form action="{{ route('inventories.import') }}"
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
                                Import from Excel
                            </button>
                        </form>
                    </div>


                    <a href="{{ route('inventories.create') }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        + Add Device
                    </a>

                </div>

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
                                        Device
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
                                        Source Outlet
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
                                    <th class="px-6 py-3">
                                        Placement
                                    </th>
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
                                        <td class="px-6 py-4">
                                            {{ $inventory->placement ?? '-' }}
                                        </td>
                                        {{-- Entry Date --}}
                                        <td class="px-6 py-4">
                                            {{ $inventory->entry_date?->format('d-m-Y') ?? '-' }}
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
                                                <form action="{{ route('inventories.destroy', $inventory) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this inventory item?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-3 py-2 text-xs text-white bg-red-600 rounded-lg">
                                                        Delete
                                                    </button>
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
                    @if ($inventories->hasPages())
                        <div class="mt-4">
                            {{ $inventories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>