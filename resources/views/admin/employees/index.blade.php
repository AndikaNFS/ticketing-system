<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl text-center text-gray-800 dark:text-gray-50 font-bold mb-4">Employees List</h1>
        
        <div class="grid lg:grid-cols-2 gap-2 sm:grid-cols-1">
            {{-- IT --}}
            <div class=" bg-gray-600 rounded-xl p-4">
                <div class="flex justify-between mb-10">
                    <h1 class=" text-2xl font-extrabold text-gray-200">Employee IT Support</h1>
                    @if (auth()->user()->hasRole('admin|superadmin'))
                    {{-- <a href="#"> --}}
                        <button type="button" data-modal-target="add-it-modal" data-modal-toggle="add-it-modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>   
                     {{-- </a> --}}
                        
                    @endif
        
                </div>
        
                {{-- Main Modal --}}
                
                <div id="add-it-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            
                    @include('admin.employees.it.create')
                </div>
                
                <div class="flex justify-center ">
                    
                    <div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg max-w-min" style="max-height:30em;">
                        <table class="w-auto bg-white border border-gray-200 rounded-lg overflow">
                            <thead class="bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold uppercase sticky top-0 z-10 text-gray-600">
                                    <tr class="text-black dark:text-gray-200 text-center">
                                        <th class="px-4 py-3 ">Name</th>
                                        <th class="px-4 py-3 w-28 ">Position</th>
                                        {{-- <th class="px-4 py-3 w-28 ">Role</th> --}}
                                        
                                        <th class="px-4 py-3">Action</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    @foreach($employeeit as $it)
                                        <tr class="bg-white border-b dark:bg-gray-100 dark:hover:text-gray-50 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        
                                            <td scope="" class="px-4 py-2 ">{{ $it->name }}</td>
                                            <td scope="" class="px-4 py-2 ">{{ $it->position }}</td>
                                            <td scope="" class="px-4 py-2 ">
                                                <a href="{{ route('employees.it.edit', $it->id) }}" class="hover:text-blue-500">Edit</a>
                                                {{-- <button type="button" data-modal-target="edit-it-modal" data-modal-toggle="edit-it-modal" >Edit</button> --}}
                                                {{-- <a href="{{ route('users.roles', $user->id) }}" class="hover:text-blue-500">Set Roles</a>AA --}}
                                                
                                                {{-- <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Hapus user ini?')" class="hover:text-blue-500">Hapus</button>
                                                </form> --}}
            
                                            </td>
                                            <td class="px-4 py-2 ">
                                                <form action="{{ route('employees.it.toggle', $it->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    {{-- <label class="inline-flex items-center cursor-pointer"> --}}
                                                    <input type="checkbox"
                                                        onchange="this.form.submit()"
                                                        {{ $it->is_active ? 'checked' : '' }}>

                                                    {{-- <button type="submit" class="px-3 py-1 rounded {{ $it->is_active ? 'bg-green-500' : 'bg-red-500' }} text-white">
                                                        {{ $it->is_active ? 'ON' : 'OFF' }}
                                                    </button> --}}
                                                </form>
                                            </td>
            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
        
                </div>
    
            </div>
    
    
            {{-- Build --}}
            <div class="bg-gray-600 rounded-xl p-4">
                <div class="flex justify-between mb-10">
                    <h1 class=" text-2xl font-extrabold text-gray-200">Employee Building</h1>
                    @if (auth()->user()->hasRole('admin|superadmin'))
                    {{-- <a href="#"> --}}
                        <button type="button" data-modal-target="add-build-modal" data-modal-toggle="add-build-modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>   
                     {{-- </a> --}}
                        
                    @endif
        
                </div>
        
                {{-- Main Modal --}}
                <div id="add-build-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            
                    @include('admin.employees.build.create')
                </div>
                <div class="flex justify-center">
                    <div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg max-w-min" style="max-height:30em;">
                        <table class="min-w-auto bg-white border border-gray-200 rounded-lg overflow">
                            <thead class="bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold uppercase sticky top-0 z-10 text-gray-600">
                                    <tr class="text-black dark:text-gray-200 text-center">
                                        <th class="px-4 py-3 ">Name</th>
                                        <th class="px-4 py-3 w-38 ">Position</th>
                                        
                                        <th class="px-4 py-3">Action</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    @foreach($employeebuild as $build)
                                        <tr class="bg-white border-b dark:bg-gray-100 dark:hover:text-gray-50 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        
                                            <td scope="" class="px-4 py-2 ">{{ $build->name }}</td>
                                            <td scope="" class="px-4 py-2 ">{{ $build->position }}</td>
                                            
                                            <td scope="" class="px-4 py-2 ">
                                                <a href="{{ route('employees.build.edit', $build->id) }}" class="hover:text-blue-500">Edit</a>
                                                
            
                                            </td>
                                            <td class="px-4 py-2 ">
                                                <form action="{{ route('employees.build.toggle', $build->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    {{-- <label class="inline-flex items-center cursor-pointer"> --}}
                                                    <input type="checkbox"
                                                        onchange="this.form.submit()"
                                                        {{ $build->is_active ? 'checked' : '' }}>

                                                    {{-- <button type="submit" class="px-3 py-1 rounded {{ $it->is_active ? 'bg-green-500' : 'bg-red-500' }} text-white">
                                                        {{ $it->is_active ? 'ON' : 'OFF' }}
                                                    </button> --}}
                                                </form>
                                            </td>
            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
        
                </div>
    
            </div>

        </div>
    </div>
</x-app-layout>