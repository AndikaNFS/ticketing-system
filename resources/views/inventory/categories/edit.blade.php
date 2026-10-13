<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Edit Category
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <form action="{{ route('categories.update', $category) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-5">

                            <label for="name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Name Category
                            </label>

                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $category->name) }}"
                                   required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                            @error('name')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <div class="mb-5">

                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Description
                            </label>

                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('description', $category->description) }}</textarea>

                            @error('description')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <div class="flex justify-end gap-2">

                            <a href="{{ route('categories.index') }}"
                               class="px-4 py-2 text-sm font-medium text-gray-900 bg-gray-200 rounded-lg hover:bg-gray-300">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                Update
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>