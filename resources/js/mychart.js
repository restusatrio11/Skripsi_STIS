import Chart from "chart.js/auto";
import ChartDataLabels from 'chartjs-plugin-datalabels';
Chart.register(ChartDataLabels);

const ctx = document.getElementById("avgChart");

$.ajax({
    url: "/getAvg",
    success: function (result) {
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: result.map(a => a.name),
                datasets: [
                    {
                        data: result.map(a => a.nilai),
                        borderWidth: 1,
                        backgroundColor: "orange"
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Rata-Rata Nilai Kegiatan Pegawai",
                        font: {
                            size: 20,
                        },
                        padding: 5
                    },
                    legend: {
                        display: false,
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        // formatter: Math.round,
                    }
                },
            },
        });
    },
});

const countctx = document.getElementById("countChart");

$.ajax({
    url: "/getCount",
    success: function (result) {
        new Chart(countctx, {
            type: "bar",
            data: {
                labels: result.map(a => a.name),
                datasets: [
                    {
                        data: result.map(a => a.kegiatan),
                        borderWidth: 1,
                        backgroundColor: '#17bc9c'
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Jumlah Kegiatan Pegawai",
                        font: {
                            size: 20,
                        },
                        padding: 30
                    },
                    legend: {
                        display: false,
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        // formatter: Math.round,
                    }
                },
            },
        });
    },
});


