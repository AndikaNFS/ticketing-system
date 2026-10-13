<x-app-layout>

    <x-slot name="header">
    </x-slot>
    
    <div class="py-6">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Perbaikan
        </h2>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success --}}
            @if (session('success'))
                <div class="mb-5 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-5 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Header --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg mb-6">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>

                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $repair->asset->inventory->device ?? '-' }}
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $repair->asset->inventory->brand ?? '-' }}
                            </p>

                        </div>


                        <div>

                            @if ($repair->status === 'Repair')

                                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                    Repair
                                </span>

                            @elseif ($repair->status === 'Completed')

                                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    Completed
                                </span>

                            @else

                                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    {{ $repair->status }}
                                </span>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- Asset Information --}}
                <div class="p-6">

                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">
                        Informasi Asset
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Device
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->asset->inventory->device ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Merk
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->asset->inventory->brand ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Category
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->asset->inventory->category->name ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Serial Number
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->asset->serial_number ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Asset Number
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->asset->asset_number ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Outlet
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->outlet->name ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Placement
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->asset->placement ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Status Asset Saat Ini
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->asset->status }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Repair Information --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg mb-6">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Informasi Perbaikan
                    </h3>

                </div>


                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Tanggal Mulai
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->repair_date?->format('d-m-Y H:i') ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Tanggal Selesai
                            </p>

                            
                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->completed_at?->format('d-m-Y H:i') ?? '-' }}
                            </p>

                        </div>
                        <div class="">
                            @if ($repair->completed_at && $repair->repair_date)
                                @php
                                    $totalMinutes = $repair->repair_date->diffInMinutes($repair->completed_at);
                                    $days = intdiv($totalMinutes, 1440);
                                    $hours = intdiv($totalMinutes % 1440, 60);
                                    $minutes = $totalMinutes % 60;
                                @endphp
    
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Lama Perbaikan
                                        </p>
    
                                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
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
                                                Kurang dari 1 menit
                                            @endif
                                        </p>
                                    </div>
    
                            @endif

                        </div>
                        


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Teknisi
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->technician ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Biaya
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                Rp {{ number_format($repair->cost, 0, ',', '.') }}
                            </p>
                        </div>


                        <div class="md:col-span-2">

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Keterangan
                            </p>

                            <div class="mt-2 p-4 rounded-lg bg-gray-50 dark:bg-gray-700">

                                <p class="text-gray-900 dark:text-gray-200 whitespace-pre-line">
                                    {{ $repair->description ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Complete Repair --}}
            @if ($repair->status === 'Repair')

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg mb-6">

                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Selesaikan Perbaikan
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Tentukan tanggal selesai dan status Asset setelah perbaikan.
                        </p>

                    </div>


                    <div class="p-6">

                        <form
                            method="POST"
                            action="{{ route('assets.repairs.complete', $repair) }}"
                        >

                            @csrf
                            @method('PUT')


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- Completed At --}}
                                <div>

                                    <label
                                        for="completed_at"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >
                                        Tanggal Selesai
                                    </label>

                                    <input
                                        type="datetime-local"
                                        id="completed_at"
                                        name="completed_at"
                                        value="{{ old('completed_at', now()->format('Y-m-d\TH:i')) }}"
                                        required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                               dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    >

                                </div>


                                {{-- Asset Status --}}
                                <div>

                                    <label
                                        for="asset_status"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >
                                        Status Asset Setelah Perbaikan
                                    </label>

                                    <select
                                        id="asset_status"
                                        name="asset_status"
                                        required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                               dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    >

                                        <option value="">
                                            -- Pilih Status --
                                        </option>

                                        <option
                                            value="Available"
                                            @selected(old('asset_status') === 'Available')
                                        >
                                            Available
                                        </option>

                                        <option
                                            value="In Use"
                                            @selected(old('asset_status') === 'In Use')
                                        >
                                            In Use
                                        </option>

                                        <option
                                            value="Broken"
                                            @selected(old('asset_status') === 'Broken')
                                        >
                                            Broken
                                        </option>

                                    </select>

                                </div>

                            </div>


                            <div class="flex justify-end mt-6">

                                <button
                                    type="submit"
                                    onclick="return confirm('Yakin perbaikan ini sudah selesai?')"
                                    class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg
                                           hover:bg-green-700 focus:ring-4 focus:ring-green-300"
                                >
                                    Selesaikan Perbaikan
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            @endif


            {{-- Navigation --}}
            <div class="flex justify-between">

                <a
                    href="{{ route('assets.repairs.index') }}"
                    class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300
                           rounded-lg hover:bg-gray-100
                           dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600"
                >
                    ← Riwayat Perbaikan
                </a>


                <a
                    href="{{ route('assets.show', $repair->asset) }}"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg
                           hover:bg-blue-700"
                >
                    Detail Asset
                </a>

            </div>

        </div>
    </div>

</x-app-layout>