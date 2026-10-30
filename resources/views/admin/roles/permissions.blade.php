<x-app-layout>
    <h1>Permission untuk Role: {{ $role->name }}</h1>

    <form method="POST" action="{{ route('roles.permissions.update', $role->id) }}">
        @csrf @method('PUT')

        @foreach($permissions as $permission)
            <div class="bg-white">
                <label>
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                        {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                    {{ $permission->name }}
                </label>
            </div>
        @endforeach

        <button type="submit">Simpan Permissions</button>
    </form>
</x-app-layout>