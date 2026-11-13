
        // ---------------------------------------------------
        // 1. Donut Chart - Status Tiket
        // ---------------------------------------------------
        new ApexCharts(document.querySelector("#chartStatus"), {
            chart: { type: 'donut', height: 300 },
            labels: ['Open', 'In Progress', 'Done'],
            series: [30, 15, 55], // ← Ganti dengan data dari backend
            colors: ['#EF4444', '#F59E0B', '#10B981']
        }).render();

        // ---------------------------------------------------
        // 2. Horizontal Bar - Tiket Berdasarkan PIC
        // ---------------------------------------------------
        new ApexCharts(document.querySelector("#chartPIC"), {
            chart: { type: 'bar', height: 330 },
            series: [{
                name: 'Tiket',
                data: [12, 25, 18, 30] // Contoh data
            }],
            xaxis: {
                categories: ['Andre', 'Rizky', 'Bagus', 'Tono']
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 4
                }
            },
            colors: ['#3B82F6']
        }).render();

        // ---------------------------------------------------
        // 3. Area Chart - Tiket Berdasarkan Outlet
        // ---------------------------------------------------
        new ApexCharts(document.querySelector("#chartOutlet"), {
            chart: { type: 'area', height: 350 },
            series: [{
                name: "Tiket",
                data: [10, 25, 15, 30, 22, 18] // Contoh
            }],
            xaxis: {
                categories: ['Outlet A', 'Outlet B', 'Outlet C', 'Outlet D', 'Outlet E', 'Outlet F']
            },
            colors: ['#6366F1']
        }).render();

        // ---------------------------------------------------
        // 4. Area Chart - Tiket Bulanan
        // ---------------------------------------------------
        new ApexCharts(document.querySelector("#chartMonthly"), {
            chart: { type: 'area', height: 300 },
            series: [{
                name: "Tiket",
                data: [50, 40, 70, 65, 80, 95, 110]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul']
            },
            colors: ['#14B8A6']
        }).render();

        // ---------------------------------------------------
        // 5. Line Chart - Lama Penyelesaian (SLA)
        // ---------------------------------------------------
        new ApexCharts(document.querySelector("#chartSLA"), {
            chart: { type: 'line', height: 300 },
            series: [{
                name: "Jam Penyelesaian",
                data: [4, 6, 7, 3, 8, 2, 5] // contoh data
            }],
            xaxis: { categories: ['Hari 1', 'Hari 2', 'Hari 3', 'Hari 4', 'Hari 5', 'Hari 6', 'Hari 7'] },
            colors: ['#F43F5E'],
            stroke: { width: 3 }
        }).render();