

<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticketing') }}
        </h2>
    </x-slot> --}}
    

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if (auth()->user()->hasRole('admin|superadmin|building|maintenance|maintenance1'))

            <div class="flex justify-between place-items-center bg-gray-700 border border-gray-600 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <div class="flex ">

                </div>
                <div class="">
                    
                </div>
                <div class=" flex place-content-end">


                    <a href="{{ route('building.visits.create') }}">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Schedule</button>   
                    </a>
                </div>
            </div>
            @endif
                
            <div class="container mx-auto px-4 py-6">
                {{-- <h1 class="text-2xl text-center text-gray-800 dark:text-gray-50 font-bold mb-4">Visit List</h1> --}}
            
                {{-- <a href="{{ route('visits.create') }}" class="mb-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Kunjungan</a> --}}
            
                <div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg mt-5" style="max-height:30em;">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg ">
                        <thead class="bg-gray-100 dark:bg-gray-600 uppercase sticky top-0 z-10 text-left text-sm font-semibold text-gray-600">
                            <tr class="text-black dark:text-gray-200">
                                {{-- <th class="px-4 py-3">#</th> --}}
                                <th class="px-4 py-3 ">PIC</th>
                                <th class="px-4 py-3">Visit Date</th>
                                <th class="px-4 py-3">Outlet</th>
                                <th class="px-4 py-3">Ticket</th>
                                <th class="px-4 py-3">Job Desk</th>
                                <th class="px-4 py-3">Status</th>
                                @if (auth()->user()->hasRole('admin|superadmin|building|maintenance|maintenance1'))
                                
                                    <th class="px-4 py-3">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            @forelse ($visits as $visit)
                                <tr class="bg-white border-b  h-14 dark:bg-gray-100 dark:hover:text-gray-50 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                
                                    {{-- <td class="px-4 py-2">{{ $loop->iteration }}</td> --}}
                                    <td scope="" class="px-4 py-2 ">{{ $visit->employeebuild }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($visit->tanggal_visit)->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2">{{ $visit->outlet->name }}</td>
                                    <td class="px-4 py-2">
                                        @if (isset($visit->building->ticketing))
                                        {{ $visit->building->ticketing }}
                                        @else
                                        <p class="text-gray-400">No Ticketing</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        {{-- @if (isset($visit->description)) --}}
                                        <div class="hover:overflow-auto overflow-hidden">
                                            {{-- <div class="mr-1 flex place-items-center"> --}}
                                                {{-- @foreach ($visit as $visit) --}}
                                                {{ $visit->jobdesk }}
                                                    
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
                                     @if (auth()->user()->hasRole('admin|superadmin|maintenance|maintenance1'))

                                    <td class="px-4 py-2">
                                        @can('edit visit')
                                            <a href="{{ route('building.visits.edit', $visit->id) }}" class="hover:text-blue-400">Edit</a>
                                            |
                                        @endcan
                                        <a href="{{ route('building.visits.detail', $visit->id) }}" class="hover:text-blue-400">Detail</a>
                                    </td>
                                    @endif
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
