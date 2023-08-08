<div class="card">
    <canvas id="lineChart" width="800" height="400"></canvas>

    <script type="application/javascript">
        const data = @json($graphdata);
        const labels = data.map(entry => entry.month);

        const preOrderCounts = data.map(entry => entry.preOrderCount);
        const deliveryCounts = data.map(entry => entry.deliveryCount);
        const vanSalesCounts = data.map(entry => entry.vanSalesCount); // Add this line

        const ctx = document.getElementById('lineChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pre Orders',
                        data: preOrderCounts,
                        borderColor: 'rgb(255, 69, 0)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0,
                    },
                    {
                        label: 'Deliveries',
                        data: deliveryCounts,
                        borderColor: 'rgb(21, 116, 239)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0,
                    },
                    {
                        label: 'Van Sales', // Add a label for Van Sales
                        data: vanSalesCounts, // Use the vanSalesCounts data
                        borderColor: 'rgb(50, 205, 50)', // Choose a color for Van Sales
                        borderWidth: 2,
                        fill: false,
                        tension: 0,
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Months',
                        },
                    },
                    y: {
                        beginAtZero: true,
                        min: 0, // Set a minimum value based on your data
                        max: Math.ceil(
                            Math.max(...preOrderCounts, ...deliveryCounts, ...vanSalesCounts) / 50
                        ) * 50,
                        ticks: {
                            stepSize: 50,
                        },
                        display: true,
                        title: {
                            display: true,
                            text: 'Count',
                        },
                    },
                },
            },
        });
    </script>
</div>
