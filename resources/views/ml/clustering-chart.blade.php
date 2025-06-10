<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clustering Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="max-w-4xl mx-auto py-10 px-4">
        <h2 class="text-2xl font-bold text-center mb-6">📊 Visualisasi Clustering Penjualan</h2>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <canvas id="clusteringChart" height="400"></canvas>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ([1,2,3] as $cluster)
                <div class="bg-white shadow-md rounded p-4 text-center border-t-4 border-{{ ['red', 'blue', 'green'][$cluster - 1] }}-500">
                    <h3 class="text-lg font-semibold">Cluster {{ $cluster }}</h3>
                    <p class="text-sm text-gray-600">Data yang termasuk dalam kelompok ini</p>
                    <span class="text-2xl font-bold text-{{ ['red', 'blue', 'green'][$cluster - 1] }}-600">
                        {{ collect($chartData)->where('cluster', $cluster)->count() }} Data
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const data = @json($chartData);

        const colors = ['rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 'rgba(75, 192, 192, 0.7)'];

        const datasets = [1, 2, 3].map(clusterId => {
            return {
                label: 'Cluster ' + clusterId,
                data: data.filter(item => item.cluster === clusterId).map(item => ({
                    x: item.online,
                    y: item.offline
                })),
                backgroundColor: colors[clusterId - 1],
                borderColor: colors[clusterId - 1],
                pointRadius: 6,
                pointHoverRadius: 8
            }
        });

        const config = {
            type: 'scatter',
            data: {
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'K-Means Clustering Penjualan Online vs Offline',
                        font: {
                            size: 18
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Online: Rp ${context.raw.x.toLocaleString()} | Offline: Rp ${context.raw.y.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Penjualan Online',
                            font: { size: 14 }
                        },
                        beginAtZero: true
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Penjualan Offline',
                            font: { size: 14 }
                        },
                        beginAtZero: true
                    }
                }
            }
        };

        new Chart(document.getElementById('clusteringChart'), config);
    </script>
</body>
</html>
