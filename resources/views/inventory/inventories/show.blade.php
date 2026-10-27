<x-app-layout>

    <x-slot name="header">
    </x-slot>
    
    <div class="py-6">
        <h2 class="font-semibold text-xl mb-3 text-gray-800 dark:text-gray-200 leading-tight">
            Inventory Details
        </h2>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-5 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif


            {{-- Inventory Information --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg mb-6">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $inventory->device }}
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ $inventory->brand ?? '-' }}
                            </p>
                        </div>

                        <div class="flex gap-2">

                            <a
                                href="{{ route('inventories.edit', $inventory) }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                            >
                                Edit
                            </a>

                            <a
                                href="{{ route('inventories.index') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600"
                            >
                                Back
                            </a>

                        </div>

                    </div>

                </div>


                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Device
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $inventory->device }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Merk
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $inventory->brand ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Type
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $inventory->type ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Category
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $inventory->category->name ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                               Outlet
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $inventory->outlet->name ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Source Outlet
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $inventory->sourceOutlet->name ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Quantity
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $inventory->quantity }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Tracking
                            </p>

                            <p class="mt-1">

                                @if ($inventory->is_tracked)

                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        Tracked
                                    </span>

                                @else

                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        Bulk
                                    </span>

                                @endif

                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Asset
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $inventory->assets->count() }}
                                / {{ $inventory->quantity }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Placement
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $inventory->placement ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Entry Date
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $inventory->entry_date?->format('Y-m-d') ?? '-' }}
                            </p>
                        </div>

                    </div>


                    <div class="mt-6">

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Description
                        </p>

                        <div class="mt-2 p-4 rounded-lg bg-gray-50 dark:bg-gray-700">

                            <p class="text-gray-900 dark:text-gray-200 whitespace-pre-line">
                                {{ $inventory->description ?? '-' }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Asset List --}}
            @if ($inventory->is_tracked)

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">

                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Assets in This Inventory
                        </h3>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                            <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300">

                                <tr>
                                    <th class="px-6 py-3">No</th>
                                    <th class="px-6 py-3">Asset Number</th>
                                    <th class="px-6 py-3">Serial Number</th>
                                    <th class="px-6 py-3">Outlet</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Placement</th>
                                    <th class="px-6 py-3">Actions</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse ($inventory->assets as $asset)

                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                        <td class="px-6 py-4">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $asset->asset_number ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $asset->serial_number ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $asset->outlet->name ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $asset->status }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $asset->placement ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">

                                            <a
                                                href="{{ route('assets.show', $asset) }}"
                                                class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                                            >
                                                Details
                                            </a>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td
                                            colspan="7"
                                            class="px-6 py-8 text-center text-gray-500 dark:text-gray-400"
                                        >
                                            No assets found.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            @endif

        </div>
    </div>

</x-app-layout>