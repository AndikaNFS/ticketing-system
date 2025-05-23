<x-app-layout>
    <div class="bg-white">

        <form method="GET" action="{{ url('/schedules') }}" class="mb-4">
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" value="{{ $startDate }}">
    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" value="{{ $endDate }}">
    <button type="submit">Filter</button>
</form>


        <table border="1">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Position</th>
                    @foreach ($dates as $date)
                        <th>{{ $date->format('d') }}<br>{{ $date->format('D') }}</th>
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
        </table>

    </div>

</x-app-layout>