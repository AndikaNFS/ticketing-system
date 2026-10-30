{{-- <x-app-layout>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class=" grid grid-cols-3 items-center">
            <div class="relative p-3 ">
                <a href="{{ route('building.tickets.index') }}" class="text-white p-3 text-lg m-10 rounded-full  dark:text-gray-700 max-w-min ">
                    <svg class="w-6 h-6 text-gray-800 absolute inset-y-0 left-2 top-3 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                    </svg>
        
                </a>

            </div>

            <h1 class="text-gray-800  dark:text-gray-100 text-xl md:text-3xl m-5 max-w-md mx-auto text-center">Form Add Ticket</h1>
            <div class=" pe-1 px-5">
            </div>
        </div> --}}

        {{-- <div class=" mt-5">
        <a href="{{ route('building.tickets.index') }}" class="text-black py-1 px-5 text-lg m-10 rounded bg-gray-400">Back</a>

        </div>

        <div class="grid w-full mt-10">
            <h2 class="flex justify-center font-semibold text-3xl items-center text-gray-800 dark:text-white leading-tight">
                Form Tambah Tiket
                {{ $outlet->name }}
            </h2>

        </div> --}}

        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add Ticket
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
                    <form method="POST" enctype="multipart/form-data"  action="{{ route('building.tickets.store') }}" class="flex-wrap gap-5 justify-center items-end mb-6 mt-5">
                        @csrf
                        <input type="hidden" value="{{ $user->name }}" name="user" id="user">

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="text-white">
                                <label for="problem" class="block mb-2.5 text-gray-900 dark:text-white text-sm font-medium text-heading">Problem</label>
                                <input type="text" id="problem" name="problem" class=" bg-transparent text-gray-900 dark:text-white border border-default-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder=" " required />
                            </div>
                            <div>
                                <label for="outlet_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Outlet</label>
                                {{-- <input value="{{ $ticket->outlet }}" type="text"  name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
                                {{-- <input value="{{ $ticket->outlet }}" type="hidden" name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
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
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full group">
                                    <div class="relative z-0 w-full group">
                                        <input type="hidden" value="Open" name="status" id="status" class=" focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    </div> 
                                </div>
                                <div class="relative z-0 w-full group">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="hidden" value="" name="work_duration" id="work_duration" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    </div>
                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="hidden" value="" name="finish_date" id="finish_date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        <input type="hidden" value="" name="start_date" id="start_date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                        
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <input type="hidden" value=" " name="pic" id="pic" class=" focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    </div> 
                                    <div class="relative z-0 w-full group">
                                        <input type="hidden" value=" " name="vendor" id="vendor" class=" focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    </div> 
                                    {{-- <div class="relative z-0 w-full group">
                                        <input type="hidden" value=" " name="lama_pengerjaan" id="lama_pengerjaan" class=" focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    </div> --}}
                                    {{-- <div class="relative z-0 w-full group">
                                        <input type="hidden" value=" " name="date_finish" id="date_finish" class=" focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        {{-- <span class=" border-b rounded-t dark:border-gray-600 border-gray-200"></span> --}}

                        <div class="flex items-center ">
                            <button data-modal-hide="add-modal" type="submit" class="text-white bg-blue-700 w-full hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            {{-- <button data-modal-hide="add-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button> --}}
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- <form action="{{ route('building.tickets.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto mt-10">
            @csrf
            <input type="hidden" value="{{ $user->name }}" name="user" id="user">
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="problem" id="problem" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="problem" class="peer-focus:font-medium absolute text-sm  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Problem</label>
                
            </div>
            <div class="relative z-0 w-full mb-5 group mt-10">
                <label for="outlet" class="peer-focus:font-medium absolute text-xl  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label>
                @error('outlet')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <select id="outlet_id" name="outlet_id" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-800 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option disabled selected >Pilih Lokasi</option>
                    @if ($specialOutlet)
                        <option value="{{ $specialOutlet->id}}">{{ $specialOutlet->name }}</option>
                    @endif

                    @foreach ($outlets as $outlet)
                        @if (!$specialOutlet || $outlet->id != $specialOutlet->id) 
                            <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="relative z-0 w-full mb-5 group mt-10">
                <label for="pic" class="peer-focus:font-medium absolute text-xl  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">PIC</label>
                @error('pic')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <select id="pic_id" name="pic_id" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option selected>Pilih PIC</option>
                    @foreach ($pics as $pic)
                        <option value="{{ $pic->id }}">{{ $pic->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative z-0 w-full mb-5 group mt-10">
                <label for="vendor" class="peer-focus:font-medium absolute text-xl  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Vendor</label>
                @error('vendor')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <select id="vendor_id" name="vendor_id" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option selected value="">Pilih Vendor</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
              <div class="relative z-0 w-full mb-5 group">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="hidden" value="Open" name="status" id="status" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                </div> 
              </div>
              <div class="relative z-0 w-full mb-5 group">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="hidden" value="" name="work_duration" id="work_duration" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                   
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="hidden" value="" name="finish_date" id="finish_date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <input type="hidden" value="" name="start_date" id="start_date" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    
                </div>
            </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form> --}}
{{-- </x-app-layout> --}}