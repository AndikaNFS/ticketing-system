<x-app-layout>
    <h1>Permission untuk User: {{ $user->name }}</h1>

    <form method="POST" action="{{ route('users.permissions.update', $user->id) }}" class="bg-white">
        @csrf @method('PUT')

        @foreach($permissions as $permission)
            <div>
                <label>
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                        {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>
                    {{ $permission->name }}
                </label>
            </div>
        @endforeach

        <button type="submit">Simpan Permissions</button>
    </form>
</x-app-layout>