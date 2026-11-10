
<x-app-layout>
    <div class="p-4 sm:p-6">
    
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Asset Transfer Detail
                </h2>
    
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Transfer ID: #{{ $transfer->id }}
                </p>
            </div>
    
            <a href="{{ route('assets.transfers.index') }}"
                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm">
                Back to Transfer List
            </a>
    
        </div>
    
    
        {{-- Flash Message --}}
        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif
    
        @if (session('error'))
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700">
                {{ session('error') }}
            </div>
        @endif
    
    
        {{-- Transfer Information --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
            {{-- Transfer Information --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
    
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">
                    Transfer Information
                </h3>
    
                <div class="space-y-4">
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Transfer ID
                        </p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            #{{ $transfer->id }}
                        </p>
                    </div>
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Transfer Date
                        </p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $transfer->transfer_date
                                ? \Carbon\Carbon::parse($transfer->transfer_date)->format('d M Y')
                                : '-' }}
                        </p>
                    </div>
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Status
                        </p>
    
                        @if (strtolower($transfer->status) === 'completed')
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                {{ ucfirst($transfer->status) }}
                            </span>
                        @else
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                {{ ucfirst($transfer->status) }}
                            </span>
                        @endif
                    </div>
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Created By
                        </p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $transfer->creator?->name ?? '-' }}
                        </p>
                    </div>
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Created At
                        </p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $transfer->created_at?->format('d M Y H:i') ?? '-' }}
                        </p>
                    </div>
    
                </div>
    
            </div>
    
    
            {{-- Outlet Information --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
    
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">
                    Site Information
                </h3>
    
                <div class="space-y-5">
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                            Source Site
                        </p>
    
                        <div class="flex items-center gap-3">
    
                            <div class="p-3 rounded-lg bg-red-100 text-red-600">
                                <i class="fas fa-store"></i>
                            </div>
    
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $transfer->fromOutlet?->name ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Origin
                                </p>
                            </div>
    
                        </div>
                    </div>
    
    
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-5">
    
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                            Destination Site
                        </p>
    
                        <div class="flex items-center gap-3">
    
                            <div class="p-3 rounded-lg bg-green-100 text-green-600">
                                <i class="fas fa-store"></i>
                            </div>
    
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $transfer->toOutlet?->name ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Destination
                                </p>
                            </div>
    
                        </div>
    
                    </div>
    
                </div>
    
            </div>
    
        </div>
    
    
        {{-- Asset Information --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 mt-6">
    
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">
                Asset Information
            </h3>
    
            @if ($transfer->asset)
    
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Asset Number
                        </p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $transfer->asset->asset_number ?? '-' }}
                        </p>
                    </div>
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Serial Number
                        </p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $transfer->asset->serial_number ?? '-' }}
                        </p>
                    </div>
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Device
                        </p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $transfer->asset->inventory?->device ?? '-' }}
                        </p>
                    </div>
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Brand
                        </p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $transfer->asset->inventory?->brand ?? '-' }}
                        </p>
                    </div>
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Category
                        </p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $transfer->asset->inventory?->category?->name ?? '-' }}
                        </p>
                    </div>
    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Quantity Transferred
                        </p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $transfer->quantity }}
                        </p>
                    </div>
    
                </div>
    
            @else
    
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    This transfer does not have an individual asset record.
                </p>
    
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                    Device:
                    {{ $transfer->inventory?->device ?? '-' }}
                </p>
    
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Quantity:
                    {{ $transfer->quantity }}
                </p>
    
            @endif
    
        </div>
    
    
        {{-- Description --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 mt-6">
    
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                Description
            </h3>
    
            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                {{ $transfer->description ?: 'No description provided.' }}
            </p>
    
        </div>
    
        
        {{-- Asset Photo --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg mt-6">

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Asset Photo
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Total photos: {{ $transfer->images->count()}}
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
                <form action="{{ route('asset-transfers.images.store', $transfer) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <div class="mb-3">
                            <label class="block mb-2 text-gray-900 dark:text-gray-200">Jenis Foto</label>

                            <select name="image_type"
                                class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:text-white">
                                <option value="handover">Foto Serah Terima</option>
                                <option value="condition">Kondisi Asset</option>
                            </select>
                        </div>
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
                @if ($transfer->images->count())

                    <div
                        x-data="{
                            showModal: false,
                            selectedImage: ''
                        }"
                        @keydown.escape.window="showModal = false"
                    >

                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                            @foreach ($transfer->images as $image)

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
                                        
                                        <p class="text-sm text-gray-500 dark:text-gray-300 truncate">
                                            {{$image->image_type_label }}
                                        </p>

                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{-- Outlet: {{ $transfer->outlet->name ?? '-' }} --}}
                                            {{ $image->created_at?->format('d M Y H:i') }}
                                        </p>

                                        {{-- Delete Button --}}
                                        <form
                                            action="{{ route('asset-transfers.images.destroy', [$transfer, $image]) }}"
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

</x-app-layout>

{{-- @section('content') --}}


{{-- @endsection --}}
