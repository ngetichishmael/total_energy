<div class="card">
    <canvas id="lineChart" width="800" height="400"></canvas>

    <script type="application/javascript">
        const data = @json($graphdata);
        const labels = data.map(entry => entry.month);

        console.log(data);
        const preOrderCounts = data.map(entry => entry.preOrderCount);
        const deliveryCounts = data.map(entry => entry.deliveryCount);

        const ctx = document.getElementById('lineChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pre Orders', // Interchanged labels
                    data: preOrderCounts, // Interchanged data
                    borderColor: 'rgb(255, 69, 0)',
                    borderWidth: 2, // Set the line width to make it slimmer
                    fill: false,
                    tension: 0, // Set the tension to make the line straight
                },
                {
                    label: 'Deliveries', // Interchanged labels
                    data: deliveryCounts, // Interchanged data
                    borderColor: 'rgb(21, 116, 239)',
                    borderWidth: 2, // Set the line width to make it slimmer
                    fill: false,
                    tension: 0, // Set the tension to make the line straight
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        min: 50,
                        max: Math.ceil(Math.max(...preOrderCounts, ...deliveryCounts) / 50) * 50,
                        ticks: {
                            stepSize: 50
                        },
                        display: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });
    </script>
</div>
