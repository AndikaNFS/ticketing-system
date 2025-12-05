<x-dashboard-layout>

<div class="min-h-full">
  @include('components.guest.navbar')

  <header class="relative bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-white/10">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold tracking-tight text-white">Dashboard Ticketing</h1>
    </div>
  </header>
  <main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      {{-- <div class="bg-gray-300"> --}}
        {{-- @include('components.guest.chart') --}}
        <div class="py-6 px-6">

        {{-- Judul Dashboard --}}
        {{-- <h1 class="text-2xl font-semibold mb-6">Dashboard Ticketing</h1> --}}

        <form method="GET" action="{{ route('dashboard') }}" class="mb-6">
            <div class="flex gap-4">

                {{-- FILTER TYPE (WEEK / MONTH) --}}
                <select name="filter" class="border rounded px-3 py-2" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Per Minggu</option>
                    <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Per Bulan</option>
                </select>

                {{-- Jika filter = month → tampilkan bulan --}}
                @if(request('filter') == 'month')
                    <input type="month" name="month" value="{{ request('month') }}" class="border rounded px-3 py-2">
                @endif

                {{-- Jika filter = week → tampilkan minggu --}}
                @if(request('filter') == 'week')
                    <input type="week" name="week" value="{{ request('week') }}" class="border rounded px-3 py-2">
                @endif

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Filter
                </button>
            </div>
        </form>


        {{-- === ROW 1: STATUS CHART === --}}
        <div class="p-4 bg-white rounded shadow mb-6">
            {{-- STATUS TICKET --}}
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-3">Tiket per Outlet</h2>
                <div class="overflow-x-auto min-h-max">
                    {{-- <div class="" style="width: 1500px;"> --}}
                        <canvas id="outletChart" ></canvas>

                    {{-- </div> --}}

                </div>
            </div>
            

            {{-- SLA AVERAGE --}}
            {{-- <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-3">Rata-rata SLA (Hari)</h2>
                <canvas id="slaChart"></canvas>
            </div> --}}
        </div>

        {{-- === ROW 2: PIC & OUTLET === --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            {{-- PIC TICKET --}}
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-3">Tiket per PIC</h2>
                <div class="overflow-x-auto">
                  <canvas id="picChart"></canvas>

                </div>
            </div>

            {{-- OUTLET TICKET --}}
            

            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-3">Status Tiket</h2>
                <canvas id="statusChart"></canvas>
            </div>

        </div>

        {{-- === ROW 3: MONTHLY === --}}
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-3">Tiket Bulanan</h2>
            <canvas id="monthlyChart"></canvas>
        </div>

    </div>

    {{-- ChartJS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // ===========================
        //  STATUS CHART
        // ===========================
        const statusData = @json($statusCounts);

        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(statusData),
                datasets: [{
                    data: Object.values(statusData)
                }]
            }
        });

        // ===========================
        //  PIC CHART
        // ===========================
        const picLabels = @json(collect($ticketsByPIC)->pluck('employee_name'));
        const picCounts = @json(collect($ticketsByPIC)->pluck('total'));

        new Chart(document.getElementById('picChart'), {
            type: 'bar',
            data: {
                labels: picLabels,
                datasets: [{
                    label: 'Tiket per PIC',
                    data: picCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(51, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
              indexAxis: 'x',
              scales: {
                x: { beginAtZero: true, ticks: {stepSize: 1}},
                y: { ticks: { autoSkip: false, maxRotation: 0}}
              }
            }
        });

        

        // ===========================
        //  OUTLET CHART
        // ===========================
        const outletLabels = @json(collect($ticketsByOutlet)->pluck('outlet_name'));
        const outletCounts = @json(collect($ticketsByOutlet)->pluck('total'));

        new Chart(document.getElementById('outletChart'), {
            type: 'bar',
            data: {
                labels: outletLabels,
                datasets: [{
                    label: 'Tiket per Outlet',
                    data: outletCounts,
                    backgroundColor: 'rgba(54, 162, 235, 1)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                }]
            },
            options: {
              indexAxis: 'y',
              scales: {
                x: { beginAtZero: true, ticks: {stepSize: 1} },
                y: { ticks: { autoSkip: false, maxRotation: 1}}
              }
            }
        });

        // ===========================
        //  MONTHLY CHART
        // ===========================
        const monthlyLabels = @json(collect($monthlyTickets)->pluck('bulan'));
        const monthlyCounts = @json(collect($monthlyTickets)->pluck('total'));

        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    data: monthlyCounts
                }]
            }
        });

        // ===========================
        //  SLA CHART
        // ===========================
        const slaLabels = ["Rata-rata SLA"];
        const slaCounts = [@json($completionTime['lama'])];

        new Chart(document.getElementById('slaChart'), {
            type: 'bar',
            data: {
                labels: slaLabels,
                datasets: [{
                    label: "Rata-rata SLA",
                    data: slaCounts,
                    backgroundColor: "rgba(255, 159,62, 2)",
                    borderWidth: 1
                }]
            }
        });
    </script>
      {{-- </div> --}}

    </div>
  </main>
</div>

</x-dashboard-layout>
