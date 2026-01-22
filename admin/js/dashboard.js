// /admin/js/dashboard.js

document.addEventListener('DOMContentLoaded', () => {
    
    // Check if Chart.js is loaded
    if(typeof Chart === 'undefined') {
        console.error("Chart.js not loaded");
        return;
    }

    const ctx = document.getElementById('salesChart').getContext('2d');

    // MOCK DATA: This is where you will inject JSON from PHP later
    // e.g., const salesData = <?php echo json_encode($salesArray); ?>;
    const salesData = [1200, 1900, 3000, 500, 2000, 3000, 4500];
    const labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Weekly Sales ($)',
                data: salesData,
                backgroundColor: 'rgba(233, 69, 96, 0.1)', // Matches your --accent-color
                borderColor: '#e94560',
                borderWidth: 2,
                tension: 0.4, // Smooth curves
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#e94560',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1a2e',
                    padding: 10
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f0f0' },
                    ticks: { callback: (val) => '$' + val }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});