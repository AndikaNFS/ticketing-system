<!DOCTYPE html>
<html>
<head>
    <title>Tickets Building PDF</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h2>Data Ticketing</h2>
    <table width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Tiket</th>
                <th>Problem</th>
                <th>Outlet</th>
                <th>Status</th>
                <th>Vendor</th>
                <th>PIC</th>
                <th>Start Date</th>
                <th>Finish Date</th>
                <th>Work Duration</th>
                <th>Description</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buildings as $building)
                <tr>
                    <td>{{ $building->id }}</td>
                    <td>{{ $building->ticketing }}</td>
                    <td>{{ $building->problem }}</td>
                    <td>{{ $building->outlet->name ?? '-' }}</td>
                    <td>{{ $building->status }}</td>
                    <td>{{ $building->vendor->name ?? '-' }}</td>
                    <td>{{ $building->pic->name ?? '-' }}</td>
                    <td>{{ $building->start_date }}</td>
                    <td>{{ $building->finish_date }}</td>
                    <td>{{ $building->work_duration }}</td>
                    <td>{{ $building->description }}</td>
                    <td>{{ $building->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
