<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex place-content-end">
                    @if (auth()->user()->hasRole('admin|superadmin|building'))
                    
                        
                    <a href="{{ route('building.pics.create') }}">
                       <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add PIC</button>   
                    </a>

                    @endif
    
                </div>

        <div class="grid w-full mt-10">
            <h2 class="flex justify-center font-semibold text-3xl items-center text-gray-800 dark:text-white leading-tight">
                List PIC
            </h2>

        </div>
            <div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg mt-10" style="max-height:30em;">
                
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                            <tr class="bg-gray-100 dark:bg-gray-800">
                                <th scope="col" class="px-6 py-3 ">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 ">
                                    No Telp
                                </th>
                                <th scope="col" class="px-6 py-3 ">
                                    Action
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pics as $pic)
                                
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    {{ $pic->id }}
                                </th>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $pic->name }}
                                    
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $pic->no_telp }}
                                    
                                </td>
                                <td>
                                            <a href="{{ route('building.pics.edit', $pic->id) }}" class="hover:text-blue-400">Edit</a>

                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                
            </div>
        </div>
        


    </div>
</x-app-layout>