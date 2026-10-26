<x-app-layout>

    <x-slot name="header">
    </x-slot>
    
    <div class="py-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    Asset Detailsss
                </h2>
    
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Complete asset information
                </p>
            </div>
    
            <a href="{{ route('assets.outlet', $asset->outlet_id) }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                ← Back
            </a>
        </div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Asset Information --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $asset->inventory->device }}
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $asset->inventory->brand ?? '-' }}
                            </p>
                        </div>

                        {{-- @if ($asset->status !== 'Repair') --}}
                        @if (!in_array($asset->status, ['Repair', 'Lost', 'Disposed']))
                            <a
                                href="{{ route('assets.repairs.create', $asset) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white
                                    bg-red-600 rounded-lg hover:bg-red-700"
                            >
                                Start Repair
                            </a>
                        @endif
                        @if (!in_array($asset->status, ['Repair', 'Lost', 'Disposed']))
                            <a href="{{ route('assets.asset-transfers.create', $asset) }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                                Transfer Asset
                            </a>
                        @endif
                        <a href="{{ route('assets.edit', $asset) }}"
                           class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Edit Asset
                        </a>

                    </div>
                </div>

                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Device --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Device
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->inventory->device }}
                            </p>
                        </div>

                        {{-- Brand --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Merk
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->inventory->brand ?? '-' }}
                            </p>
                        </div>

                        {{-- Type --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Type
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->inventory->type ?? '-' }}
                            </p>
                        </div>

                        {{-- Category --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Category
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->inventory->category->name ?? '-' }}
                            </p>
                        </div>

                        {{-- Serial Number --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Serial Number
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->serial_number ?? '-' }}
                            </p>
                        </div>

                        {{-- Asset Number --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Asset Number
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->asset_number ?? '-' }}
                            </p>
                        </div>

                        {{-- Status --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Status
                            </p>

                            @php
                                $statusClass = match ($asset->status) {
                                    'Available' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'In Use' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'Repair' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    'Broken' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    'Lost' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
                                    'Disposed' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                };
                            @endphp

                            <span class="inline-flex mt-1 px-2.5 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                {{ $asset->status }}
                            </span>
                        </div>

                        {{-- Outlet --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Outlet
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->outlet->name ?? '-' }}
                            </p>
                        </div>

                        {{-- Area --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Area
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->outlet->area ?? '-' }}
                            </p>
                        </div>

                        {{-- Placement --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Placement
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->placement ?? '-' }}
                            </p>
                        </div>

                        {{-- Entry Date --}}
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Entry Date
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->entry_date?->format('d-m-Y') ?? '-' }}
                            </p>
                        </div>

                    </div>

                </div>
            </div>


            {{-- Inventory Information --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Inventory Induk
                    </h3>
                </div>

                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

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
                                Quantity Inventory
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->inventory->quantity }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Source Outlet
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $asset->inventory->sourceOutlet->name ?? '-' }}
                            </p>
                        </div>

                    </div>

                </div>
            </div>


            {{-- Asset Photo --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Asset Photo
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Total photos: {{ $asset->images->count()}}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400">
                            {{ session('success')}}
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if (session('error'))
                        <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-700 dark:text-red-400">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error}}</li>
                                @endforeach
                            </ul>
                            {{ session('error')}}
                        </div>
                    @endif
                    
                    {{-- Upload Form --}}
                    <form action="{{ route('assets.images.store', $asset) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="images"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Upload Photos
                            </label>

                            <input
                                type="file"
                                id="images"
                                name="images[]"
                                accept=".jpg,.jpeg,.png,.webp"
                                multiple
                                required
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600"
                            >

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                JPG, JPEG, PNG, or WEBP. Maximum 5 MB per photo.
                                You can select multiple photos at once.
                                Include a photo of the asset serial number, if available.
                            </p>
                        </div>
                        @error('images')
                            <p class="text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                        <button
                            type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">

                            Upload Photos
                        </button>
                    </form>
                    <hr class="border-gray-200 dark:border-gray-700">
                    
                    {{-- Gallery --}}
                    @if ($asset->images->count())

                        <div
                            x-data="{
                                showModal: false,
                                selectedImage: ''
                            }"
                            @keydown.escape.window="showModal = false"
                        >

                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                                @foreach ($asset->images as $image)

                                    <div class="relative group border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">

                                        {{-- Image --}}
                                        <button
                                            type="button"
                                            @click="
                                                selectedImage = '{{ asset('storage/' . $image->image_path) }}';
                                                showModal = true;
                                            "
                                            class="block w-full cursor-pointer"
                                        >
                                            <img
                                                src="{{ asset('storage/' . $image->image_path) }}"
                                                alt="Asset Photo"
                                                class="w-full h-40 object-cover hover:opacity-80 transition"
                                            >
                                        </button>

                                        {{-- Image Information --}}
                                        <div class="p-3 bg-gray-50 dark:bg-gray-700">

                                            <p class="text-xs text-gray-500 dark:text-gray-300 truncate">
                                                {{ basename($image->path) }}
                                            </p>

                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                Outlet: {{ $image->outlet->name ?? '-' }}
                                            </p>

                                            {{-- Delete Button --}}
                                            <form
                                                action="{{ route('assets.images.destroy', [$asset, $image]) }}"
                                                method="POST"
                                                class="mt-3"
                                                onsubmit="return confirm('Are you sure you want to delete this photo?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="w-full px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                                                >
                                                    Delete Photo
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                                @endforeach

                            </div>


                            {{-- Image Modal --}}
                            <div
                                x-show="showModal"
                                x-transition.opacity
                                x-cloak
                                @click.self="showModal = false"
                                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80"
                            >

                                <div class="relative max-w-5xl w-full flex items-center justify-center">

                                    {{-- Close Button --}}
                                    <button
                                        type="button"
                                        @click="showModal = false"
                                        class="absolute -top-10 right-0 text-white hover:text-gray-300"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-8 h-8"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />

                                        </svg>
                                    </button>

                                    {{-- Full Image --}}
                                    <img
                                        :src="selectedImage"
                                        alt="Preview Asset Photo"
                                        @click.stop
                                        class="max-h-[85vh] max-w-full object-contain rounded-lg shadow-xl"
                                    >

                                </div>

                            </div>

                        </div>

                    @else


                        <div class="text-center py-8">

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                No photos available for this asset.
                            </p>

                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>

</x-app-layout>