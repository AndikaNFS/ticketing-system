<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <h1 class="text-gray-800 dark:text-gray-100 text-3xl m-5 max-w-md mx-auto text-center">Area Outlet</h1>
            <div class="flex place-content-end">
                    @if (auth()->user()->hasRole('admin|superadmin'))
                    
                        
                    <button data-modal-target="add-modal" data-modal-toggle="add-modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 mr-4 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Count</button>   
                    <a href="{{ route('outlets.create') }}">
                       <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Area</button>   
                    </a>
                    
                    @endif
                    <div id="add-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        @include('outlets.count')
                    </div>
    
                </div>


            <div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg mt-10" style="max-height:30em;">
                <!-- <table class=" text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead> 
                        <tr class="bg-gray-100 dark:bg-gray-800">
                            <th scope="col" class="px-6 py-3">Area</th>
                            <th scope="col" class="px-6 py-3">IT Name</th>
                            <th scope="col" class="px-6 py-3">Total Outlet</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($countOutlets as $count)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $count->area}}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $count->employee->name ?? 'Belum ada'}}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $count->total}}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table> -->
                <!-- <button data-modal-target="add-modal" data-modal-toggle="add-modal" class="block text-white w-full ml-3 sm:w-auto bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-2.5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                            </svg>
                        </button> -->
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase sticky top-0 z-10 dark:text-gray-400">
                            <tr class="bg-gray-100 dark:bg-gray-800">   
                                <th scope="col" class="px-6 py-3 ">
                                    No
                                </th>
                                @if (auth()->user()->hasRole('admin|superadmin'))
                                <th scope="col" class="px-6 py-3">
                                    IT Name
                                </th>
                                @endif
                                <th scope="col" class="px-6 py-3 ">
                                    Outlet
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Area
                                </th>

                                @if (auth()->user()->hasRole('admin|superadmin'))
                                <th scope="col" class="px-6 py-3">
                                    PIC
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    
                                </th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($outlets as $outlet)
                                
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    {{ $outlet->id }}
                                </th>

                                @if (auth()->user()->hasRole('admin|superadmin'))
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    @if (isset($outlet->employee->name))
                                        {{ $outlet->employee->name }}
                                    @else
                                        <p class="text-gray-400">Belum Ada</p>
                                    @endif
                                </td>
                                @endif

                                <td class="px-6 py-4 text-gray-900 bg-gray-50 dark:bg-gray-800 dark:text-white">
                                    {{-- @foreach ($outlets as $outlet) --}}
                                    {{ $outlet->name }}
                                        
                                    {{-- @endforeach --}}
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{-- @foreach ( $areas as area ) --}}
                                    {{ $outlet->area }}
                                        
                                    {{-- @endforeach --}}
                                    
                                </td>

                                @if (auth()->user()->hasRole('admin|superadmin'))
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{-- @foreach ( $areas as area ) --}}
                                    {{ $outlet->pic }}
                                        
                                    {{-- @endforeach --}}
                                    
                                </td>
                                <td>
                                    <a href="{{ route('outlets.edit', $outlet->id) }}" class="hover:text-blue-400">Edit</a>

                                </td>
                                @endif
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                
            </div>
        </div>
        


    </div>
</x-app-layout>