<x-app-layout>

    <div class=" grid grid-cols-3 items-center">
        <div class="relative p-3 ">
            <a href="{{ route('schedulebuilds.index') }}" class="text-white p-3 text-lg m-10 rounded-full  dark:text-gray-700 max-w-min ">
                <svg class="w-6 h-6 text-gray-800 absolute inset-y-0 left-2 top-3 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                </svg>
    
            </a>

        </div>

        <h1 class="text-gray-800  dark:text-gray-100 text-xl md:text-3xl m-5 max-w-md mx-auto text-center sm:text-black">Employee Schedule Editor</h1>
        <div class=" pe-1 px-5">
            {{-- <span>aaa</span> --}}
        </div>
    </div>

{{-- <div class=" mt-5">
    <a href="{{ route('schedules.index') }}" class="text-white bg-gray-500 py-1 px-5 text-lg m-10 rounded dark:bg-gray-400 dark:text-gray-700">Back</a>

</div> --}}

<div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Input Schedule: {{ $employee->name }}</h2>

    <form action="{{ url('/building/schedules/' . $employee->id . '/store?start_date=' . request('start_date')) }}" method="POST">

        @csrf

        <table class="w-full table-auto text-sm border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Dates</th>
                    <th class="border px-2 py-1">Days</th>
                    <th class="border px-2 py-1">Status</th>
                    <th class="border px-2 py-1">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dates as $date)
                    @php
                        $schedule = $existing[$date->toDateString()] ?? null;
                    @endphp
                    <tr>
                        <td class="border px-2 py-1">{{ $date->format('Y-m-d') }}</td>
                        <td class="border px-2 py-1">{{ $date->translatedFormat('l') }}</td>
                        <td class="border px-2 py-1">
                            <select name="schedulebuildings[{{ $date->toDateString() }}][status]" class="w-full border px-1 py-1 rounded">
                                @foreach(['Work', 'Off', 'Libur Nasional'] as $option)
                                    <option value="{{ $option }}" {{ $schedule && $schedule->status === $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="border px-2 py-1">
                            <input type="text" name="schedulebuildings[{{ $date->toDateString() }}][remarks]" value="{{ $schedule->remarks ?? '' }}" class="w-full border px-1 py-1 rounded">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Schedule</button>
        </div>
    </form>
</div>



</x-app-layout>