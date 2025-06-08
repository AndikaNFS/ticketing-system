

<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticketing') }}
        </h2>
    </x-slot> --}}

    {{-- @hasanyrole(['admin', 'manager'])
        <p>Welcome admin or manager!</p>
    @endhasanyrole --}}


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between place-items-center bg-gray-700 border border-gray-600 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <div class="flex pr-2">
                   <form method="GET" action="{{ route('building.tickets.index') }}" class="">
                       <select name="status" id="status" onchange="this.form.submit()" class="text-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm w-full sm:w-auto px-8 py-2.5 dark:bg-gray-700 dark:text-white dark:focus:ring-blue-800" required>
                            <option value="">Filter Status</option>
                            <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="InProgress" {{ request('status') == 'InProgress' ? 'selected' : '' }}>InProgress</option>
                            <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                            <option value="Cancel" {{ request('status') == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                       </select>
                   </form>

                </div>
                <div class=" flex place-content-end">

                <form class="flex items-center max-w-sm mx-auto px-5" method="GET" action="{{ route('building.tickets.index') }}">   
                  
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
                </div>
            </div>
            <div class="flex justify-between">
                <div class="relative z-20">
                    
                    {{-- <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Export <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a href="{{ route('ticket.export.excel') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Excel</a>
                        </li>
                        <li>
                            <a href="{{ route('ticket.export.pdf') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">PDF</a>
                        </li>
                        </ul>
                    </div> --}}

                </div>
                <div class="flex place-content-end">
                    @if (auth()->user()->hasRole('admin|superadmin|building'))
                    
                    <div class="relative z-20 mr-5">
                    
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdownBuilding" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Vendor & PIC <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownBuilding" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a href="{{ route('building.vendors.index') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Vendor</a>
                        </li>
                        <li>
                            <a href="{{ route('building.pics.index') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">PIC</a>
                        </li>
                        </ul>
                    </div>

                </div>

                    <a href="{{ route('building.tickets.create') }}">
                       <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Ticket</button>   
                    </a>

                    @endif
    
                </div>
            </div>
                
            <div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg mt-10" style="max-height:30em;">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase sticky top-0 z-10 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Ticketing ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Outlet
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Problem
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Vendor
                            </th>
                            <th scope="col" class="px-6 py-3">
                                PIC
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date Start
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date Finish
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Work Duration
                            </th>
                            {{-- <th scope="col" class="px-6 py-3">
                                Description
                            </th> --}}
                            {{-- <th scope="col" class="px-6 py-3">
                                Description
                            </th> --}}
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    @foreach ($buildings as $building )
                    <tbody>     
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                
                            
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $building->ticketing }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $building->problem }}
                                
                            </td>
                            <td class="px-6 py-4">
                                {{ $building->outlet->name }}
                                
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class=" px-2 py-1 rounded text-white
                                     {{ 
                                        $building->status == 'Open' ? 'bg-blue-500' : 
                                        ($building->status == 'InProgress' ? 'bg-yellow-500' : 
                                        ($building->status == 'Done' ? 'bg-green-500' : 'bg-red-500')) }}">
                                     {{ $building->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if (isset( $building->vendor->name))
                                {{ $building->vendor->name }}
                                    
                                @else
                                    <p>No Vendor</p>   
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if (isset ($building->pic->name))
                                {{ $building->pic->name }}
                                @else
                                <p>No PIC</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($building->start_date)
                                     {{ $building->start_date }}
                                @else
                                    <p>No date start available</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($building->date_finish)
                                 {{ $building->date_finish }}
                              @else
                                 <p>No date finish available</p>   
                              @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $building->work_duration }}
                            </td>
                            {{-- <td class="px-6 py-4">
                                {{ $building->description }}
                            </td> --}}
                            
                            <td class="px-6 py-4 text-right">
                                
                                <div class="flex space-x-4">
                                    {{-- @can('detail ticket') --}}
                                    {{-- @can('edit ticket') --}}
                                    <a href="{{ route('building.tickets.detail', $building->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detail</a>
                                    @if (auth()->user()->hasRole('admin|superadmin|building'))
                                    {{-- @endcan --}}
                                    <a href="{{ route('building.tickets.edit', $building->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    
                                    {{-- @endcan --}}
                                    @endif
                                </div>
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                <!-- Tambahkan Pagination -->
                {{-- <div class="mt-4">
                    {{ $buildings->links() }}
                </div> --}}
                
                {{ $buildings->links() }}
            </div>
        </div>
        


    </div>
    
</x-app-layout>
