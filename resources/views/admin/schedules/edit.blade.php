<x-app-layout>

<div class=" mt-5">
    <a href="{{ route('schedules.index') }}" class="text-white bg-gray-500 py-1 px-5 text-lg m-10 rounded dark:bg-gray-400 dark:text-gray-700">Back</a>

</div>

<div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Input Jadwal: {{ $employee->name }}</h2>

    <form action="{{ url('/schedules/' . $employee->id . '/store') }}" method="POST">

        @csrf

        <table class="w-full table-auto text-sm border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">Tanggal</th>
                    <th class="border px-2 py-1">Hari</th>
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
                            <select name="schedule[{{ $date->toDateString() }}][status]" class="w-full border px-1 py-1 rounded">
                                @foreach(['Work', 'Off', 'Libur Nasional'] as $option)
                                    <option value="{{ $option }}" {{ $schedule && $schedule->status === $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="border px-2 py-1">
                            <input type="text" name="schedule[{{ $date->toDateString() }}][remarks]" value="{{ $schedule->remarks ?? '' }}" class="w-full border px-1 py-1 rounded">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Jadwal</button>
        </div>
    </form>
</div>



</x-app-layout>