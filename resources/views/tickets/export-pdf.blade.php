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
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->kode_tiket }}</td>
                    <td>{{ $ticket->problem }}</td>
                    <td>{{ $ticket->outlet->name ?? '-' }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>{{ $ticket->it_name }}</td>
                    <td>{{ $ticket->start_date }}</td>
                    <td>{{ $ticket->finish_date }}</td>
                    <td>{{ $ticket->lama_pengerjaan }}</td>
                    <td>{{ $ticket->description }}</td>
                    <td>{{ $ticket->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
