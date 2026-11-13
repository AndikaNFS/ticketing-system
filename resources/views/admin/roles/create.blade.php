<x-app-layout>
    <h1>Tambah Role</h1>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <label>Nama Role:</label>
        <input type="text" name="name" required>
        <button type="submit">Simpan</button>
    </form>
</x-app-layout>