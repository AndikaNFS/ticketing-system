<x-app-layout>
    <div class="bg-white rounded-xl">
<div class="container mx-auto px-4 pt-8">
    <h1 class="text-2xl font-bold mb-4">Jadwal IT Support - Bulan {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</h1>
    <div class="grip col-span-2 gap-4">
        <form method="GET" class="mb-6 flex items-center gap-4">
            
            <label class="font-semibold">Pilih Bulan:</label>
            <input type="month" name="bulan" value="{{ $bulan }}" class="border px-3 py-1 rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">Tampilkan</button>
        </form>
        <div class="mb-6 flex items-center gap-4 ">
            <a href="{{ route('schedules.exports.pdf', ['bulan' => $bulan]) }}" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Export PDF</a>
            <a href="{{ route('schedules.exports.excel', ['bulan' => $bulan]) }}" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">Export Excel</a>
    
        </div>

    </div>

    @foreach ($weeks as $index => $week)
        <div class="mb-10 bg-white shadow rounded-lg overflow-x-auto">
            <div class="flex bg-gray-100 px-4 py-2 font-semibold text-lg">
                <div class="flex items-start">
                    📅 Minggu ke-{{ $index + 1 }} ({{ $week['start']->format('d M') }} - {{ $week['end']->format('d M') }})

                </div>
                <div class="flex items-end">
                </div>
            </div>
            <table class="min-w-full border border-gray-300 text-sm text-center">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="border px-2 py-1">Nama</th>
                        <th class="border px-2 py-1">Posisi</th>
                        @foreach ($week['dates'] as $date)
                            <th class="border px-2 py-1">
                                {{ $date->format('d') }}<br>
                                <span class="text-xs text-gray-500">{{ $date->translatedFormat('D') }}</span>
                            </th>
                        @endforeach
                        <th class="border px-2 py-1">Total WD</th>
                        <th class="border px-2 py-1">Total OFF</th>
                        <th class="border px-2 py-1">Remarks</th>
                        @if(auth()->user()->hasRole('superadmin|admin'))
                            <th class="border px-2 py-1">Aksi</th>
                        @endif
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
                        <tr class="hover:bg-gray-50">
                            <td class="border px-2 py-1">{{ $employee->name }}</td>
                            <td class="border px-2 py-1">{{ $employee->position }}</td>
                            @foreach ($week['dates'] as $date)
                                @php
                                    $schedule = $schedules[$date->toDateString()] ?? null;
                                    $status = $schedule->status ?? '-';
                                    // $isLiburNasional = $date->is_libur_nasional ?? false;
                                    // $status = $schedule->status ?? ($isLiburNasional ? 'Libur Nasional' : '-');

                                    if ($status === 'Work') $workDays++;
                                    if ($status === 'Off') $offDays++;
                                    if ($schedule && $schedule->remarks) $remarks[] = $schedule->remarks;
                                @endphp
                                <td class="border px-2 py-1 {{ $status === 'Off' ? 'bg-red-100 text-red-700' : 
                                                             ( $status === 'Work' ? 'bg-green-100 text-green-700' : 
                                                             ( $status === 'Libur Nasional' ? 'bg-yellow-300 text-yellow-700' : 'bg-green-100 text-green-700' )) }}">
                                    {{ $status }}
                                </td>
                            @endforeach
                            <td class="border px-2 py-1">{{ $workDays }}</td>
                            <td class="border px-2 py-1">{{ $offDays }}</td>
                            <td class="border px-2 py-1 text-left">{{ implode(', ', array_unique($remarks)) }}</td>
                            @if(auth()->user()->hasRole('superadmin|admin'))
                            <td class="border px-2 py-1">
                                    <a href="{{ route('schedules.edit.weekly', ['id' => $employee->id, 'start_date' => $week['start']->format('Y-m-d')]) }}" class="text-blue-500 hover:underline">Edit</a>
                                </td>
                                @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>

    </div>

</x-app-layout>