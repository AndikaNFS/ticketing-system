<x-app-layout>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class=" grid grid-cols-3 items-center">
        <div class="relative p-3 ">
            <a href="{{ route('outlets.index') }}" class="text-white p-3 text-lg m-10 rounded-full  dark:text-gray-700 max-w-min ">
                <svg class="w-6 h-6 text-gray-800 absolute inset-y-0 left-2 top-3 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                </svg>
    
            </a>

        </div>

        <h1 class="text-gray-800  dark:text-gray-100 text-xl md:text-3xl m-5 max-w-md mx-auto text-center">Edit Outlet</h1>
        <div class=" pe-1 px-5">
            {{-- <span>aaa</span> --}}
        </div>
    </div>

    {{-- <div class=" mt-5">
    <a href="{{ route('outlets.index') }}" class="text-black py-1 px-5 text-lg m-10 rounded bg-gray-400">Back</a>

    </div>

    <div class="grid w-full mt-10">
        <h2 class="flex justify-center font-semibold text-3xl items-center text-gray-800 dark:text-white leading-tight">
            Area Form
            {{ $outlet->name }}
        </h2>

    </div> --}}

    <form action="{{ isset($outlets) ? route('outlets.update', $outlets->id) : route('outlets.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto mt-10">
        @csrf
        @method('PUT')
        <div class="relative z-0 w-full mb-5 group">
            <div>
                <label for="employee_id" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">IT Name</label>
               <select id="employee_id" name="employee_id" 
                        class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                        >
                 
                        {{-- <option value="All" {{  old('employee_id', $employee->id == 'All' ? 'selected' : '') }}>All</option> --}}
                        @if ($specialEmployee)
                            <option value="{{ $specialEmployee->id }}">{{ $specialEmployee->name }}</option>
                        @endif
                        @foreach ($employees as $employee )
                            @if (!$specialEmployee || $employee->id != $specialEmployee->id)
                                
                            <option value="{{ $employee->id }}" {{ $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                            @endif
                            
                        @endforeach
                    </select>
               {{-- <select id="pic" name="pic" 
                        class="block py-2.5 px-0 w-full text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                        >
                 
                        <option class="text-black" value="Santo" >Santo</option>
                    </select> --}}

                    {{-- @php
                        $defaultEmployee = \App\Models\Employee::find(1);
                    @endphp --}}
                    <input type="hidden" name="pic" id="pic" value= "{{ old('pic', 'Santo') }}">
            </div>
        </div>
        <div class="relative z-0 w-full mb-5 group mt-10">
            <div class="relative z-0 w-full mb-5 group mt-10">
                  {{-- <input type="hidden" value=" " name="it_name" id="it_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                  <label for="name" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Outlet</label>
                  <input type="text" name="name" id="name" value="{{ old('name', $outlets->name)  }}" required class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                  {{-- <label for="it_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label> --}}
              </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
            
                <div class="relative z-0 w-full mb-5 group">
                 <div class="relative z-0 w-full mb-5 group mt-10">
                  {{-- <input type="hidden" value=" " name="it_name" id="it_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required /> --}}
                  <label for="area" class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Area</label>
                  <input type="text" name="area" id="area" value="{{ old('area', $outlets->area)  }}" required class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-600 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                  {{-- <label for="it_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Outlet</label> --}}
              </div>
                </div>
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>
    
    
</x-app-layout>
    {{-- <script>
    const employeeSelect = document.getElementById('employee_id');
    const picInput = document.getElementById('pic');

    function setPicFromSelectedOption() {
        const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
        picInput.value = selectedOption.text;
    }

    employeeSelect.addEventListener('change', setPicFromSelectedOption);

    // 🛠 Set default saat pertama kali halaman dibuka
    window.addEventListener('DOMContentLoaded', setPicFromSelectedOption);
</script> --}}

