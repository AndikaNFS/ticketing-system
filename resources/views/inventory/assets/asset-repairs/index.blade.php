<x-app-layout>

    <x-slot name="header">
    </x-slot>
    
    <div class="py-6">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-3">
            Repair History
        </h2>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success --}}
            @if (session('success'))
                <div class="mb-5 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error --}}
            @if (session('error'))
                <div class="mb-5 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif


            {{-- Filter --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 mb-6">

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Filter
                </h3>

                <form method="GET" action="{{ route('assets.repairs.index') }}">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        {{-- Outlet --}}
                        <div>
                            <label
                                for="outlet_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Outlet
                            </label>

                            <select
                                id="outlet_id"
                                name="outlet_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="">All Outlets</option>

                                @foreach ($outlets as $outlet)
                                    <option
                                        value="{{ $outlet->id }}"
                                        @selected(request('outlet_id') == $outlet->id)
                                    >
                                        {{ $outlet->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Status --}}
                        <div>
                            <label
                                for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="">All Statuses</option>

                                <option
                                    value="Repair"
                                    @selected(request('status') === 'Repair')
                                >
                                    Repair
                                </option>

                                <option
                                    value="Completed"
                                    @selected(request('status') === 'Completed')
                                >
                                    Completed
                                </option>
                            </select>
                        </div>


                        {{-- Start Date --}}
                        <div>
                            <label
                                for="start_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                From Date
                            </label>

                            <input
                                type="date"
                                id="start_date"
                                name="start_date"
                                value="{{ request('start_date') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                        </div>


                        {{-- End Date --}}
                        <div>
                            <label
                                for="end_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                To Date
                            </label>

                            <input
                                type="date"
                                id="end_date"
                                name="end_date"
                                value="{{ request('end_date') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                        </div>

                    </div>


                    <div class="flex gap-2 mt-5">

                        <button
                            type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg
                                   hover:bg-blue-700"
                        >
                            Filter
                        </button>

                        <a
                            href="{{ route('assets.repairs.index') }}"
                            class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300
                                   rounded-lg hover:bg-gray-100
                                   dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600"
                        >
                            Reset
                        </a>

                    </div>

                </form>

            </div>


            {{-- Table --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Repair Information
                    </h3>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300">

                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Asset</th>
                                <th class="px-6 py-3">SN</th>
                                <th class="px-6 py-3">Outlet</th>
                                <th class="px-6 py-3">Repair Date</th>
                                <th class="px-6 py-3">Durasi</th>
                                <th class="px-6 py-3">Cost</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($repairs as $repair)

                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                    {{-- No --}}
                                    <td class="px-6 py-4">
                                        {{ $repairs->firstItem() + $loop->index }}
                                    </td>


                                    {{-- Asset --}}
                                    <td class="px-6 py-4">

                                        @if ($repair->asset)
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ $repair->asset->asset_number ?? '-' }}
                                            </div>

                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $repair->asset->inventory->device ?? '-' }}
                                            </div>
                                        @else
                                            -
                                        @endif

                                    </td>


                                    {{-- SN --}}
                                    <td class="px-6 py-4">
                                        {{ $repair->asset->serial_number ?? '-' }}
                                    </td>


                                    {{-- Outlet --}}
                                    <td class="px-6 py-4">
                                        {{ $repair->outlet->name ?? '-' }}
                                    </td>


                                    {{-- Repair Date --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $repair->repair_date?->format('d-m-Y H:i') ?? '-' }}
                                    </td>


                                    {{-- Technician --}}
                                    <td class="px-6 py-4">
                                        {{ $repair->technician ?? '-' }}
                                    </td>


                                    {{-- Cost --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        Rp {{ number_format($repair->cost, 0, ',', '.') }}
                                    </td>


                                    {{-- Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        @if ($repair->completed_at && $repair->repair_date)

                                            @php
                                                $totalMinutes = $repair->repair_date->diffInMinutes($repair->completed_at);
                                                $days = intdiv($totalMinutes, 1440);
                                                $hours = intdiv($totalMinutes % 1440, 60);
                                                $minutes = $totalMinutes % 60;
                                            @endphp

                                            @if ($days > 0)
                                                {{ $days }} hari
                                            @endif

                                            @if ($hours > 0)
                                                {{ $hours }} jam
                                            @endif

                                            @if ($minutes > 0)
                                                {{ $minutes }} menit
                                            @endif

                                            @if ($days === 0 && $hours === 0 && $minutes === 0)
                                                < 1 menit
                                            @endif

                                        @else

                                            <span class="text-yellow-600 dark:text-yellow-400">
                                                In Progress
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td class="px-6 py-4">

                                        @if ($repair->asset)

                                            <a
                                                href="{{ route('assets.repairs.show', $repair) }}"
                                                class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                                            >
                                                Detailss
                                            </a>

                                        @else
                                            -
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="10"
                                        class="px-6 py-10 text-center text-gray-500 dark:text-gray-400"
                                    >
                                        No repair records found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if ($repairs->hasPages())

                    <div class="p-6">
                        {{ $repairs->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>