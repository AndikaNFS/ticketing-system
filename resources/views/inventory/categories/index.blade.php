<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                    Kategori Inventaris
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Kelola kategori perangkat IT
                </p>
            </div>

            <a href="{{ route('categories.create') }}"
               class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                + Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert --}}
            @if (session('success'))
                <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">
                                        No
                                    </th>

                                    <th class="px-6 py-3">
                                        Nama
                                    </th>

                                    <th class="px-6 py-3">
                                        Description
                                    </th>

                                    <th class="px-6 py-3">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($categories as $category)

                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                        <td class="px-6 py-4">
                                            {{ $categories->firstItem() + $loop->index }}
                                        </td>

                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $category->name }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $category->description ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">

                                            @if ($category->is_active)

                                                <span class="px-2.5 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                                    Active
                                                </span>

                                            @else

                                                <span class="px-2.5 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">
                                                    Inactive
                                                </span>

                                            @endif

                                        </td>

                                        <td class="px-6 py-4">

                                            <div class="flex justify-center gap-2">

                                                <a href="{{ route('categories.edit', $category) }}"
                                                   class="px-3 py-2 text-xs font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600">
                                                    Edit
                                                </a>

                                                <form action="{{ route('categories.toggle-status', $category) }}"
                                                      method="POST">

                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit"
                                                            class="px-3 py-2 text-xs font-medium text-white {{ $category->is_active ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700' }} rounded-lg">

                                                        {{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }}

                                                    </button>

                                                </form>

                                                @if (!$category->inventories()->exists())

                                                    <form action="{{ route('categories.destroy', $category) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                                                            Hapus
                                                        </button>

                                                    </form>

                                                @endif

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-8 text-center text-gray-500">
                                            Belum ada kategori.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>