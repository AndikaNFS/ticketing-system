

<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticketing') }}
        </h2>
    </x-slot> --}}
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}
            <div class="flex justify-between place-items-center bg-gray-700 border border-gray-600 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <div class="flex ">
                   <form method="GET" action="{{ route('dashboard') }}" class="">
                       <select name="status" id="status" onchange="this.form.submit()" class="text-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm w-full sm:w-auto px-8 py-2.5 dark:bg-gray-700 dark:text-white dark:focus:ring-blue-800" required>
                            <option value="">Filter Status</option>
                            <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="InProgress" {{ request('status') == 'InProgress' ? 'selected' : '' }}>InProgress</option>
                            <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                            <option value="Cancel" {{ request('status') == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                       </select>
                   </form>

                </div>
                <div class="">
                    
                </div>
                <div class=" flex place-content-end">

                <form class="flex items-center max-w-sm mx-auto px-5" method="GET" action="{{ route('dashboard') }}">   
                    {{-- <label for="simple-search" class="sr-only">Search</label> --}}
                    {{-- <input type="hidden" name="outlet_id" value="{{ $outlet_id }}"> --}}
                    
                    <div class="relative w-full">
                       <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2"/>
                          </svg>
                       </div>
                       <input type="text" id="simple-search" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Ticketing ID..." />
                    </div>
                    <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                       <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                       </svg>
                       <span class="sr-only">Search</span>
                    </button>
                 </form>
                 <a href="{{ route('tickets.create') }}">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Ticket</button>   
                 </a>
                   {{-- <div class="flex text-white   focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-s-md text-sm w-full sm:w-auto px-5  text-center dark:bg-gray-700  dark:focus:ring-blue-800">
                      <form action="#" method="POST" enctype="multipart/form-data" class="">
                         @csrf
                         <div class="flex items-center ">
                            <input type="file" name="file" class="w-full text-sm text-gray-300 border border-gray-600 h-11 content-center rounded-s-lg cursor-pointer bg-gray-600 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="large_size" type="file" required>
                            <button type="submit" class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-e-md text-sm w-full sm:w-auto px-3 py-3 text-center dark:bg-green-500 dark:hover:bg-green-700" >Import</button>
                         </div>
                      </form>
                      
                   </div> --}}
                </div>
            </div>
            
            {{-- <div class="flex justify-between place-items-center rounded bg-gray-400 items-center pr-6 px-6 py-1">
                <div class="flex justify-center">
                    <div class="grid items-center">
                        <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
                            <label for="status" class="text-sm font-medium text-gray-200">Filter Status:</label>
                            <select name="status" id="status" class="border p-2 rounded" onchange="this.form.submit()">
                                <option value="">-- Semua Status --</option>
                                <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                                <option value="OnProgress" {{ request('status') == 'OnProgress' ? 'selected' : '' }}>OnProgress</option>
                                <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                            </select>
                        </form>

                    </div>
                </div>
                <div class=" flex place-content-end">
                    <a href="{{ route('tickets.create') }}">
                       <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Ticket</button>   
                    </a>
                 </div>

                 
                </div> --}}
                
            <div class="relative overflow-x-auto overflow-y-auto max-h-96 shadow-md sm:rounded-lg mt-10">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase sticky top-0 z-10 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Ticketing ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Problem
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Outlet
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                IT Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date Finish
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Work Duration
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    @foreach ($tickets as $ticket )
                    <tbody>     
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                
                            
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $ticket->ticketing }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $ticket->problem }}
                                
                            </td>
                            <td class="px-6 py-4">
                                {{ $ticket->outlet }}
                                
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class=" px-2 py-1 rounded text-white
                                     {{ 
                                        $ticket->status == 'Open' ? 'bg-blue-500' : 
                                        ($ticket->status == 'InProgress' ? 'bg-yellow-500' : 
                                        ($ticket->status == 'Done' ? 'bg-green-500' : 'bg-red-500')) }}">
                                     {{ $ticket->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $ticket->it_name }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($ticket->date_finish)
                                 {{ $ticket->date_finish }}
                              @else
                                 <p>No date finish available</p>   
                              @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $ticket->lama_pengerjaan }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                <!-- Tambahkan Pagination -->
                {{-- <div class="mt-4">
                    {{ $tickets->links() }}
                </div> --}}
                
                {{ $tickets->links() }}
            </div>
        </div>
        


    </div>
    
</x-app-layout>
