<x-app-layout>
    <h1>Edit Role</h1>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf @method('PUT')
        <label>Nama Role:</label>
        <input type="text" name="name" value="{{ $role->name }}" required>
        <button type="submit">Update</button>
    </form>
</x-app-layout>