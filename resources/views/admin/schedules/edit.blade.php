<x-app-layout>
{{-- <form method="GET" action="{{ url('/schedules') }}" class="mb-4">
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" value="{{ $startDate }}">
    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" value="{{ $endDate }}">
    <button type="submit">Filter</button>
</form> --}}

<div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Input Jadwal: {{ $employee->name }}</h2>

    {{-- <form action="{{ route('schedules.store', $employee->id) }}" method="POST"> --}}
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

{{-- <div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-4">Jadwal Mingguan: {{ $employee->name }}</h2>

    <form action="{{ route('schedules.store', $employee->id) }}" method="POST">
    <form action="{{ url('/schedules/' . $employee->id . '/store') }}" method="POST">
        @csrf
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-300 text-center">
                <thead class="bg-gray-100">
                    <tr>
                        @foreach ($dates as $date)
                            <th class="px-3 py-2 border">{{ $date->format('D') }}<br>{{ $date->format('d M') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($dates as $date)
                            @php
                                $schedule = $existing[$date->toDateString()] ?? null;
                            @endphp
                            <td class="border px-2 py-2">
                                <select name="schedule[{{ $date->toDateString() }}][status]" class="w-full border rounded px-2 py-1">
                                    <option value="Work" {{ $schedule?->status == 'Work' ? 'selected' : '' }}>Work</option>
                                    <option value="Off" {{ $schedule?->status == 'Off' ? 'selected' : '' }}>Off</option>
                                    <option value="Holiday" {{ $schedule?->status == 'Holiday' ? 'selected' : '' }}>Holiday</option>
                                </select>
                                <input type="text" name="schedule[{{ $date->toDateString() }}][remarks]"
                                       value="{{ $schedule?->remarks }}" class="mt-1 w-full border rounded px-2 py-1"
                                       placeholder="Remarks (opsional)">
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-right">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan Jadwal</button>
        </div>
    </form>
</div> --}}


</x-app-layout>