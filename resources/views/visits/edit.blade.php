<x-app-layout>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class=" mt-5">
    <a href="{{ route('visits.index') }}" class="text-black py-1 px-5 text-lg m-10 rounded bg-gray-400">Back</a>

    </div>

    <div class="grid w-full mt-10">
        <h2 class="flex justify-center font-semibold text-3xl items-center text-gray-800 dark:text-white leading-tight">
            Form Edit Visit
            {{-- {{ $outlet->name }} --}}
        </h2>

    </div>

    <form action="{{ route('visits.update', $visits->id) }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto mt-10">
        @csrf
        @method('PUT')
        <div class="relative z-0 w-full mb-5 group">
            {{-- <input type="text" name="problem" id="problem" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="problem" class="peer-focus:font-medium absolute text-sm  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Problem</label> --}}
            <div>
                <label for="pic" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">PIC</label>
                {{-- <input type="text" name="pic" id="pic" value="{{ old('pic') }}" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-300"> --}}
                <select id="pic" name="pic" 
                        class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                        >
                 
                        @foreach (['Andika', 'Usman', 'Asep', 'Santo', 'Kodam'] as $pic)
                           <option value="{{ $pic }}" {{ $visits->pic === $pic ? 'selected' : '' }}>{{ $pic }}</option>
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
            <select id="outlet_id" name="outlet_id" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option selected >Pilih Lokasi</option>
                @foreach ($outlets as $outlet)
                    <option value="{{ $outlet->id}}"  {{ $visits->outlet_id == $outlet->id ? 'selected' : ''}}>{{ $outlet->name }}</option>
                @endforeach
                {{-- <option value="US">United States</option>
                <option value="CA">Canada</option>
                <option value="FR">France</option>
                <option value="DE">Germany</option> --}}
            </select>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
          {{-- <div class="relative z-0 w-full mb-5 group">
            </div> --}}
        <div class="relative z-0 w-full mb-5 group mt-10">
            {{-- <input type="" value="Open" name="status" id="status" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
            {{-- <label for="it_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label> --}}
            <label for="ticket_id" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ticket</label>
            <select name="ticket_id" id="ticket_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <option value="" class="text-black dark:text-gray-700"> Tidak ada ticket </option>
            @foreach ($tickets as $ticket)
                <option
                    class="bg-gray-600 dark:bg-gray-100 dark:hover:bg-gray-700 hover:bg-gray-300 text-black dark:text-gray-500" 
                    value="{{ $ticket->id }}" {{ $visits->ticket_id == $ticket->id ? 'selected' : '' }}>
                    {{ $ticket->ticketing }} - {{ $ticket->problem }}
                </option>
            @endforeach
            </select>
        </div> 
          <div class="relative z-0 w-full mb-5 group">
              <div class="relative z-0 w-full mb-5 group mt-10">
                  {{-- <input type="hidden" value=" " name="it_name" id="it_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                  <label for="tanggal_visit" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal Visit</label>
                  <input type="datetime-local" name="tanggal_visit" id="tanggal_visit" value="{{ \Carbon\Carbon::parse($visits->tanggal_visit)->format('Y-m-d\TH:i')  }}" required class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                  {{-- <label for="it_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label> --}}
              </div>
            </div>
    </div>

    <div class="mb-5">
        
        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
        
        <input 
        type="text"
        value="{{ old('description', $visits->description ?? '') }}"
        id="description" 
        name="description" 
        rows="4" 
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">
        
    </input>
    {{-- @endforeach --}}
    </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>
</x-app-layout>

