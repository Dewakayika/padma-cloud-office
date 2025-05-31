<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-lg p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Company Distribution by Country</h3>
    </div>

    <div class="w-full h-[400px]">
        <canvas id="companyCountryChart"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('companyCountryChart').getContext('2d');

    const data = {
        labels: {!! json_encode($chartDataCompanyCountry->pluck('country')) !!},
        datasets: [{
            label: 'Number of Companies',
            data: {!! json_encode($chartDataCompanyCountry->pluck('count')) !!},
            backgroundColor: [
                '#4299E1', // blue
                '#48BB78', // green
                '#F6E05E', // yellow
                '#F56565', // red
                '#9F7AEA', // purple
                '#ED8936', // orange
                '#63B3ED', // light blue
                '#6EE7B7', // teal
                '#FCD34D', // amber
                '#F87171', // light red
                '#C4B5FD', // light purple
                '#FDBA74', // light orange
            ],
            borderColor: '#ffffff',
            borderWidth: 1
        }]
    };

    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: 'rgba(156, 163, 175, 1)',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((sum, current) => sum + current, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
});
</script>
@endpush
