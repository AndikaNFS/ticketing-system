<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <h1 class="text-gray-800 dark:text-gray-100 text-3xl m-5 max-w-md mx-auto text-center">Area Outlet</h1>
            <div class="flex place-content-end">
                    @if (auth()->user()->hasRole('admin|superadmin'))
                    
                        
                    <a href="{{ route('outlets.create') }}">
                       <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Area</button>   
                    </a>

                    @endif
    
                </div>


            <div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg mt-10" style="max-height:30em;">
                
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase sticky top-0 z-10 dark:text-gray-400">
                            <tr class="bg-gray-100 dark:bg-gray-800">
                                <th scope="col" class="px-6 py-3 ">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    IT Name
                                </th>
                                <th scope="col" class="px-6 py-3 ">
                                    Outlet
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Area
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    PIC
                                </th>
                                @if (auth()->user()->hasRole('admin|superadmin'))

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
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    @if (isset($outlet->employee->name))
                                        {{ $outlet->employee->name }}
                                    @else
                                        <p class="text-gray-400">Belum Ada</p>
                                    @endif
                                </td>
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
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{-- @foreach ( $areas as area ) --}}
                                    {{ $outlet->pic }}
                                        
                                    {{-- @endforeach --}}
                                    
                                </td>
                                @if (auth()->user()->hasRole('admin|superadmin'))

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