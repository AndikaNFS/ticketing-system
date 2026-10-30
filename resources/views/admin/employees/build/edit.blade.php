<x-app-layout>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class=" grid grid-cols-3 items-center">
        <div class="relative p-3 ">
            <a href="{{ route('employees.index') }}" class="text-white p-3 text-lg m-10 rounded-full  dark:text-gray-700 max-w-min ">
                <svg class="w-6 h-6 text-gray-800 absolute inset-y-0 left-2 top-3 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                </svg>
    
            </a>

        </div>

        <h1 class="text-gray-800  dark:text-gray-100 text-xl md:text-3xl m-5 max-w-md mx-auto text-center">Form Edit Employee Building</h1>
        <div class=" pe-1 px-5">
        </div>
    </div>

    <form action="{{ route('employees.build.update', $employeebuild->id) }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto mt-10 p-3">
        @csrf
        @method('PUT')

    <div class="mb-5 mt-5">
        
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
        <input type="text" name="name" id="name" value=" {{ old('name', $employeebuild->name ) }}"
            class="w-full text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."
        ></input>
    </div>
    <div class="mb-5 mt-5">
        
        <label for="position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position</label>
        <input type="text" name="position" id="position" value=" {{ old('position', $employeebuild->position ) }}"
            class="w-full text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."
        ></input>
    </div>
    <div class="mb-5 mt-5">
        
        <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" value=" {{ old('phone_number', $employeebuild->phone_number ) }}"
            class="w-full text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="628123456789"
        ></input>
    </div>
    <div class="mb-5 mt-5">
        
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">email</label>
        <input type="email" name="email" id="email" value=" {{ old('email', $employeebuild->email ) }}"
            class="w-full text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="example@gmail.com"
        ></input>
    </div>
    <div class="mb-5 mt-5">
        
        {{-- <label for="is_active" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">is_active</label> --}}
        <input type="hidden" name="is_active" id="is_active" value=" {{ old('is_active', $employeebuild->is_active ) }}"
            class="w-full text-gray-900 bg-gray-300 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."
        ></input>
    </div>
    {{-- @endforeach --}}
    
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mb-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>

    
</x-app-layout>

