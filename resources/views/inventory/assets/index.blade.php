<x-app-layout>

    <x-slot name="header">
    </x-slot>
    
    <div class="py-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Asset
                </h2>
    
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Pilih outlet untuk melihat asset
                </p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

                @if ($outlets->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($outlets as $outlet)
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

                                    <a href="{{ route('assets.outlet', $outlet) }}"
                                       class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">

                                        Lihat Asset

                                        <svg class="w-4 h-4 ms-2"
                                             aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24">
                                            <path stroke="currentColor"
                                                  stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="m9 5 7 7-7 7"/>
                                        </svg>

                                    </a>

                                </div>

                            </div>

                        @endforeach

                    </div>

                    <div class="mt-6">
                        {{ $outlets->links() }}
                    </div>

                @else

                    <div class="text-center py-12">

                        <svg class="mx-auto w-12 h-12 text-gray-400"
                             xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24">

                            <path stroke="currentColor"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 6v12m6-6H6"/>

                        </svg>

                        <h3 class="mt-3 text-lg font-semibold text-gray-900 dark:text-white">
                            Belum ada outlet
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Belum tersedia outlet untuk menampilkan asset.
                        </p>

                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>