<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-2xl text-center text-gray-800 dark:text-gray-50 font-bold mb-4">Atur Role untuk {{ $user->name }}</h1>
        <div class=" bg-white rounded flex justify-center m-10">

            <form method="POST" action="{{ route('users.roles.update', $user->id) }}">
                @csrf @method('PUT')

                @foreach($roles as $role)
                
                
                    
                        <div class=" ">
                            <label>
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                    {{ in_array($role->name, $userRoles) ? 'checked' : '' }}>
                                {{ $role->name }}
                            </label>

                        </div>
                        @endforeach
                    
                    <button type="submit" class="">Simpan Role</button>
                </form>
            </div>
    </div>
</x-app-layout>