<x-app-layout>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class=" mt-5">
            <a href="{{ route('dashboard') }}" class="text-white bg-gray-500 py-1 px-5 text-lg m-10 rounded dark:bg-gray-400 dark:text-gray-700">Back</a>
    
            </div>



        
{{-- <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto mt-10"> --}}
<form action="{{ isset($ticket) ? route('tickets.update', $ticket->id) : route('tickets.store') }}" method="post" enctype="multipart/form-data" class="max-w-md mx-auto mt-10">
    
    @csrf
    @method('PUT')

    {{-- <input type="hidden" name="user" id="user" value="{{ $user->name }}" class="rounded-xl border-gray-700 bg-gray-700 text-white" readonly> --}}
    <div class="flex space-x-5 mb-5 text-gray-900 dark:text-white">
        <p class="text-l ">Created At : </p>
        <span class="font-sans">{{ $ticket->user }}</span>
    </div>
    <div class="mb-6">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ticketing ID</label>
        <input value="{{ $ticket->ticketing }}" type="text" name="ticketing" id="ticketing" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " disabled />
        <input type="text" value="{{ $ticket->ticketing }}" name="ticketing" id="ticketing" hidden>
    </div> 
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Problem</label>
            <input value="{{ $ticket->problem }}" type="text" name="problem" id="problem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required />
        </div>
        <div>
            <label for="problem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Outlet</label>
            <input value="{{ $ticket->outlet }}" type="text" disabled name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required />
            <input value="{{ $ticket->outlet }}" type="hidden" name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required />
            {{-- <select id="outlet_id" name="outlet_id" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option selected >Pilih Lokasi</option>
                @foreach ($outlets as $outlet)
                    <option value="{{ $outlet->id}}"  {{ $ticket->outlet_id == $outlet->id ? 'selected' : ''}}>{{ $outlet->name }}</option>
                @endforeach
            </select> --}}
        </div>
        <div>
            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
            {{-- <input value="{{ $ticket->outlet }}" type="text" name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
            <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        onchange="this.form.submit()"
                        >
                            <option value="Open" {{ old('status', $ticket->status) == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="InProgress" {{ old('status', $ticket->status) == 'InProgress' ? 'selected' : '' }}>InProgress</option>
                            <option value="Done" {{ old('status', $ticket->status) == 'Done' ? 'selected' : '' }}>Done</option>
                            <option value="Cancel" {{ old('status', $ticket->status) == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                        </select>
        </div>  
        <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IT Name</label>
            {{-- <input type="tel" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required /> --}}
            <select id="it_name" name="it_name" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                 
                        {{-- <option value="Andika" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Andika') ? 'selected' : '' }}>Andika</option>
                        <option value="Usman" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Usman') ? 'selected' : '' }}>Usman</option>
                        <option value="Asep" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Asep') ? 'selected' : '' }}>Asep</option>
                        <option value="Santo" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Santo') ? 'selected' : '' }}>Santo</option> --}}
                        <option value="Andika" {{  old('it_name', $ticket->it_name == 'Andika' ? 'selected' : '') }}>Andika</option>
                        <option value="Usman" {{  old('it_name', $ticket->it_name) == 'Usman' ? 'selected' : '' }} disabled>Usman</option>
                        <option value="Asep" {{  old('it_name', $ticket->it_name) == 'Asep' ? 'selected' : '' }}>Asep</option>
                        <option value="Santo" {{  old('it_name', $ticket->it_name) == 'Santo' ? 'selected' : '' }}>Santo</option>
                        <option value="Kodam" {{  old('it_name', $ticket->it_name) == 'Kodam' ? 'selected' : '' }}>Kodam</option>
                    </select>
        </div>
        <div>
            
            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
            {{-- <input type="url" id="website" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="flowbite.com" required /> --}}
                    <label for="start_date" class="peer-focus:font-medium absolute text-sm text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date Finish</label>
                    <input type="datetime-local" 
                        value="{{ old('start_date', $ticket->start_date ?? '')}}"  
                        name="start_date" 
                        id="start_date" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder=" "
                        {{-- required="{{ request()->status == 'Done' ? 'required' : '' }}"  --}}
                        {{-- required --}}
                    />
                    
        </div>
        <div>
            @if (in_array (old('status', $ticket->status), ['Done', 'Cancel']))
            <label for="date_finish" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date Finish</label>
            {{-- <input type="url" id="website" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="flowbite.com" required /> --}}
                    <label for="date_finish" class="peer-focus:font-medium absolute text-sm text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date Finish</label>
                    <input type="datetime-local" 
                        value="{{ old('date_finish', $ticket->date_finish)}}"  
                        name="date_finish" 
                        id="date_finish" 
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
            value="{{ old('description', $ticket->description ?? '') }}"
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
        {{ old('description', $ticket->description ?? '' ) }}
        </textarea>
    </div>

    <div class="mb-4">
        <label class="block text-sm text-gray-700 font-medium dark:text-gray-50">Upload Gambar</label>
        <input 
            type="file" 
            name="images[]" 
            id="images"
            multiple
            accept="image/*,video/mp4"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-300 text-gray-900 dark:text-white dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500">
        <p class="text-xs text-gray-500 mt-1">Boleh upload lebih dari satu.</p>

        <div class="grid grid-cols-3 gap-4 mt-4" id="imagePreview"></div>
    </div>

    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
</form>
{{-- <form action="{{ isset($ticket) ? route('tickets.update', $ticket->id) : route('tickets.store') }}" method="post" enctype="multipart/form-data" class="max-w-md mx-auto mt-10"> --}}
    {{-- @csrf --}}
    {{-- @if(isset($ticket))
        @method('PUT')
    @endif --}}
    
    @if (isset($ticket) && $ticket->images->count())

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
        <div class="grid grid-cols-3 gap-4 max-w-md mx-auto mt-10">
            @foreach ($ticket->images as $media)
                <div class="relative">
                    {{-- <img src="{{ asset('storage/' . $media->path) }}" alt="" class="w-full h-32 object-cover mb-10 rounded" /> --}}
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
    document.getElementById('images').addEventListener('change', function(event) {
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