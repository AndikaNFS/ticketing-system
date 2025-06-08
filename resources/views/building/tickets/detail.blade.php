<x-app-layout>
    <div class=" mt-5">
        <a href="{{ route('building.tickets.index') }}" class="text-white bg-gray-500 py-1 px-5 text-lg m-10 rounded dark:bg-gray-400 dark:text-gray-700">Back</a>

        </div>

    <h1 class="text-gray-800 dark:text-gray-100 text-3xl m-5 max-w-md mx-auto text-center">Details Ticketing</h1>
    
@foreach ($ticket as $detail)
<div class="max-w-xl mx-auto ">

    <div class="mb-6">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ticketing ID</label>
        <p class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $detail->ticketing }}</p>
    </div> 
    {{-- <div class="flex justify-between"> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="flex flex-col">
                <label for="problem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Problem</label>
                <p class="tracking-tight text-gray-500 md:text-lg dark:text-gray-400">{{ $detail->problem }}</p>
            </div>
            
            <div class="flex flex-col">
                <label for="outlet" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Outlet</label>
                <p class="tracking-tight text-gray-500 md:text-lg dark:text-gray-400">{{ $detail->outlet->name }}</p>
            </div>
        
            <div class="flex flex-col">
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <p class="tracking-tight text-gray-500 md:text-lg dark:text-gray-400">{{ $detail->status }}</p>
            </div>
        
            <div class="flex flex-col">
                <label for="it_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PIC</label>
                <p class="tracking-tight text-gray-500 md:text-lg dark:text-gray-400">{{ $detail->pic->name }}</p>
            </div>
            <div class="flex flex-col">
                <label for="it_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor</label>
                <p class="tracking-tight text-gray-500 md:text-lg dark:text-gray-400">{{ $detail->vendor->name }}</p>
            </div>
        
            <div class="flex flex-col">
                <div class="">
                    <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                    <p class="tracking-tight text-gray-500 md:text-lg dark:text-gray-400">
                        @if (!empty($detail->start_date))
                            {{ $detail->start_date }}
                        @else
                            <span class="text-gray-400 italic">Belum ada data</span>
                        @endif
                            
                    </p>

                </div>
            </div>
            <div class="flex flex-col">
                <label for="date_finish" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date Finish</label>
                <p class="tracking-tight text-gray-500 md:text-lg dark:text-gray-400">
                    @if (!@empty($detail->date_finish))
                        {{ $detail->date_finish }}
                    @else
                        <span class="text-gray-400 italic">Belum ada data</span>
                    @endif
                </p>
            </div>
        
        </div>
        
    {{-- </div> --}}
    <div class="mb-5">
        
        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
        <p id="description" name="description" rows="4" class="block p-2.5 w-full text-lg text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @if (!@empty($detail->description))
                        {{ $detail->description }}
                    @else
                        <span class="text-gray-400 italic">Belum ada deskripsi</span>
                    @endif
        </p>

    </div>
    
    <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media</label>

    <div x-data="{ open: false, media: '', isVideo: false }">
        <div class="grid grid-cols-3 gap-4">
            @if($detail->image_buildings?->count())
            @foreach ($detail->image_buildings as $media)
                <div class="relative cursor-pointer mb-8"
                     @click="open = true;
                             media = '{{ asset('storage/' . $media->path) }}';
                             isVideo = '{{ pathinfo($media->path, PATHINFO_EXTENSION) }}' === 'mp4'">

                     
                    @if (pathinfo($media->path, PATHINFO_EXTENSION) === 'mp4')
                        <video class="w-full h-32 object-cover rounded" muted loop>
                            <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $media->path) }}" alt="" class="w-full h-32 object-cover rounded" />
                    @endif
                </div>
            @endforeach
            @endif
        </div>
    
        {{-- Modal --}}
        <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50">
            <div class="relative">
                <template x-if="isVideo">
                    <video controls autoplay class="max-h-[90vh] rounded shadow-lg">
                        <source :src="media" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </template>
                <template x-if="!isVideo">
                    <img :src="media" class="max-h-[90vh] rounded shadow-lg">
                </template>
    
                <button @click="open = false" class="absolute top-2 right-2 text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

    
@endforeach

</x-app-layout>