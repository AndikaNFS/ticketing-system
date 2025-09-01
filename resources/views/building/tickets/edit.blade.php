<x-app-layout>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li class="text-red-500">{{ $error }}</li>
        @endforeach
    </ul>
@endif

        <div class=" mt-5">
            <a href="{{ route('building.tickets.index') }}" class="text-white bg-gray-500 py-1 px-5 text-lg m-10 rounded dark:bg-gray-400 dark:text-gray-700">Back</a>
    
            </div>



        
<form action="{{ isset($building) ? route('building.tickets.update', $building->id) : route('building.tickets.store') }}" method="post" enctype="multipart/form-data" class="max-w-md mx-auto mt-10">
    
    @csrf
    @method('PUT')

    <div class="flex space-x-5 mb-5 text-gray-900 dark:text-white">
        <p class="text-l ">Created At : </p>
        <span class="font-sans">{{ $building->user }}</span>
    </div>
    <div class="mb-6">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ticketing ID</label>
        <input value="{{ $building->ticketing }}" type="text" name="ticketing" id="ticketing" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " disabled />
        <input type="text" value="{{ $building->ticketing }}" name="ticketing" id="ticketing" hidden>
    </div> 
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Problem</label>
            <input value="{{ $building->problem }}" type="text" name="problem" id="problem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required />
        </div>
        <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor</label>
            {{-- <input value="{{ $building->vendors->name }}" type="text" name="vendor_id" id="vendor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
            <select id="vendor_id" name="vendor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="">Pilih Vendor</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id}}"  {{ $building->vendor_id == $vendor->id ? 'selected' : ''}}>{{ $vendor->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="outlet_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Outlet</label>
            <select id="outlet_id" name="outlet_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option disabled selected >Pilih Lokasi</option>
                    @if ($specialOutlet)
                        <option value="{{ $specialOutlet->id}}">{{ $specialOutlet->name }}</option>
                    @endif

                    @foreach ($outlets as $outlet)
                        @if (!$specialOutlet || $outlet->id != $specialOutlet->id) 
                            <option value="{{ $outlet->id }}" {{ $building->outlet_id == $outlet->id ? 'selected' : ''}}>{{ $outlet->name }}</option>
                        @endif
                    @endforeach
                </select>
        </div>
        <div>
            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
            <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        onchange="this.form.submit()"
                        >
                            <option value="Open" {{ old('status', $building->status) == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="InProgress" {{ old('status', $building->status) == 'InProgress' ? 'selected' : '' }}>InProgress</option>
                            <option value="Done" {{ old('status', $building->status) == 'Done' ? 'selected' : '' }}>Done</option>
                            <option value="Cancel" {{ old('status', $building->status) == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                        </select>
        </div>  
        <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PIC</label>
            <select id="pic_id" name="pic_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected >Pilih PIC</option>
                @foreach ($pics as $pic)
                    <option value="{{ $pic->id}}"  {{ $building->pic_id == $pic->id ? 'selected' : ''}}>{{ $pic->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            
            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
            {{-- <input type="url" id="website" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="flowbite.com" required /> --}}
                    <label for="start_date" class="peer-focus:font-medium absolute text-sm text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date Finish</label>
                    <input type="datetime-local" 
                        value="{{ old('start_date', $building->start_date ?? '')}}"  
                        name="start_date" 
                        id="start_date" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder=" "
                        {{-- required="{{ request()->status == 'Done' ? 'required' : '' }}"  --}}
                        {{-- required --}}
                    />
                    
        </div>
        <div>
            @if (in_array (old('status', $building->status), ['Done', 'Cancel']))
            <label for="finish_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date Finish</label>
            {{-- <input type="url" id="website" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="flowbite.com" required /> --}}
                    <label for="finish_date" class="peer-focus:font-medium absolute text-sm text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date Finish</label>
                    <input type="datetime-local" 
                        value="{{ old('finish_date', $building->finish_date)}}"  
                        name="finish_date" 
                        id="finish_date" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder=" "
                        {{-- required="{{ request()->status == 'Done' ? 'required' : '' }}"  --}}
                        required
                    />
                    @endif
        </div>
    </div>
    <div class="mb-5">
        
        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
        {{-- <input 
            type="text"
            value="{{ old('description', $building->description ?? '') }}"
            id="description" 
            name="description" 
            rows="4" 
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">
            
        </input> --}}
        <textarea 
            name="description" 
            id="description"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."
            cols="10" rows="5">
        {{ old('description', $building->description ?? '' ) }}
        </textarea>
    </div>

    <div class="mb-4">
        <label class="block text-sm text-gray-700 font-medium dark:text-gray-50">Upload Gambar</label>
        <input 
            type="file" 
            name="image_buildings[]" 
            id="image_buildings"
            multiple
            accept="image/*,video/mp4"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-300 text-gray-900 dark:text-white dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500">
        <p class="text-xs text-gray-500 mt-1">Boleh upload lebih dari satu.</p>

        <div class="grid grid-cols-3 gap-4 mt-4" id="imagePreview"></div>
    </div>

    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
</form>
{{-- <form action="{{ isset($building) ? route('buildings.update', $building->id) : route('buildings.store') }}" method="post" enctype="multipart/form-data" class="max-w-md mx-auto mt-10"> --}}
    {{-- @csrf --}}
    {{-- @if(isset($building))
        @method('PUT')
    @endif --}}
    
    {{-- <div class="grid grid-cols-3 gap-4">
        @foreach ($ticket->images as $media)
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
    </div> --}}
    @if (isset($building) && $building->image_buildings?->count())

        <div class="grid grid-cols-3 gap-4 max-w-md mx-auto mt-10">
            @foreach ($building->image_buildings as $media)
                <div class="relative">
                    @php
                    $ext = pathinfo($media->path, PATHINFO_EXTENSION);
                    @endphp
            
                    @if(in_array(strtolower($ext), ['mp4']))
                        <video controls class="w-full h-32 object-cover mb-10 rounded">
                            <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $media->path) }}" alt="" class="w-full h-32 object-cover mb-10 rounded" />
                    @endif
                    
                    <form action="{{ route('images.destroy', $media->id) }}" method="POST" class="absolute top-1 right-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="bg-red-500 text-white text-xs px-2 py-1 rounded hover:bg-red-600"
                            onclick="return confirm('Yakin hapus media ini?')">
                            Hapus
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

{{-- </form> --}}

<script>
    document.getElementById('image_buildings').addEventListener('change', function(event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = ''; // Clear preview
    
        Array.from(event.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-full', 'h-32', 'object-cover', 'rounded');
                imagePreview.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    });
    </script>
    

</x-app-layout>