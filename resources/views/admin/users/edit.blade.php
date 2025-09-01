<x-app-layout>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf @method('PUT')
    
        <h4>{{ $user->name }}</h4>
    
        @foreach ($roles as $role)
            <div>
                <label>
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                        {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                    {{ $role->name }}
                </label>
            </div>
        @endforeach
    
        <button type="submit">Simpan</button>
    </form>
</x-app-layout>