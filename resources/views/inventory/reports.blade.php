<x-app-layout>
    <div style="background-color: #fcf9f1; min-height: 100vh; padding: 2rem;">

        <div
            style="background-color: #3d2b1f; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; color: #fcf9f1; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 1.5rem;">📊</span>
                <h1 style="font-size: 1.25rem; font-weight: bold; margin: 0;">CafeEase | Business Insights</h1>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">

            <div
                style="background: white; padding: 1.5rem; border-radius: 1.5rem; border-left: 8px solid #d4b08c; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <p style="color: #6b7280; font-size: 0.7rem; margin: 0; text-transform: uppercase; font-weight: bold;">
                    Total Revenue</p>
                <h2 style="color: #3d2b1f; font-size: 1.8rem; font-weight: 900; margin: 0.5rem 0;">
                    ₱{{ number_format($totalRevenue, 2) }}
                </h2>
            </div>

            <div
                style="background: white; padding: 1.5rem; border-radius: 1.5rem; border-left: 8px solid #3d2b1f; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <p style="color: #6b7280; font-size: 0.7rem; margin: 0; text-transform: uppercase; font-weight: bold;">
                    Orders Completed</p>
                <h2 style="color: #3d2b1f; font-size: 1.8rem; font-weight: 900; margin: 0.5rem 0;">{{ $totalOrders }}
                </h2>
            </div>

            <div
                style="background: white; padding: 1.5rem; border-radius: 1.5rem; border-left: 8px solid #634832; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <p style="color: #6b7280; font-size: 0.7rem; margin: 0; text-transform: uppercase; font-weight: bold;">
                    Best Seller</p>

                <h2 style="color: #3d2b1f; font-size: 1.4rem; font-weight: 900; margin: 0.5rem 0; line-height: 1.2;">
                    {{-- FIXED: Changed to item_name to match migration --}}
                    {{ $topProduct->item_name ?? 'No Sales Yet' }}
                </h2>

                <span
                    style="background-color: #fcf9f1; color: #3d2b1f; padding: 2px 8px; border-radius: 10px; font-size: 0.7rem; font-weight: bold;">
                    Ordered {{ $topProduct->total_sales ?? 0 }} times
                </span>
            </div>

        </div>

        <div style="background: white; padding: 2.5rem; border-radius: 2.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
            <h2 style="font-size: 1.5rem; font-weight: 900; color: #3d2b1f; margin-bottom: 1.5rem;">7-Day Sales Trend
            </h2>
            <div style="width: 100%; height: 400px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Daily Revenue (₱)',
                    data: @json($totals),
                    borderColor: '#3d2b1f',
                    backgroundColor: 'rgba(212, 176, 140, 0.2)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#d4b08c',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
