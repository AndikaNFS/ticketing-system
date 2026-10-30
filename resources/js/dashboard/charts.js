 // ----------------------------------------------------------------
        // Create Empty Charts (akan di update menggunakan AJAX)
        // ----------------------------------------------------------------
    

        var chartStatus = new ApexCharts(document.querySelector("#chartStatus"), {
            chart: { type: 'donut', height: 300 },
            labels: ['Open', 'InProgress', 'Done'],
            series: [
                {{ $statusCounts['Open'] }},
                {{ $statusCounts['InProgress'] }},
                {{ $statusCounts['Done'] }}
            ],
            // colors: ['#EF4444', '#F59E0B', '#10B981']
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

        // AJAX Loader

    function loadCharts(filter = 'weekly') {
        // 1. Status ticket
        fetch(`/dashboard/chart/status?filter=${filter}`)
            .then(res => res.json())
            .then(data => {
                chartStatus.updateSeries([data.open, data.inprogress, data.done]);
            });

        // 2. PIC
        fetch(`/dashboard/chart/pic?filter=${filter}`)
            .then(res => res.json())
            .then(data => {
                chartPIC.updateOptions({
                    xaxis: {categories:data.labels}
                });
                chartPIC.updateSeries([{
                    data: data.series
                }]);
            });

        // 3. Outlet
        fetch(`/dashboard/chart/outlet?filter=${filter}`)
            .then(res => res.json())
            .then(data => {
                chartOutlet.updateOptions({
                    xaxis: {categories: data.labels}
                });
                chartOutlet.updateSeries([{
                    data:data.series
                }]);
            });

        // 4. Monthly Ticket
        fetch(`/dashboard/chart/monthly`)
            .then(res => res.json())
            .then(data => {
                chartMonthly.updateOptions({
                    xaxis: {categories: data.labels}
                });
                chartMonthly.updateSeries([{
                    data: data.series
                }]);
            });

        // 5. SLA
        fetch(`/dashboard/chart/sla`)
            .then(res => res.json())
            .then(data => {
                chartSLA.updateOptions({
                    xaxis: {categories: data.labels}
                });
                chartSLA.updateSeries([{
                    data: data.series
                }]);
            });
    }

    document.getElementById('filterRange').addEventListener('change', function() {
        loadCharts(this.value);
    });

    // initial load
    loadCharts();
