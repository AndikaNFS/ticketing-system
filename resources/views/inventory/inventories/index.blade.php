<x-app-layout>

    
    <div class="py-6">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))

            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50">
                    {{ session('success') }}
                </div>

            @endif

            @if (session('error'))

                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50">
                    {{ session('error') }}
                </div>
                
            @endif
                <div class="flex items-center justify-between">

                <div class="mb-3">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                            Quantity List
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            IT Device and Asset Data
                        </p>
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
                                        Category
                                    </th>

                                    <th class="px-6 py-3">
                                        Outlet
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
                                        Action
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
                                                    Detail
                                                </a>

                                                <a href="{{ route('inventories.edit', $inventory) }}"
                                                   class="px-3 py-2 text-xs text-white bg-yellow-500 rounded-lg">
                                                    Edit
                                                </a>

                                                <form action="{{ route('inventories.destroy', $inventory) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin ingin menghapus inventory ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="px-3 py-2 text-xs text-white bg-red-600 rounded-lg">
                                                        Hapus
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="10"
                                            class="px-6 py-8 text-center">

                                            Belum ada data inventaris.

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