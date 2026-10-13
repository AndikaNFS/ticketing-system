<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    Transfer Asset
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Pindahkan Asset ke outlet lain
                </p>
            </div>

            <a href="{{ route('assets.show', $asset) }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Informasi Asset --}}
            <div class="mb-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg">

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Informasi Asset
                    </h3>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Device
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $asset->inventory->device }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Merk
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $asset->inventory->brand ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Category
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $asset->inventory->category->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Serial Number
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $asset->serial_number ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Asset Number
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $asset->asset_number ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Status
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $asset->status }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Outlet Asal
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $asset->outlet->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Area
                        </p>

                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $asset->outlet->area ?? '-' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Form Transfer --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Form Transfer
                    </h3>
                </div>

                <form action="{{ route('assets.asset-transfers.store', $asset) }}"
                      method="POST">

                    @csrf

                    <div class="p-6 space-y-6">

                        {{-- Outlet Asal --}}
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Outlet Asal
                            </label>

                            <input
                                type="text"
                                value="{{ $asset->outlet->name }}"
                                readonly
                                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            >
                        </div>

                        {{-- Outlet Tujuan --}}
                        <div>
                            <label for="to_outlet_id"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Outlet Tujuan
                            </label>

                            <select
                                id="to_outlet_id"
                                name="to_outlet_id"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                                <option value="">
                                    -- Pilih Outlet Tujuan --
                                </option>

                                @foreach ($outlets as $outlet)
                                    <option
                                        value="{{ $outlet->id }}"
                                        {{ old('to_outlet_id') == $outlet->id ? 'selected' : '' }}>

                                        {{ $outlet->name }} - {{ $outlet->area }}

                                    </option>
                                @endforeach

                            </select>

                            @error('to_outlet_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Tanggal Transfer --}}
                        <div>
                            <label for="transfer_date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tanggal dan Waktu Transfer
                            </label>

                            <input
                                type="datetime-local"
                                id="transfer_date"
                                name="transfer_date"
                                value="{{ old('transfer_date', now()->format('Y-m-d\TH:i')) }}"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >

                            @error('transfer_date')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Keterangan
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                placeholder="Contoh: Pemindahan PC karena kebutuhan operasional outlet."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-700">

                        <a href="{{ route('assets.show', $asset) }}"
                           class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                            Batal
                        </a>

                        <button
                            type="submit"
                            onclick="return confirm('Apakah kamu yakin ingin mentransfer Asset ini?')"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">

                            Transfer Asset

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>