<table>
    <thead>
        <tr>
            <th colspan="99">Jadwal Maintenance - Bulan {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</th>
        </tr>
    </thead>
</table>

@foreach ($schedules as $week)
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Posisi</th>
                @foreach ($week['dates'] as $date)
                    <th>{{ \Carbon\Carbon::parse($date)->format('d D') }}</th>
                @endforeach
                <th>Total WD</th>
                <th>Total OFF</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($week['employees'] as $employee)
                <tr>
                    <td>{{ $employee['name'] }}</td>
                    <td>{{ $employee['position'] }}</td>
                    @foreach ($employee['days'] as $day)
                        <td>{{ $day }}</td>
                    @endforeach
                    <td>{{ $employee['total_work'] }}</td>
                    <td>{{ $employee['total_off'] }}</td>
                    <td>{{ $employee['remarks'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
