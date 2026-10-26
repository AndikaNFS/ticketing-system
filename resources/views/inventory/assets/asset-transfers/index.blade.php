
<x-app-layout>

    <x-slot name="header">
    </x-slot>
    
    <div class="py-6">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    Asset Transfer History
                </h2>
    
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Asset transfers between outlets
                </p>
            </div>
    
            <a href="{{ route('assets.index') }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                ← Back to Assets
            </a>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filter --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Filter History
                    </h3>
                </div>

                <form action="{{ route('assets.transfers.index') }}" method="GET">

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                        {{-- Source Outlet --}}
                        <div>
                            <label for="from_outlet_id"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Source Outlet
                            </label>

                            <select
                                name="from_outlet_id"
                                id="from_outlet_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                                <option value="">All Outlets</option>

                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}"
                                        {{ request('from_outlet_id') == $outlet->id ? 'selected' : '' }}>
                                        {{ $outlet->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- Destination Outlet --}}
                        <div>
                            <label for="to_outlet_id"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Destination Outlet
                            </label>

                            <select
                                name="to_outlet_id"
                                id="to_outlet_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                                <option value="">All Outlets</option>

                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}"
                                        {{ request('to_outlet_id') == $outlet->id ? 'selected' : '' }}>
                                        {{ $outlet->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- Tanggal Awal --}}
                        <div>
                            <label for="start_date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                From Date
                            </label>

                            <input
                                type="date"
                                name="start_date"
                                id="start_date"
                                value="{{ request('start_date') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        {{-- Tanggal Akhir --}}
                        <div>
                            <label for="end_date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                To Date
                            </label>

                            <input
                                type="date"
                                name="end_date"
                                id="end_date"
                                value="{{ request('end_date') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                    </div>

                    <div class="flex justify-end gap-2 px-6 pb-6">

                        <a href="{{ route('assets.transfers.index') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                            Reset
                        </a>

                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Filter
                        </button>

                    </div>

                </form>
            </div>

            {{-- Transfer Table --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Transfer History
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Total records on this page: {{ $transfers->count() }}
                    </p>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">

                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Asset</th>
                                <th class="px-6 py-3">Serial Number</th>
                                <th class="px-6 py-3">Source Outlet</th>
                                <th class="px-6 py-3">Destination Outlet</th>
                                <th class="px-6 py-3">Transfer Date</th>
                                <th class="px-6 py-3">Description</th>
                                <th class="px-6 py-3">Created at</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($transfers as $transfer)

                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">

                                    {{-- No --}}
                                    <td class="px-6 py-4">
                                        {{ $transfers->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Asset --}}
                                    <td class="px-6 py-4">

                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ $transfer->asset?->inventory?->device ?? '-' }}
                                        </p>

                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $transfer->asset?->inventory?->brand ?? '-' }}
                                        </p>

                                        {{-- @if ($transfer->asset)
                                            <span class="text-xs text-gray-500">
                                                Asset ID: {{ $transfer->asset->id }}
                                            </span>
                                        @endif --}}

                                    </td>

                                    {{-- Serial Number --}}
                                    <td class="px-6 py-4">
                                        {{ $transfer->asset?->serial_number ?? '-' }}
                                    </td>

                                    {{-- Source Outlet --}}
                                    <td class="px-6 py-4">
                                        {{ $transfer->fromOutlet?->name ?? '-' }}
                                    </td>

                                    {{-- Destination Outlet --}}
                                    <td class="px-6 py-4">
                                        {{ $transfer->toOutlet?->name ?? '-' }}
                                    </td>

                                    {{-- Transfer Date --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $transfer->transfer_date?->format('d-m-Y H:i') ?? '-' }}
                                    </td>

                                    {{-- Description --}}
                                    <td class="px-6 py-4">
                                        <span title="{{ $transfer->description }}">
                                            {{ \Illuminate\Support\Str::limit($transfer->description ?? '-', 40) }}
                                        </span>
                                    </td>

                                    {{-- Creator --}}
                                    <td class="px-6 py-4">
                                        {{ $transfer->creator?->name ?? '-' }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">

                                        @if ($transfer->asset)
                                            <a href="{{ route('assets.show', $transfer->asset) }}"
                                               class="font-medium text-blue-600 hover:underline dark:text-blue-400">
                                                Asset Details
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">

                                        <div class="flex flex-col items-center gap-2">

                                            <p class="font-medium text-gray-900 dark:text-white">
                                                No Transfer History Yet
                                            </p>

                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Asset transfer records will appear here.
                                            </p>

                                        </div>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}
                @if ($transfers->hasPages())
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $transfers->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>

</x-app-layout>