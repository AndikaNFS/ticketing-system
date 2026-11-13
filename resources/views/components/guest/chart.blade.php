

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Ticketing</h1>
        <p class="text-gray-500 text-sm">Monitoring tiket & performa support</p>
    </div>

    <!-- Filter -->
    <div class="flex justify-end mb-6">
        <select id="filterRange" class="border-gray-300 rounded-lg text-sm px-3 py-2">
            <option value="weekly">Per Minggu</option>
            <option value="monthly">Per Bulan</option>
        </select>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        <!-- Donut Status -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="font-semibold text-gray-700 mb-3">Status Tiket</h2>
            <div id="chartStatus"></div>
        </div>

        <!-- PIC -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="font-semibold text-gray-700 mb-3">Tiket per PIC</h2>
            <div id="chartPIC"></div>
        </div>

        <!-- Outlet -->
        <div class="bg-white p-6 rounded-xl shadow border col-span-1 lg:col-span-2">
            <h2 class="font-semibold text-gray-700 mb-3">Tiket per Outlet</h2>
            <div id="chartOutlet"></div>
        </div>

        <!-- Monthly -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="font-semibold text-gray-700 mb-3">Tiket Bulanan</h2>
            <div id="chartMonthly"></div>
        </div>

        <!-- SLA -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="font-semibold text-gray-700 mb-3">Lama Penyelesaian Tiket</h2>
            <div id="chartSLA"></div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>

        // ----------------------------------------------------------------
        // Create Empty Charts (akan di update menggunakan AJAX)
        // ----------------------------------------------------------------

        var chartStatus = new ApexCharts(document.querySelector("#chartStatus"), {
            chart: { type: 'donut', height: 300 },
            labels: ['Open', 'In Progress', 'Done'],
            series: [0,0,0],
            colors: ['#EF4444', '#F59E0B', '#10B981']
        });
        chartStatus.render();

        var chartPIC = new ApexCharts(document.querySelector("#chartPIC"), {
            chart: { type: 'bar', height: 330 },
            series: [{ name: 'Tiket', data: [] }],
            xaxis: { categories: [] },
            plotOptions: { bar: { horizontal: true, borderRadius: 5 } },
            colors: ['#3B82F6']
        });
        chartPIC.render();

        var chartOutlet = new ApexCharts(document.querySelector("#chartOutlet"), {
            chart: { type: 'area', height: 350 },
            series: [{ name: "Tiket", data: [] }],
            xaxis: { categories: [] },
            colors: ['#6366F1']
        });
        chartOutlet.render();

        var chartMonthly = new ApexCharts(document.querySelector("#chartMonthly"), {
            chart: { type: 'area', height: 300 },
            series: [{ name: "Tiket", data: [] }],
            xaxis: { categories: [] },
            colors: ['#14B8A6']
        });
        chartMonthly.render();

        var chartSLA = new ApexCharts(document.querySelector("#chartSLA"), {
            chart: { type: 'line', height: 300 },
            series: [{ name: "Jam Penyelesaian", data: [] }],
            xaxis: { categories: [] },
            colors: ['#F43F5E'],
            stroke: { width: 3 }
        });
        chartSLA.render();

        // ----------------------------------------------------------------
        // AJAX Loader Function
        // ----------------------------------------------------------------

        function loadCharts(filter = 'weekly') {

            // 1. Status
            fetch(`/dashboard/chart/status?filter=${filter}`)
                .then(res => res.json())
                .then(data => {
                    chartStatus.updateSeries([data.open, data.inprogress, data.done]);
                });

            // 2. PIC
            fetch(`/dashboard/chart/pic?filter=${filter}`)
                .then(res => res.json())
                .then(data => {
                    chartPIC.updateOptions({ xaxis: { categories: data.labels } });
                    chartPIC.updateSeries([{ data: data.series }]);
                });

            // 3. Outlet
            fetch(`/dashboard/chart/outlet?filter=${filter}`)
                .then(res => res.json())
                .then(data => {
                    chartOutlet.updateOptions({ xaxis: { categories: data.labels } });
                    chartOutlet.updateSeries([{ data: data.series }]);
                });

            // 4. Monthly
            fetch(`/dashboard/chart/monthly`)
                .then(res => res.json())
                .then(data => {
                    chartMonthly.updateOptions({ xaxis: { categories: data.labels } });
                    chartMonthly.updateSeries([{ data: data.series }]);
                });

            // 5. SLA
            fetch(`/dashboard/chart/sla`)
                .then(res => res.json())
                .then(data => {
                    chartSLA.updateOptions({ xaxis: { categories: data.labels } });
                    chartSLA.updateSeries([{ data: data.series }]);
                });
        }

        // Load pertama kali
        loadCharts();

        document.getElementById('filterRange')
            .addEventListener('change', function () {
                loadCharts(this.value);
            });

    </script>


