
<x-app-layout>
    <div class="py-2">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Asset
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Select an outlet to view its assets
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notification --}}
            @if (session('success'))
                <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                {{-- Filter Outlet & Search Asset --}}
                <form action="{{ route('assets.index') }}" method="GET" class="mb-6">
                    <div class="flex flex-col md:flex-row gap-3">
    
                        {{-- Outlet Dropdown --}}
                        <select
                            name="outlet_id"
                            onchange="this.form.submit()"
                            class="w-full md:w-64 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="">All Site</option>
    
                            @foreach ($outlets as $outlet)
                                <option
                                    value="{{ $outlet->id }}"
                                    {{ (string) $outletId === (string) $outlet->id ? 'selected' : '' }}
                                >
                                    {{ $outlet->name }}
                                </option>
                            @endforeach
                        </select>
    
                        {{-- Search Asset --}}
                        <input
                            type="text"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Serial Number / Asset Number..."
                            class="w-full md:w-80 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
    
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        >
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                                </svg>
    
                        </button>
    
                        {{-- Reset Filter --}}
                        <a
                            href="{{ route('assets.index') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-center"
                        >
                            Reset
                        </a>
    
                    </div>
                </form>

                {{-- ========================================= --}}
                {{-- SEARCH RESULT --}}
                {{-- ========================================= --}}
                @if (filled($search))

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Search Results
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Keyword: "{{ $search }}"
                            @if ($selectedOutlet)
                                | Outlet: {{ $selectedOutlet->name }}
                            @endif
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                            <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Asset Number</th>
                                    <th class="px-4 py-3">Serial Number</th>
                                    <th class="px-4 py-3">Device</th>
                                    <th class="px-4 py-3">Outlet</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Description</th>
                                    <th class="px-4 py-3">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($assets as $asset)
                                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">

                                        <td class="px-4 py-3">
                                            {{ $assets->firstItem() + $loop->index }}
                                        </td>

                                        <td class="px-4 py-3 whitespace-nowrap">
                                            {{ $asset->asset_number ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3 whitespace-nowrap">
                                            {{ $asset->serial_number ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $asset->inventory->device ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $asset->outlet->name ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3 whitespace-nowrap">
                                            {{ $asset->status }}
                                        </td>

                                        <td class="px-4 py-3 whitespace-nowrap">
                                            {{ $asset->description ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <a
                                                href="{{ route('assets.show', $asset->id) }}"
                                                class="text-blue-600 hover:underline dark:text-blue-400"
                                            >
                                                Detail
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center">
                                            Asset tidak ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{-- Pagination Search --}}
                    <div class="mt-4">
                        {{ $assets->links() }}
                    </div>

                {{-- ========================================= --}}
                {{-- OUTLET LIST --}}
                {{-- ========================================= --}}
                @else

                    @if ($displayOutlets->count())

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                            @foreach ($displayOutlets as $outlet)

                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-5 hover:shadow-md transition">

                                    <div class="flex items-start justify-between">

                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $outlet->name }}
                                            </h3>

                                            @if ($outlet->area)
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $outlet->area }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="text-right">
                                            <span class="text-2xl font-bold text-blue-600">
                                                {{ $outlet->assets_count }}
                                            </span>

                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Asset
                                            </p>
                                        </div>

                                    </div>

                                    <div class="mt-5">
                                        @php
                                            $isWarehouse = in_array($outlet->id, [22, 23, 24]);
                                        @endphp

                                        <a
                                            href="{{ $isWarehouse
                                                ? route('assets.warehouse', $outlet)
                                                : route('assets.outlet', $outlet) }}"
                                            class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300"
                                        >
                                            Check Asset

                                            <svg
                                                class="w-4 h-4 ms-2"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke="currentColor"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="m9 5 7 7-7 7"
                                                />
                                            </svg>
                                        </a>
                                        {{-- <a
                                            href="{{ route('assets.outlet', $outlet) }}"
                                            class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300"
                                        >
                                            Check Asset

                                            <svg
                                                class="w-4 h-4 ms-2"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke="currentColor"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="m9 5 7 7-7 7"
                                                />
                                            </svg>
                                        </a> --}}
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="text-center py-12">
                            <svg
                                class="mx-auto w-12 h-12 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 6v12m6-6H6"
                                />
                            </svg>

                            <h3 class="mt-3 text-lg font-semibold text-gray-900 dark:text-white">
                                No outlets found
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                No outlets are available to display assets.
                            </p>
                        </div>

                    @endif

                @endif

            </div>
        </div>
    </div>
</x-app-layout>
