<?php $__env->startSection('title', 'Laporan'); ?>
<?php $__env->startSection('header-title', 'Laporan & Analisis'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Tombol Kembali ke Dashboard -->
    <div class="flex justify-end">
        <a href="<?php echo e(route('dashboard')); ?>" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-card p-6 cursor-pointer hover:border-emerald-400/70 transition-all transform hover:scale-[1.02]" onclick="window.location='<?php echo e(route('reports.performance')); ?>'">
            <div class="flex flex-col items-center text-center">
                <div class="text-5xl mb-3">📊</div>
                <h3 class="font-bold text-white text-lg">Laporan Performa</h3>
                <p class="text-gray-300 text-sm mt-1">Analisis pertumbuhan dan efisiensi</p>
            </div>
        </div>
        <div class="glass-card p-6 cursor-pointer hover:border-emerald-400/70 transition-all transform hover:scale-[1.02]" onclick="window.location='<?php echo e(route('reports.growth')); ?>'">
            <div class="flex flex-col items-center text-center">
                <div class="text-5xl mb-3">📈</div>
                <h3 class="font-bold text-white text-lg">Laporan Pertumbuhan</h3>
                <p class="text-gray-300 text-sm mt-1">Tracking berat badan ternak</p>
            </div>
        </div>
        <div class="glass-card p-6 cursor-pointer hover:border-emerald-400/70 transition-all transform hover:scale-[1.02]" onclick="window.location='#'">
            <div class="flex flex-col items-center text-center">
                <div class="text-5xl mb-3">💰</div>
                <h3 class="font-bold text-white text-lg">Laporan Keuangan</h3>
                <p class="text-gray-300 text-sm mt-1">Analisis biaya dan pendapatan <span class="text-xs text-emerald-400">(segera)</span></p>
            </div>
        </div>
    </div>

    
    <div class="glass-card p-6">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-chart-simple text-emerald-400"></i>
            <h2 class="font-bold text-white text-lg">Ringkasan Cepat</h2>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white/5 rounded-xl p-4 text-center border border-white/10">
                <i class="fas fa-paw text-emerald-400 text-xl mb-2 block"></i>
                <p class="text-gray-300 text-sm">Total Ternak</p>
                <p class="text-2xl font-bold text-white" id="total-livestock">-</p>
            </div>
            <div class="bg-white/5 rounded-xl p-4 text-center border border-white/10">
                <i class="fas fa-warehouse text-emerald-400 text-xl mb-2 block"></i>
                <p class="text-gray-300 text-sm">Total Kandang</p>
                <p class="text-2xl font-bold text-white" id="total-pens">-</p>
            </div>
            <div class="bg-white/5 rounded-xl p-4 text-center border border-white/10">
                <i class="fas fa-seedling text-emerald-400 text-xl mb-2 block"></i>
                <p class="text-gray-300 text-sm">Jenis Pakan</p>
                <p class="text-2xl font-bold text-white" id="total-feeds">-</p>
            </div>
            <div class="bg-white/5 rounded-xl p-4 text-center border border-white/10">
                <i class="fas fa-boxes text-emerald-400 text-xl mb-2 block"></i>
                <p class="text-gray-300 text-sm">Stok Pakan (kg)</p>
                <p class="text-2xl font-bold text-white" id="total-feed-stock">-</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', loadSummary);

async function loadSummary() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/reports/data?type=summary');
        if (response.success && response.data) {
            document.getElementById('total-livestock').innerText = (response.data.total_livestocks || 0).toLocaleString('id-ID');
            document.getElementById('total-pens').innerText = (response.data.total_pens || 0).toLocaleString('id-ID');
            document.getElementById('total-feeds').innerText = (response.data.total_feed_types || 0).toLocaleString('id-ID');
            document.getElementById('total-feed-stock').innerText = (response.data.total_feed_stock_kg || 0).toLocaleString('id-ID');
        } else {
            const errorMessage = response.message || 'Gagal memuat ringkasan';
            TernakPark.ui.showToast(errorMessage, 'error');
            // Tampilkan data kosong atau placeholder
            document.getElementById('total-livestock').innerText = '0';
            document.getElementById('total-pens').innerText = '0';
            document.getElementById('total-feeds').innerText = '0';
            document.getElementById('total-feed-stock').innerText = '0';
        }
    } catch (error) {
        console.error('Error loading summary:', error);
        TernakPark.ui.showToast('Koneksi error saat memuat ringkasan', 'error');
        document.getElementById('total-livestock').innerText = '0';
        document.getElementById('total-pens').innerText = '0';
        document.getElementById('total-feeds').innerText = '0';
        document.getElementById('total-feed-stock').innerText = '0';
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/reports/index.blade.php ENDPATH**/ ?>