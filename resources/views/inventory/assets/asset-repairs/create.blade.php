<x-app-layout>

    <x-slot name="header">
    </x-slot>
    
    <div class="py-6">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Start Asset Repair
        </h2>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

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

            {{-- Asset Information --}}
            <div class="mb-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Asset Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Device
                        </p>

                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $asset->inventory->device }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Merk
                        </p>

                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $asset->inventory->brand ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Serial Number
                        </p>

                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $asset->serial_number ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Asset Number
                        </p>

                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $asset->asset_number ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Outlet
                        </p>

                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $asset->outlet->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Current Status
                        </p>

                        <p class="font-medium text-red-600 dark:text-red-400">
                            {{ $asset->status }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- Repair Form --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">
                    Repair Information
                </h3>

                <form
                    method="POST"
                    action="{{ route('assets.repairs.store', $asset) }}"
                >

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Repair Date --}}
                        <div>
                            <label
                                for="repair_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Repair Date
                            </label>

                            <input
                                type="datetime-local"
                                id="repair_date"
                                name="repair_date"
                                value="{{ old('repair_date', now()->format('Y-m-d\TH:i')) }}"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                       dark:text-white"
                            >
                        </div>


                        {{-- Technician --}}
                        <div>
                            <label
                                for="technician"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Teknisi
                            </label>

                            <input
                                type="text"
                                id="technician"
                                name="technician"
                                value="{{ old('technician') }}"
                                placeholder="Nama teknisi"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                       dark:text-white"
                            >
                        </div>


                        {{-- Cost --}}
                        <div>
                            <label
                                for="cost"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Repair Cost
                            </label>

                            <input
                                type="number"
                                id="cost"
                                name="cost"
                                value="{{ old('cost', 0) }}"
                                min="0"
                                step="0.01"
                                placeholder="0"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                       dark:text-white"
                            >
                        </div>


                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <label
                                for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Damage / Repair Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                placeholder="Describe the damage or repair action..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                       dark:bg-gray-700 dark:border-gray-600
                                       dark:text-white"
                            >{{ old('description') }}</textarea>
                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 mt-6">

                        <a
                            href="{{ route('assets.show', $asset) }}"
                            class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300
                                   rounded-lg hover:bg-gray-100
                                   dark:bg-gray-700 dark:text-white dark:border-gray-600
                                   dark:hover:bg-gray-600"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg
                                   hover:bg-red-700 focus:ring-4 focus:ring-red-300
                                   dark:focus:ring-red-900"
                        >
                            Start Repair
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>