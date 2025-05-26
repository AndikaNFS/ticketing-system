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
            Visit Form
            {{-- {{ $outlet->name }} --}}
        </h2>

    </div>

    <form action="{{ route('visits.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto mt-10">
        @csrf
        <div class="relative z-0 w-full mb-5 group">
            <div>
                <label for="pic" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">PIC</label>
                {{-- <input type="text" name="pic" id="pic" value="{{ old('pic') }}" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-300"> --}}
                <select id="pic" name="pic" 
                        class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                        >
                 
                        <option class="text-black" value="Pilih PIC">Pilih PIC</option>
                        <option class="text-black" value="Andika">Andika</option>
                        <option class="text-gray-400" value="Usman"  disabled>Usman</option>
                        <option class="text-black" value="Asep" >Asep</option>
                        <option class="text-black" value="Santo" >Santo</option>
                        <option class="text-black" value="Kodam" >Kodam</option>
                    </select>
            </div>
        </div>
        <div class="relative z-0 w-full mb-5 group mt-10">
            {{-- <input type="text" name="outlet" id="outlet" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
            <label for="outlet_id" class="peer-focus:font-medium absolute text-xl  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label>
            @error('outlet_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <select id="outlet_id" name="outlet_id" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option selected >Pilih Lokasi</option>
                @foreach ($outlets as $outlet)
                    <option class="text-black" value="{{ $outlet->id}}">{{ $outlet->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
          <div class="relative z-0 w-full mb-5 group">
             
            <div class="relative z-0 w-full mb-5 group mt-10">
                {{-- <input type="" value="Open" name="status" id="status" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                {{-- <label for="it_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label> --}}
                <label for="ticket_id" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ticket</label>
                <select name="ticket_id" id="ticket_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <option value="" class="text-black"> Pilih Ticket </option>
                    @foreach ($tickets as $ticket)
                        <option
                            class="bg-gray-600 dark:bg-gray-100 dark:hover:bg-gray-700 hover:bg-gray-300 text-black dark:text-gray-500" 
                            value="{{ $ticket->id }}">{{ $ticket->ticketing }} - {{ $ticket->problem }}
                    </option>
                    @endforeach
                </select>
            </div> 
          </div>
          <div class="relative z-0 w-full mb-5 group mt-10">
            <div class="relative z-0 w-full mb-5 group">
                {{-- <input type="hidden" value=" " name="it_name" id="it_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                <label for="tanggal_visit" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal Visit</label>
                <input type="datetime-local" name="tanggal_visit" id="tanggal_visit" value="{{ old('tanggal_visit') }}" required class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                {{-- <label for="it_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label> --}}
            </div> 
            <div class="relative z-0 w-full mb-5 group">
                {{-- <input type="hidden" value=" " name="lama_pengerjaan" id="lama_pengerjaan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                {{-- <label for="lama_pengerjaan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label> --}}
                
            </div>
            <div class="relative z-0 w-full mb-5 group">
                {{-- <input type="hidden" value=" " name="date_finish" id="date_finish" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                {{-- <label for="date_finish" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label> --}}
                
            </div>
        </div>
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>
</x-app-layout>

