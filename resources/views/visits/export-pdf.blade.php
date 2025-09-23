<!DOCTYPE html>
<html>
<head>
    <title>Visits PDF</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h2>Data Visit</h2>
    <table width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>IT Name</th>
                <th>Visit Date</th>
                <th>Outlet</th>
                <th>Ticket</th>
                <th>Job Desk</th>
                <th>Status</th>
                {{-- <th>Created At</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($data as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->pic }}</td>
                    <td>{{ $data->tanggal_visit }}</td>
                    <td>{{ $data->outlet->name ?? '-' }}</td>
                    <td>{{ $data->ticket->ticketing ?? '-' }}</td>
                    <td>{{ $data->description }}</td>
                    <td>{{ $data->status }}</td>
                    {{-- <td>{{ $data->created_at->format('Y-m-d') }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
