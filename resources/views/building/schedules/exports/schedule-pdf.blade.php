<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        .bg-green { background-color: #d4edda; }
        .bg-red { background-color: #f8d7da; }
        .bg-yellow { background-color: #fff3cd; }
    </style>
</head>
<body>
    <h2>Jadwal Maintenance - Bulan {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</h2>

    @foreach ($schedules as $week)
        <h4>Minggu ke-{{ $loop->iteration }} ({{ $week['start'] }} - {{ $week['end'] }})</h4>
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
                            <td class="{{ $day == 'Work' ? 'bg-green' : ($day == 'Off' ? 'bg-red' : ($day == 'Libur Nasional' ? 'bg-yellow' : '')) }}">
                                {{ $day }}
                            </td>
                        @endforeach
                        <td>{{ $employee['total_work'] }}</td>
                        <td>{{ $employee['total_off'] }}</td>
                        <td>{{ $employee['remarks'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
