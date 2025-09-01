<x-app-layout>
    {{-- <h1>Daftar Role</h1>
    <a href="{{ route('roles.create') }}">+ Tambah Role</a> --}}

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

        {{-- @foreach($roles as $role) --}}
        <div class="container mx-auto px-4 py-6 mt-10">
            <h1 class="text-2xl text-center text-gray-800 dark:text-gray-50 font-bold mb-4">Role List</h1>
            <div class="grid justify-end mb-10">
                <a href="{{ route('roles.create') }}">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Role</button>   
                 </a>

            </div>
            {{-- <a href="{{ route('roles.create') }}">Add Role</a>     --}}
            <div class="overflow-auto flex justify-center">
                <table class="min-w-auto bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600">
                            <tr class="text-black dark:text-gray-200 text-center">
                                <th class="px-4 py-3 ">Name</th>
                                <th class="px-4 py-3 w-28 "></th>
                                
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            @foreach($roles as $role)
                                <tr class="bg-white border-b dark:bg-gray-100 dark:hover:text-gray-50 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                
                                    <td scope="" class="px-4 py-2 ">{{ $role->name }}</td>
                                    <td scope="" class="px-4 py-2 "></td>
                                    <td scope="" class="px-4 py-2 ">
                                        <a href="{{ route('roles.edit', $role->id) }}" class="hover:text-blue-500">Edit</a>
                                        |
                                        <a href="{{ route('roles.permissions', $role->id) }}" class="hover:text-blue-500">Set Permissions</a>
                                        |
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus role ini?')" class="hover:text-blue-500">Hapus</button>
                                        </form>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
</x-app-layout>