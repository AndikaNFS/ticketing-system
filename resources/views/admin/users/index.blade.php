<x-app-layout>
    <div class="container mx-auto px-4 py-6 mt-10">
        <h1 class="text-2xl text-center text-gray-800 dark:text-gray-50 font-bold mb-4">User List</h1>
        <div class="grid justify-end mb-10">
            {{-- <a href="{{ route('roles.create') }}"> --}}
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add User</button>   
             {{-- </a> --}}

        </div>
        {{-- <a href="{{ route('roles.create') }}">Add Role</a>     --}}
        <div class="overflow-auto flex justify-center">
            <table class="min-w-auto bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 dark:bg-gray-600 text-left text-sm font-semibold text-gray-600">
                        <tr class="text-black dark:text-gray-200 text-center">
                            <th class="px-4 py-3 ">Name</th>
                            <th class="px-4 py-3 w-28 ">Email</th>
                            <th class="px-4 py-3 w-28 ">Role</th>
                            
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        @foreach($users as $user)
                            <tr class="bg-white border-b dark:bg-gray-100 dark:hover:text-gray-50 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            
                                <td scope="" class="px-4 py-2 ">{{ $user->name }}</td>
                                <td scope="" class="px-4 py-2 ">{{ $user->email }}</td>
                                <td scope="" class="px-4 py-2 ">
                                    @if($user->roles->isEmpty())
                                        <em>Tidak ada role</em>
                                    @else
                                        {{ $user->roles->pluck('name')->join(', ') }}
                                    @endif
                                </td>
                                <td scope="" class="px-4 py-2 ">
                                    {{-- <a href="{{ route('users.edit', $user->id) }}" class="hover:text-blue-500">Edit</a> --}}
                                    
                                    <a href="{{ route('users.roles', $user->id) }}" class="hover:text-blue-500">Set Roles</a>
                                    
                                    {{-- <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus user ini?')" class="hover:text-blue-500">Hapus</button>
                                    </form> --}}

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
    {{-- <ul>
        @foreach($users as $user)
        <div class="bg-white">

            <li>
                {{ $user->name }}
                <a href="{{ route('users.permissions', $user->id) }}">Set Permissions</a>
                <a href="{{ route('users.roles', $user->id) }}">Set Roles</a>
                </form>
            </li>
        </div>
        @endforeach
    </ul> --}}
</x-app-layout>