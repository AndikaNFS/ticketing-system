<x-app-layout>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class=" mt-5">
            <a href="{{ route('dashboard') }}" class="text-white bg-gray-500 py-1 px-5 text-lg m-10 rounded dark:bg-gray-400 dark:text-gray-700">Back</a>
    
            </div>



        
<form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="max-w-md mx-auto mt-10">
    @csrf
    @method('PUT')
    <div class="mb-6">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ticketing ID</label>
        <input value="{{ $ticket->ticketing }}" type="text" name="ticketing" id="ticketing" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required />
    </div> 
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Problem</label>
            <input value="{{ $ticket->problem }}" type="text" name="problem" id="problem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required />
        </div>
        <div>
            <label for="problem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Outlet</label>
            <input value="{{ $ticket->outlet }}" type="text" name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required />
        </div>
        <div>
            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
            {{-- <input value="{{ $ticket->outlet }}" type="text" name="outlet" id="outlet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=" " required /> --}}
            <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        onchange="this.form.submit()"
                        >
                            <option value="Open" {{ old('status', $ticket->status) == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="OnProgress" {{ old('status', $ticket->status) == 'OnProgress' ? 'selected' : '' }}>OnProgress</option>
                            <option value="Done" {{ old('status', $ticket->status) == 'Done' ? 'selected' : '' }}>Done</option>
                            <option value="Cancel" {{ old('status', $ticket->status) == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                        </select>
        </div>  
        <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IT Name</label>
            {{-- <input type="tel" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required /> --}}
            <select id="it_name" name="it_name" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                 
                        {{-- <option value="Andika" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Andika') ? 'selected' : '' }}>Andika</option>
                        <option value="Usman" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Usman') ? 'selected' : '' }}>Usman</option>
                        <option value="Asep" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Asep') ? 'selected' : '' }}>Asep</option>
                        <option value="Santo" {{ (session('edit_step_'.$ticket->id) > 1 && $ticket->it_name == 'Santo') ? 'selected' : '' }}>Santo</option> --}}
                        <option value="Andika" {{  old('it_name', $ticket->it_name == 'Andika' ? 'selected' : '') }}>Andika</option>
                        <option value="Usman" {{  old('it_name', $ticket->it_name) == 'Usman' ? 'selected' : '' }}>Usman</option>
                        <option value="Asep" {{  old('it_name', $ticket->it_name) == 'Asep' ? 'selected' : '' }}>Asep</option>
                        <option value="Santo" {{  old('it_name', $ticket->it_name) == 'Santo' ? 'selected' : '' }}>Santo</option>
                    </select>
        </div>
        <div>
            @if (in_array (old('status', $ticket->status), ['Done', 'Cancel']))
            <label for="date_finish" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date Finish</label>
            {{-- <input type="url" id="website" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="flowbite.com" required /> --}}
                    <label for="date_finish" class="peer-focus:font-medium absolute text-sm text-gray-800 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date Finish</label>
                    <input type="date" 
                        value="{{ old('date_finish', $ticket->date_finish)}}"  
                        name="date_finish" 
                        id="date_finish" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder=" "
                        {{-- required="{{ request()->status == 'Done' ? 'required' : '' }}"  --}}
                        required
                    />
                    @endif
        </div>
    </div>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
</form>

</x-app-layout>