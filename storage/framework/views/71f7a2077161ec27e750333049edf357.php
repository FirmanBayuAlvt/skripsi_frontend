<?php $__env->startSection('title', 'Laporan Pertumbuhan'); ?>
<?php $__env->startSection('header-title', 'Laporan Pertumbuhan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Tombol Kembali ke Laporan -->
    <div class="flex justify-end">
        <a href="<?php echo e(route('reports.index')); ?>" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Laporan
        </a>
    </div>

    <div class="glass-card p-6">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-chart-line text-emerald-400 text-xl"></i>
            <h2 class="font-bold text-white text-xl">Grafik Pertumbuhan Bobot (Rata-rata 4 Minggu Terakhir)</h2>
        </div>
        <canvas id="growthChart" height="300" class="w-full"></canvas>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let growthChartInstance = null;

document.addEventListener('DOMContentLoaded', async function() {
    await loadGrowthData();
});

async function loadGrowthData() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/reports/data?type=growth');
        if (response.success && response.data) {
            renderGrowthChart(response.data);
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data pertumbuhan', 'error');
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    }
}

function renderGrowthChart(data) {
    const canvas = document.getElementById('growthChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    if (growthChartInstance) {
        growthChartInstance.destroy();
    }

    // Gunakan data dari backend, atau fallback ke data kosong
    const labels = data.labels || ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
    const values = data.data || [0, 0, 0, 0];

    growthChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rata-rata Berat (kg)',
                data: values,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    labels: { color: '#e2e8f0', font: { weight: 'bold' } }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#a7f3d0',
                    bodyColor: '#cbd5e1',
                    callbacks: {
                        label: function(context) {
                            return `Berat: ${context.raw.toFixed(2)} kg`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#e2e8f0' },
                    grid: { color: 'rgba(255,255,255,0.05)' }
                },
                y: {
                    ticks: { color: '#e2e8f0' },
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    title: {
                        display: true,
                        text: 'Berat (kg)',
                        color: '#cbd5e1'
                    },
                    beginAtZero: true
                }
            }
        }
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/reports/growth.blade.php ENDPATH**/ ?>