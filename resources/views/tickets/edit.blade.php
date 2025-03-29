<x-app-layout>
    <h2>Form Input Data</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class=" mt-5">
            <a href="{{ route('dashboard') }}" class="text-black py-1 px-5 text-lg m-10 rounded bg-gray-400">Back</a>
    
            </div>

       
        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="max-w-md mx-auto mt-10">
            @csrf
            @method('PUT')
            <div class="relative z-0 w-full mb-5 group">
                <input value="{{ $ticket->ticketing }}" type="text" name="ticketing" id="ticketing" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="ticketing" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ticketing ID</label>
                @error('ticketing')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input value="{{ $ticket->problem }}" type="text" name="problem" id="problem" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="problem" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Problem</label>
                @error('problem')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input value="{{ $ticket->outlet }}" type="text" name="outlet" id="outlet" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="outlet" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label>
                @error('outlet')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
              <div class="relative z-0 w-full mb-5 group">
                  <label for="status" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Status</label>
                 
                    <select id="status" name="status" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                 
                
                        <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>Open</option>
                        <option value="OnProgress" {{ $ticket->status == 'OnProgress' ? 'selected' : '' }}>OnProgress</option>
                        <option value="Done" {{ $ticket->status == 'Done' ? 'selected' : '' }}>Done</option>
                    </select>
                    @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
             {{-- @if (session('edit_step_'.$ticket->id) > 1)  --}}
             @if (session()->has('edit_step_'.$ticket->id) && session('edit_step_'.$ticket->id) >= 1)
              <div class="relative z-0 w-full mb-5 group">
                <div class="relative z-0 w-full mb-5 group">
                    <label for="it_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">IT Name</label>
                    <select id="it_name" name="it_name" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                 
                        <option value="Andika" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Andika') ? 'selected' : '' }}>Andika</option>
                        <option value="Usman" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Usman') ? 'selected' : '' }}>Usman</option>
                        <option value="Asep" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Asep') ? 'selected' : '' }}>Asep</option>
                        <option value="Santo" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Santo') ? 'selected' : '' }}>Santo</option>
                    </select>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" value="{{ session('edit_step_'.$ticket->id) == 1 ? '' : $ticket->lama_pengerjaan }}" name="lama_pengerjaan" id="lama_pengerjaan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    {{-- <input type="text" value="{{ old('lama_pengerjaan', $ticket->lama_pengerjaan) }}" name="lama_pengerjaan" id="lama_pengerjaan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                    <label for="lama_pengerjaan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Lama Pengerjaan</label>
                    
                </div>
            </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="date" value="{{ session('edit_step_'.$ticket->id) == 1 ? '' : $ticket->date_finish }}"  name="date_finish" id="date_finish" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    {{-- <input type="date" value="{{ old('date_finish', $ticket->date_finish)}}"  name="date_finish" id="date_finish" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                    <label for="date_finish" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date Finish</label>
                </div>
                @endif
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
</x-app-layout>