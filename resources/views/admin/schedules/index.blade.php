<x-app-layout>
    <div class="bg-white">

        {{-- <form method="GET" action="{{ url('/schedules') }}" class="mb-4">
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" value="{{ $startDate }}">
    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" value="{{ $endDate }}">
    <button type="submit">Filter</button>
</form> --}}

<form method="GET" action="{{ route('schedules.index') }}" class="mb-4">
    <label for="bulan">Pilih Bulan:</label>
    <input type="month" name="bulan" value="{{ $bulan }}">
    <button type="submit">Tampilkan</button>
</form>


        {{-- <table border="2" class="border border-black gap-4">
            <thead>
                <tr class="gap-4">
                    <th>Nama</th>
                    <th>Position</th>
                    @foreach ($dates as $date)
                        <th>{{ $date->format('d') }}<br>{{ $date->translatedFormat('l') }}</th>
                    @endforeach
                    <th>Total WD</th>
                    <th>Total OFF</th>
                    <th>REMARKS</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    @php
                        $workDays = 0;
                        $offDays = 0;
                        $remarks = [];
                        $schedules = $employee->schedules->keyBy('date');
                    @endphp
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->position }}</td>
                        @foreach ($dates as $date)
                            @php
                                $schedule = $schedules[$date->toDateString()] ?? null;
                                $status = $schedule->status ?? 'Work';
                                if ($status === 'Off') $offDays++;
                                if ($status === 'Work') $workDays++;
                                if ($schedule && $schedule->remarks) $remarks[] = $schedule->remarks;
                            @endphp
                            <td>{{ $status === 'Work' ? '' : $status }}</td>
                        @endforeach
                        <td>{{ $workDays }}</td>
                        <td>{{ $offDays }}</td>
                        <td>{{ implode(', ', array_unique($remarks)) }}</td>
                        <td>
                            <a href="{{ route('schedules.edit', $employee->id) }}" class="hover:text-blue-400">Edit</a>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}

        @foreach ($weeks as $index => $week)
    <h3 style="margin-top: 20px;">
        📅 Minggu ke-{{ $index + 1 }} ({{ $week['start']->format('d M') }} - {{ $week['end']->format('d M') }})
    </h3>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Posisi</th>
                @foreach ($week['dates'] as $date)
                    <th>{{ $date->format('d') }}<br>{{ $date->translatedFormat('D') }}</th>
                @endforeach
                <th>Total WD</th>
                <th>Total OFF</th>
                <th>Remarks</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                @php
                    $workDays = 0;
                    $offDays = 0;
                    $remarks = [];
                    $schedules = $employee->schedules->keyBy('date');
                @endphp
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->position }}</td>
                    @foreach ($week['dates'] as $date)
                        @php
                            $schedule = $schedules[$date->toDateString()] ?? null;
                            $status = $schedule->status ?? '';
                            if ($status === 'Work') $workDays++;
                            if ($status === 'Off') $offDays++;
                            if ($schedule && $schedule->remarks) $remarks[] = $schedule->remarks;
                        @endphp
                        <td>{{ $status }}</td>
                    @endforeach
                    <td>{{ $workDays }}</td>
                    <td>{{ $offDays }}</td>
                    <td>{{ implode(', ', array_unique($remarks)) }}</td>
                    <td>
                        <a href="{{ route('schedules.edit', $employee->id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach


    </div>
    {{-- <form method="GET" action="{{ route('schedules.index') }}">
    <input type="month" name="bulan" value="{{ $bulan }}">
    <button type="submit">Lihat Jadwal</button>
</form> --}}

{{-- <ul>
@foreach ($dates as $item)
    <li>{{ ucfirst($item['hari']) }}, {{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}</li>
@endforeach
</ul> --}}

</x-app-layout>