<x-app-layout>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class=" grid grid-cols-3 items-center">
        <div class="relative p-3 ">
            <a href="{{ route('building.visits.index') }}" class="text-white p-3 text-lg m-10 rounded-full  dark:text-gray-700 max-w-min ">
                <svg class="w-6 h-6 text-gray-800 absolute inset-y-0 left-2 top-3 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                </svg>
    
            </a>

        </div>

        <h1 class="text-gray-800  dark:text-gray-100 text-xl md:text-3xl m-5 max-w-md mx-auto text-center sm:text-black">Form Edit Visit</h1>
        <div class=" pe-1 px-5">
            {{-- <span>aaa</span> --}}
        </div>
    </div>

    {{-- <div class=" mt-5">
    <a href="{{ route('building.visits.index') }}" class="text-black py-1 px-5 text-lg m-10 rounded bg-gray-400">Back</a>

    </div>

    <div class="grid w-full mt-10">
        <h2 class="flex justify-center font-semibold text-3xl items-center text-gray-800 dark:text-white leading-tight">
            Form Edit Visit
            {{ $outlet->name }}
        </h2>

    </div> --}}

    <form action="{{ route('building.visits.update', $visits->id) }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto mt-10">
        @csrf
        @method('PUT')
        <div class="relative z-0 w-full mb-5 group">
            {{-- <input type="text" name="problem" id="problem" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="problem" class="peer-focus:font-medium absolute text-sm  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Problem</label> --}}
            <div>
                <label for="employeebuild" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">PIC</label>
                {{-- <input type="text" name="pic" id="pic" value="{{ old('pic') }}" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-300"> --}}
                <select id="employeebuild" name="employeebuild" 
                        class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                        >
                 
                         @foreach (['Bambang', 'Irfan', 'Sandi', 'Handoko', 'Reza'] as $employeebuild)
                           <option class="text-gray-800 " value="{{ $employeebuild }}" {{ $visits->employeebuild === $employeebuild ? 'selected' : '' }}>{{ $employeebuild }}</option>
                        @endforeach
                    </select>
            </div>
        </div>
        <div class="relative z-0 w-full mb-5 group mt-10">
            {{-- <input type="text" name="outlet" id="outlet" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
            <label for="outlet_id" class="peer-focus:font-medium absolute text-xl text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label>
            @error('outlet_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            {{-- <select id="outlet_id" name="outlet_id" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option selected >Pilih Lokasi</option>
                @foreach ($outlets as $outlet)
                    <option value="{{ $outlet->id}}"  {{ $visits->outlet_id == $outlet->id ? 'selected' : ''}}>{{ $outlet->name }}</option>
                @endforeach
            </select> --}}
            <select id="outlet_id" name="outlet_id" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option disabled selected >Pilih Lokasi</option>
                @if ($specialOutlet)
                    <option class="text-gray-700" value="{{ $specialOutlet->id}}">{{ $specialOutlet->name }}</option>
                @endif

                @foreach ($outlets as $outlet)
                    @if (!$specialOutlet || $outlet->id != $specialOutlet->id) 
                        <option class="text-gray-700" value="{{ $outlet->id }}" {{ $visits->outlet_id == $outlet->id ? 'selected' : ''}}>{{ $outlet->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        {{-- <div class="relative z-0 w-full mb-5 group mt-10">
            <label for="jobdesk" class="peer-focus:font-medium absolute text-xl  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Job Desk</label>
           
            <input id="description" name="description" value="{{ $visit->description }}" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer" placeholder="Job Desk..." required />
                
            
        </div> --}}
        <div class="grid md:grid-cols-2 md:gap-6">
          {{-- <div class="relative z-0 w-full mb-5 group">
            </div> --}}
        <div class="relative z-0 w-full mb-5 group mt-10">
            {{-- <input type="" value="Open" name="status" id="status" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
            {{-- <label for="it_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label> --}}
            <label for="ticket_id" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ticket</label>
            <select name="building_id" id="building_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <option value="" class="text-black dark:text-gray-700"> Tidak ada ticket </option>
            @foreach ($tickets as $ticket)
                <option
                    class="bg-gray-600 dark:bg-gray-100 dark:hover:bg-gray-700 hover:bg-gray-300 text-black dark:text-gray-500" 
                    value="{{ $ticket->id }}" {{ $visits->building_id == $ticket->id ? 'selected' : '' }}>
                    {{ $ticket->ticketing }} - {{ $ticket->problem }}
                </option>
            @endforeach
            </select>
        </div> 
          <div class="relative z-0 w-full mb-5 group">
              <div class="relative z-0 w-full mb-5 group mt-10">
                  {{-- <input type="hidden" value=" " name="it_name" id="it_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                  <label for="tanggal_visit" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Visit Date</label>
                  <input type="datetime-local" name="tanggal_visit" id="tanggal_visit" value="{{ \Carbon\Carbon::parse($visits->tanggal_visit)->format('Y-m-d\TH:i')  }}" required class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                  {{-- <label for="it_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label> --}}
              </div>
            </div>
    </div>

    <div>
        <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
        {{-- <input value="{{ $ticket->outlet }}" type="text" name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
        <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    onchange="this.form.submit()"
                    >
                        <option value="Open" {{ old('status', $visits->status) == 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="Finished" {{ old('status', $visits->status) == 'Finished' ? 'selected' : '' }}>Finished</option>
                        <option value="InProgress" {{ old('status', $visits->status) == 'InProgress' ? 'selected' : '' }}>InProgress</option>
                        <option value="Reschedule" {{ old('status', $visits->status) == 'Reschedule' ? 'selected' : '' }}>Reschedule</option>
                        <option value="Cancelled" {{ old('status', $visits->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
    </div>  

    <div class="mb-5 mt-5">
        
        <label for="jobdesk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jobdesk</label>
        
        <input 
        type="text"
        value="{{ old('jobdesk', $visits->jobdesk ?? '') }}"
        id="jobdesk" 
        name="jobdesk" 
        rows="4" 
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">
        
    </input>

    {{-- <div class="mb-4 mt-5">
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
    </div> --}}
    {{-- @endforeach --}}
    </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>

    {{-- @if (isset($visits) && $visits->images->count())
    <div class="grid grid-cols-3 gap-4 max-w-md mx-auto mt-10">
        @foreach ($visits->images as $media)
            <div class="relative">
                <img src="{{ asset('storage/' . $media->path) }}" alt="" class="w-full h-32 object-cover mb-10 rounded" />
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
        @endforeach --}}
    </div>
{{-- @endif --}}

{{-- </form> --}}

{{-- <script>
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
</script> --}}
</x-app-layout>

