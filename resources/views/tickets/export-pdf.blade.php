<!DOCTYPE html>
<html>
<head>
    <title>Tickets PDF</title>
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
                <th>IT Name</th>
                <th>Start Date</th>
                <th>Finish Date</th>
                <th>Work Duration</th>
                <th>Description</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->ticketing }}</td>
                    <td>{{ $data->problem }}</td>
                    <td>{{ $data->outlet->name ?? '-' }}</td>
                    <td>{{ $data->status }}</td>
                    <td>{{ $data->it_name }}</td>
                    <td>{{ $data->start_date }}</td>
                    <td>{{ $data->finish_date }}</td>
                    <td>{{ $data->lama_pengerjaan }}</td>
                    <td>{{ $data->description }}</td>
                    <td>{{ $data->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
