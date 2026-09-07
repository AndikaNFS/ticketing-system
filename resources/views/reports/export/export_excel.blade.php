<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pekerjaan Sebelumnya</th>
                <th>Pekerjaan Hari Ini</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
            <tr>
                <td>{{ \Carbon\Carbon::parse($report->date)->format('d-m-Y') }}</td>
                <td>{{ $report->prev_work }}</td>
                <td>{{ $report->today_work }}</td>
                <td>{{ $report->notes }}</td>
                <td>{{ $report->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
