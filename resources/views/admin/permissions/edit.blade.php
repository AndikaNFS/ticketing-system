<x-app-layout>
    <h1>Edit Permission</h1>

    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf @method('PUT')
        <label>Nama Permission:</label>
        <input type="text" name="name" value="{{ $permission->name }}" required>
        <button type="submit">Update</button>
    </form>
</x-app-layout>