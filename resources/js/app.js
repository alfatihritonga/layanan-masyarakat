import './bootstrap';
import Chart from 'chart.js/auto';

const trendCanvas = document.getElementById('yearlyTrendChart');

if (trendCanvas) {
    const years = JSON.parse(trendCanvas.dataset.years || '[]');
    const totals = JSON.parse(trendCanvas.dataset.totals || '[]');
    const latestYear = years.at(-1);

    const backgroundColors = years.map((year) =>
        year === latestYear ? 'rgba(248, 113, 113, 0.9)' : 'rgba(148, 163, 184, 0.6)'
    );

    new Chart(trendCanvas, {
        type: 'bar',
        data: {
            labels: years,
            datasets: [
                {
                    label: 'Jumlah Kejadian',
                    data: totals,
                    backgroundColor: backgroundColors,
                    borderRadius: 8,
                    borderSkipped: false,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    enabled: true,
                },
            },
            scales: {
                x: {
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)',
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.08)',
                    },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)',
                        precision: 0,
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.08)',
                    },
                },
            },
        },
    });
}
