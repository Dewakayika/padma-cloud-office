<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-lg p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Statistic Project 2025</h3>
        {{-- Placeholder for year dropdown --}}
        <div class="relative">
            <select class="block appearance-none w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-600 focus:border-blue-500">
                <option>2025</option>
                {{-- Add more years dynamically if needed --}}
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-200">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
    </div>

    <div class="w-full h-[300px]">
        <canvas id="projectStatisticsChart"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('projectStatisticsChart').getContext('2d');

    // Placeholder data - replace with data passed from controller
    const labels = ['Jan 25', 'Feb 25', 'Mar 25', 'Apr 25', 'May 25', 'Jun 25', 'Jul 25', 'Aug 25', 'Sep 25', 'Oct 25', 'Nov 25', 'Dec 25'];
    const data = [3, 2, 0, 10, 13, 0, 0, 0, 0, 0, 0, 0]; // Placeholder counts from image

    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Projects',
            data: data,
            backgroundColor: 'rgba(252, 165, 165, 0.8)', // light red from image
            borderColor: 'rgba(248, 113, 113, 1)', // red from image
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
             plugins: {
                legend: {
                    display: false, // Hide legend for this chart
                },
                tooltip: {
                     callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw;
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                     grid: {
                        color: 'rgba(156, 163, 175, 0.2)' // dark mode friendly grid lines
                    },
                    ticks: {
                        color: 'rgba(156, 163, 175, 1)' // dark mode friendly tick labels
                    }
                },
                y: {
                     beginAtZero: true,
                     grid: {
                        color: 'rgba(156, 163, 175, 0.2)' // dark mode friendly grid lines
                    },
                     ticks: {
                        color: 'rgba(156, 163, 175, 1)', // dark mode friendly tick labels
                        stepSize: 1,
                         callback: function(value) {
                            if (Number.isInteger(value)) {
                                return value;
                            }
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
