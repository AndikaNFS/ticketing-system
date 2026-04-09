

<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticketing') }}
        </h2>
    </x-slot> --}}
    

    <div class="">
        <div class="text-center w-full ">
            <p class=" text-4xl dark:text-gray-200 font-semibold leading-normal text-heading">Visit Schedule</p>

        </div>
        
        
        <div class="container mx-auto px-4 py-6">
                <div class="">
                    {{-- <div class="flex justify-between place-items-center bg-gray-700 border border-gray-600 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500"> --}}
                    <div class="flex flex-wrap sm:flex-nowrap gap-3 justify-between items-center bg-gray-700 border border-gray-600 text-gray-900 text-sm rounded-lg w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-black">
                        {{-- <div class="flex "> --}}
                           <form class="w-full sm:w-auto flex items-center gap-2" method="GET" action="{{ route('visits.index') }}">   
                                <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2"/>
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search PIC / Ticketing ID..." />
                                </div>
                                <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                                <span class="sr-only">Search</span>
                                </button>
                            </form>
        
                        {{-- </div> --}}
                            <div class="flex min-w-max ">
                                <div class="">
                                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white w-full sm:w-auto font-medium rounded-xl text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2"/>
                                        </svg>
                                    </button>
                                </div>
                                <!-- Modal toggle -->
                                {{-- <div class="flex text-white w-full sm:w-auto bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"> --}}
                                <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white w-full sm:w-auto font-medium rounded-full text-sm px-5 py-2.5 text-center" type="button">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z"/>
                                    </svg>    
                                </button>
                                <!-- Add -->
                                @if (auth()->user()->hasRole('admin|superadmin'))
                                    <button data-modal-target="add-modal" data-modal-toggle="add-modal" class="block text-white w-full ml-3 sm:w-auto bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-2.5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                        </svg>
            
                                    </button>
                                @endif
                                <!-- Main modal -->
                                {{-- <div class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"> --}}
                                    <div id="add-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    
                                        @include('visits.create')
                                    </div>
                                </div>
                                <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Filter Visit
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            {{-- <h4 class="text-lg font-semibold mb-2">Filter Data Tiket</h4> --}}
                                            <div class="flex justify-center">
                                                <form method="GET" action="{{ route('visits.index') }}" class="flex-wrap gap-5 justify-center items-end mb-6 mt-5">
            
                                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                                        <div>
                                                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                                            {{-- <input value="{{ $ticket->problem }}" type="text" name="problem" id="problem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
                                                            {{-- <select name="status" class="border p-1 rounded-lg pr-10 mr-20"> --}}
                                                            <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                    <option value=""> Select Status </option>
                                                                    <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                                                                    <option value="InProgress" {{ request('status') == 'InProgress' ? 'selected' : '' }}>InProgress</option>
                                                                    <option value="Reschedule" {{ request('status') == 'Reschedule' ? 'selected' : '' }}>Reschedule</option>
                                                                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                                    <option value="Finished" {{ request('status') == 'Finished' ? 'selected' : '' }}>Finished</option>
                                                            </select>
            
                                                        </div>
                                                        <div>
                                                            <label for="problem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Outlet</label>
                                                            {{-- <input value="{{ $ticket->outlet }}" type="text"  name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
                                                            {{-- <input value="{{ $ticket->outlet }}" type="hidden" name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
                                                            <select id="outlet_id" name="outlet_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                <option value="" >Select Outlet</option>
                                                                @foreach($outlets as $outlet)
                                                                        <option value="{{ $outlet->id }}" {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>
                                                                            {{ $outlet->name }}
                                                                        </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                                                            {{-- <input value="{{ $ticket->outlet }}" type="text" name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
                                                            <input type="date" name="start" value="{{ request('start') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            
                                                        </div>  
                                                        <div>
                                                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Finish Date</label>
                                                            {{-- <input type="tel" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required /> --}}
                                                            <input type="date" name="end" value="{{ request('end') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        </div>
                                                    </div>
            
                                                    <span class=" border-b rounded-t dark:border-gray-600 border-gray-200"></span>
                                                    <div class="flex items-center pt-5 mt-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button data-modal-hide="default-modal" type="submit" class="text-white bg-blue-700 w-full hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                                        {{-- <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button> --}}
                                                    </div>
                                                </form>
            
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                            </div>
                        
                    </div>
                {{-- <h1 class="text-2xl text-center text-gray-800 dark:text-gray-50 font-bold mb-4">Visit List</h1> --}}
            
                {{-- <a href="{{ route('visits.create') }}" class="mb-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Kunjungan</a> --}}
                <div class="flex place-content-between">
                    @if (auth()->user()->hasRole('admin|superadmin'))

                <div class="relative z-20 pr-7">

                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a href="{{ route('visit.export.excel', request()->query()) }}" 
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Excel</a>
                        </li>
                        <li>
                            <a href="{{ route('visit.export.pdf', request()->query()) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">PDF</a>
                        </li>
                        </ul>
                    </div>

                </div>
                @endif
                </div>
                <div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg mt-2" style="max-height:30em;">
                    
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg ">
                        <thead class="bg-gray-100 dark:bg-gray-600 uppercase sticky top-0 z-10 text-left text-sm font-semibold text-gray-600">
                            <tr class="text-black dark:text-gray-200">
                                {{-- <th class="px-4 py-3">#</th> --}}
                                <th class="px-4 py-3 ">IT Name</th>
                                <th class="px-4 py-3">Visit Date</th>
                                <th class="px-4 py-3">Outlet</th>
                                <th class="px-4 py-3">Ticket</th>
                                <th class="px-4 py-3">Job Desk</th>
                                <th class="px-4 py-3">Status</th>
                                {{-- @if (auth()->user()->hasRole('admin|superadmin')) --}}
                                
                                    <th class="px-4 py-3">Action</th>
                                {{-- @endif --}}
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            @forelse ($visits as $visit)
                                <tr class="bg-white border-b  h-14 dark:bg-gray-100 dark:hover:text-gray-50 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                
                                    {{-- <td class="px-4 py-2">{{ $loop->iteration }}</td> --}}
                                    <td scope="" class="px-4 py-2 ">{{ $visit->employee?->name ?? '-' }}</td>
                                    {{-- <td class="px-4 py-2">{{ \Carbon\Carbon::parse($visit->tanggal_visit)->format('d M Y H:i') }}</td> --}}
                                    <td class="px-4 py-2">{{ $visit->tanggal_visit?->format('d M Y H:i') ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $visit->outlet?->name ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        @if (isset($visit->ticket->ticketing))
                                        {{ $visit->ticket->ticketing }}
                                        @else
                                        <p class="text-gray-400">No Ticketing</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        {{-- @if (isset($visit->description)) --}}
                                        <div class="hover:overflow-auto overflow-hidden">
                                            {{-- <div class="mr-1 flex place-items-center"> --}}
                                                {{-- @foreach ($visit as $visit) --}}
                                                {{ $visit->description }}
                                                    
                                                {{-- @endforeach --}}
                                            {{-- </div> --}}

                                        </div>
                                        {{-- @else
                                        <p class="text-gray-400">No Description</p>
                                        @endif --}}
                                    </td>
                                    <td class="px-4 py-6">
                                       <span class=" px-2 py-1 rounded text-white
                                     {{ 
                                        $visit->status == 'Open' ? 'bg-blue-500' : 
                                        ($visit->status == 'Finished' ? 'bg-green-500' : 
                                        ($visit->status == 'Reschedule' ? 'bg-orange-500' : 
                                        ($visit->status == 'InProgress' ? 'bg-yellow-500' : 'bg-red-500'))) }}">
                                     {{ $visit->status }}
                                </span>
                                    </td>
                                     {{-- @if (auth()->user()->hasRole('admin|superadmin')) --}}

                                    <td class="px-4 py-2 text-right">
                                        <div class="flex space-x-2">
                                            @can('edit visit')
                                            {{-- @if (auth()->user()->hasRole('admin|superadmin')) --}}
                                            <a href="{{ route('visits.edit', $visit->id) }}" class="hover:text-blue-400">Edit</a>
                                            {{-- @endif --}}
                                            @endcan
                                            
                                            <a href="{{ route('visits.detail', $visit->id) }}" class="hover:text-blue-400">Detail</a>

                                        </div>
                                    </td>
                                    {{-- @endif --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Belum ada data kunjungan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $visits->links() }}

                </div>
            </div>
        </div>
        


    </div>
    
</x-app-layout>
