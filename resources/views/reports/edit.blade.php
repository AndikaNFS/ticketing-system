<x-app-layout>
    {{-- <pre>{{ dd($dailyReport) }}</pre> --}}

 
<div class="max-w-3xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Laporan Pekerjaan Harian</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- DEBUG --}}
{{-- <div>ID: {{ $dailyReport->id }}</div> --}}

    {{-- <form action="{{ route('reports.update', $dailyReport) }}" method="POST" class="space-y-4"> --}}
    <form action="{{ route('reports.update', ['report' => $dailyReport->id]) }}" method="POST">

        @csrf
        @method('PUT')

        <div>
            <label for="date" class="block font-semibold">Tanggal</label>
            <input type="date" name="date" id="date" class="w-full border rounded px-3 py-2" value="{{ old('date', $dailyReport->date->format('Y-m-d')) }}" required>
        </div>

        <div>
            <label for="prev_work" class="block font-semibold">Pekerjaan Sebelumnya</label>
            <textarea name="prev_work" id="prev_work" rows="3" class="w-full border rounded px-3 py-2">{{ old('prev_work', $dailyReport->prev_work) }}</textarea>
        </div>

        <div>
            <label for="today_work" class="block font-semibold">Pekerjaan Hari Ini</label>
            <textarea name="today_work" id="today_work" rows="3" class="w-full border rounded px-3 py-2">{{ old('today_work', $dailyReport->today_work) }}</textarea>
        </div>

        <div>
            <label for="notes" class="block font-semibold">Keterangan</label>
            <input type="text" name="notes" id="notes" class="w-full border rounded px-3 py-2" value="{{ old('notes', $dailyReport->notes) }}">
        </div>

        <div>
            <label for="status" class="block font-semibold">Status</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Status --</option>
                @foreach(['selesai', 'belum', 'libur'] as $status)
                    <option value="{{ $status }}" {{ old('status', $dailyReport->status) == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Perbarui</button>
            <a href="{{ route('reports.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>

</x-app-layout>