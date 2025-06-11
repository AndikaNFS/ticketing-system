<x-app-layout>

<div class="max-w-6xl mx-auto mt-10 py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">Laporan Pekerjaan Harian</h1>
            <a href="{{ route('reports.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Tambah Laporan</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between place-items-center bg-gray-700 border border-gray-600 text-gray-900 mb-6 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <div class=" flex">
                <div class="flex items-center min-h-max h-5">
                    <form method="GET" action="{{ route('reports.index') }}" class=" flex items-center gap-2 flex-wrap">
                        <label class="font-semibold text-white">Filter:</label>
                
                        <select name="month" class="border rounded px-2 py-1">
                            <option value=""> Bulan </option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                
                        <select name="year" class="border rounded px-2 py-1 min-w-20">
                            <option value=""> Tahun </option>
                            @for($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                
                        <button type="submit" class="bg-blue-600 text-white me-2 px-3 py-1 rounded hover:bg-blue-700">Terapkan</button>
                    </form>

                    <a href="{{ route('reports.index') }}" class="bg-blue-600 text-white px-3 py-1  rounded hover:bg-blue-700">Reset</a>
                </div>
                {{-- <div class=" bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"> --}}

                {{-- </div> --}}
            </div>

            {{-- <div class="bg-gray-500 p-2 rounded-xl min-w-max">

            </div> --}}

            <a href="{{ route('reports.export.export_excel', ['month' => request('month'), 'year' => request('year')]) }}"
            class="bg-green-700 text-white px-3 py-2 rounded hover:bg-green-800">
            Export Excel
            </a>
        </div>



        <div class="overflow-auto bg-white shadow rounded">
            <table class="min-w-full text-sm text-left border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Pekerjaan Sebelumnya</th>
                        <th class="border px-3 py-2">Pekerjaan Hari Ini</th>
                        <th class="border px-3 py-2">Keterangan</th>
                        <th class="border px-3 py-2">Status</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $index => $report)
                    <tr class="{{ $report->status == 'libur' ? 'bg-red-100' : '' }}">
                        <td class="border px-3 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($report->date)->format('d-M-Y') }}</td>
                        <td class="border px-3 py-2 whitespace-pre-line">{{ $report->prev_work }}</td>
                        <td class="border px-3 py-2 whitespace-pre-line">{{ $report->today_work }}</td>
                        <td class="border px-3 py-2">{{ $report->notes }}</td>
                        <td class="border px-3 py-2 capitalize">{{ $report->status }}</td>
                        <td class="border px-3 py-2 text-sm space-x-2">
                            <a href="{{ route('reports.edit', $report->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="border px-3 py-2 text-center text-gray-500">Belum ada laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


</x-app-layout>