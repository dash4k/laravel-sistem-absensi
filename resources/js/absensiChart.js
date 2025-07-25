import Chart from 'chart.js/auto';

window.renderPegawaiChart = function (chartData) {
    const ctx = document.getElementById('pegawaiChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['On Duty', 'Off Duty', 'Istirahat', 'Belum Absen', 'Izin'],
            datasets: [{
                label: 'Pegawai',
                data: chartData,
                backgroundColor: ['#4ade80', '#f87171', '#facc15', '#9ca3af', '#bfdbfe'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#000000'
                    }
                }
            }
        }
    });
};