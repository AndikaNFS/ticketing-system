<x-app-layout>
    <h1>Tambah Permission</h1>

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <label>Nama Permission:</label>
        <input type="text" name="name" required>
        <button type="submit">Simpan</button>
    </form>
</x-app-layout>