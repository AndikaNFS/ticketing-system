<x-app-layout>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class=" mt-5">
        <a href="{{ route('building.vendors.index') }}" class="text-black py-1 px-5 text-lg m-10 rounded bg-gray-400">Back</a>

        </div>

        <div class="grid w-full mt-10">
            <h2 class="flex justify-center font-semibold text-3xl items-center text-gray-800 dark:text-white leading-tight">
                Form Tambah Vendor
            </h2>

        </div>

        <form action="{{ route('building.vendors.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto mt-10">
            @csrf 
            <input type="hidden" value="{{ $user->name }}" name="user" id="user">
            <div class="relative z-0 w-full mb-10 group">
                <input type="text" name="name" id="name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="name" class="peer-focus:font-medium absolute text-sm  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
            </div>
            <div class="relative z-0 w-full mb-10 group">
                <input type="text" name="alamat" id="alamat" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                <label for="alamat" class="peer-focus:font-medium absolute text-sm  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="no_telp" id="no_telp" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                <label for="no_telp" class="peer-focus:font-medium absolute text-sm  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No Telp</label>
            </div>
            {{-- <div class="relative z-0 w-full mb-5 group mt-10">
                <label for="outlet" class="peer-focus:font-medium absolute text-xl  text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label>
                @error('outlet')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <select id="outlet" name="outlet" class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option selected>Pilih Lokasi</option>
                    @foreach ($outlets as $outlet)
                        <option value="{{ $outlet->name }}">{{ $outlet->name }}</option>
                    @endforeach 
                </select>
            </div> --}}
            <div class="grid md:grid-cols-2 md:gap-6">
              
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
</x-app-layout>