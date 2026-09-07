{{-- <x-app-layout> --}}

    {{-- @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}

    <!-- Main modal -->
    {{-- <div id="add-modal" tabindex="-1" aria-hidden="true" class=" overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"> --}}
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add Visit
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="flex justify-center p-4">
                    <form method="POST" enctype="multipart/form-data"  action="{{ route('visits.store') }}" class="flex-wrap gap-5 justify-center items-end mb-6 mt-5">
                        @csrf

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PIC</label>
                                {{-- <input value="{{ $ticket->problem }}" type="text" name="problem" id="problem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
                                {{-- <select name="pic" class="border p-1 rounded-lg pr-10 mr-20"> --}}
                                {{-- <select name="pic" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                
                                    <option class="text-black" value="Pilih PIC">Pilih PIC</option>
                                    <option class="text-black" value="Andika">Andika</option>
                                    <option class="text-gray-400" value="Usman"  disabled>Usman</option>
                                    <option class="text-black" value="Asep" >Asep</option>
                                    <option class="text-black" value="Santo" >Santo</option>
                                    <option class="text-black" value="Kodam" >Kodam</option>
                                </select> --}}

                                <select id="employee_id" name="employee_id" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                    <option disabled selected >Pilih PIC</option>
                                    @foreach ($employees as $employee )
                                        <option value="{{ $employee->id }}" class="bg-gray-600 dark:bg-gray-100 dark:hover:bg-gray-700 hover:bg-gray-300 text-black dark:text-gray-500">{{ $employee->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div>
                                <label for="problem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Outlet</label>
                                <select id="outlet_id" name="outlet_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option disabled selected >Pilih Lokasi</option>
                                        @if ($specialOutlet)
                                            <option value="{{ $specialOutlet->id}}" class="bg-gray-600 dark:bg-gray-100 dark:hover:bg-gray-700 hover:bg-gray-300 text-black dark:text-gray-500">{{ $specialOutlet->name }}</option>
                                        @endif

                                        @foreach ($outlets as $outlet)
                                            @if (!$specialOutlet || $outlet->id != $specialOutlet->id) 
                                                <option value="{{ $outlet->id }}" class="bg-gray-600 dark:bg-gray-100 dark:hover:bg-gray-700 hover:bg-gray-300 text-black dark:text-gray-500">{{ $outlet->name }}</option>
                                            @endif
                                        @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="ticket_id" class="peer-focus:font-medium text-sm text-gray-500 dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ticket</label>
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
                            <div>
                                <label for="tanggal_visit" class="peer-focus:font-medium text-sm text-gray-500 dark:text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Visit Date</label>
                                <input type="datetime-local" name="tanggal_visit" id="tanggal_visit" value="{{ old('tanggal_visit') }}" required class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">    
                            </div>
                            <div class="col-span-2 dark:text-gray-300">
                                <label for="description" class="block text-sm font-medium text-heading">Job Description</label>
                                <textarea id="description" name="description" rows="4" class="block bg-transparent border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand w-full p-3.5 shadow-xs placeholder:text-body dark:placeholder:text-gray-300" placeholder="Write job description here"></textarea>                    
                            </div>
                            <div class="">
                                <input type="hidden" value="Open" name="status" id="status" class="" required />
                                <input type="hidden" value="" name="pic" id="pic" class="" />
                            </div>

                        </div>
                        {{-- <span class=" border-b rounded-t dark:border-gray-600 border-gray-200"></span> --}}

                        <div class="flex items-center pt-5 ">
                            <button data-modal-hide="add-modal" type="submit" class="text-white bg-blue-700 w-full hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            {{-- <button data-modal-hide="add-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button> --}}
                        </div>
                    </form>

                </div>
            </div>
        </div>
    {{-- </div> --}}

    {{-- <div class=" grid grid-cols-3 items-center">
        <div class="relative p-3 ">
            <a href="{{ route('visits.index') }}" class="text-white p-3 text-lg m-10 rounded-full  dark:text-gray-700 max-w-min ">
                <svg class="w-6 h-6 text-gray-800 absolute inset-y-0 left-2 top-3 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                </svg>
    
            </a>

        </div>

        <h1 class="text-gray-800  dark:text-gray-100 text-xl md:text-3xl m-5 max-w-md mx-auto text-center">Visit Form</h1>
        <div class=" pe-1 px-5">

        </div>
    </div>

    <form action="{{ route('visits.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto mt-10">
        @csrf
        <div class="relative z-0 w-full mb-5 group">
            <div>
                <label for="pic" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">PIC</label>
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
            <label for="outlet_id" class="peer-focus:font-medium absolute text-xl  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label>
            @error('outlet_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <select id="outlet_id" name="outlet_id" 
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <option disabled selected >Pilih Lokasi</option>
                @if ($specialOutlet)
                    <option value="{{ $specialOutlet->id}}" class="bg-gray-600 dark:bg-gray-100 dark:hover:bg-gray-700 hover:bg-gray-300 text-black dark:text-gray-500">{{ $specialOutlet->name }}</option>
                @endif

                @foreach ($outlets as $outlet)
                    @if (!$specialOutlet || $outlet->id != $specialOutlet->id) 
                        <option value="{{ $outlet->id }}" class="bg-gray-600 dark:bg-gray-100 dark:hover:bg-gray-700 hover:bg-gray-300 text-black dark:text-gray-500">{{ $outlet->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="relative z-0 w-full mb-5 group mt-10">
            <label for="description" class="peer-focus:font-medium absolute text-xl  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Job Desk</label>
            <input id="description" name="description" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer" placeholder="Job Desk..." required />
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
          <div class="relative z-0 w-full mb-5 group">
             
            <div class="relative z-0 w-full mb-5 group mt-10">
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
                <label for="tanggal_visit" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Visit Date</label>
                <input type="datetime-local" name="tanggal_visit" id="tanggal_visit" value="{{ old('tanggal_visit') }}" required class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
            </div> 
            <div class="relative z-0 w-full mb-5 group">
                <input type="hidden" value="Open" name="status" id="status" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required />
                
            </div>
        </div>
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form> --}}
{{-- </x-app-layout> --}}

