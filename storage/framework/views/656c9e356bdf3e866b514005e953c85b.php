<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('header-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Global background gradient mewah */
    body {
        background: radial-gradient(ellipse at 20% 30%, #0b3b2a, #031a0e) fixed !important;
        margin: 0;
        padding: 0;
    }
    /* Smooth scrolling */
    html, body {
        scroll-behavior: smooth;
    }
    /* Cards dengan efek glassmorphism premium */
    .glass-card {
        background: rgba(10, 30, 20, 0.55);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(72, 187, 120, 0.25);
        border-radius: 2rem;
        box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.4);
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }
    .glass-card:hover {
        border-color: rgba(72, 187, 120, 0.7);
        transform: translateY(-4px);
        box-shadow: 0 28px 40px -16px rgba(0, 0, 0, 0.5);
    }
    /* Stat card khusus */
    .stat-card {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: 0.25s;
    }
    .stat-card:hover {
        border-color: #10b981;
        background: rgba(0, 0, 0, 0.6);
        transform: translateY(-3px);
    }
    /* Teks putih dengan ketebalan tepat */
    .text-premium {
        color: #f1f5f9;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        letter-spacing: -0.01em;
    }
    .stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        background: linear-gradient(135deg, #fff, #a7f3d0);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-shadow: none;
    }
    /* Tombol aksi */
    .action-btn {
        transition: 0.2s;
        border: none;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .action-btn:hover {
        transform: scale(1.02);
        filter: brightness(1.05);
    }
    /* Tabel */
    .custom-table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        color: #9ca3af;
    }
    .custom-table td {
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding: 1rem 0.75rem;
    }
    .custom-table tr:hover td {
        background: rgba(72, 187, 120, 0.1);
    }
    /* Scrollbar kustom */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    ::-webkit-scrollbar-track {
        background: #1e2a2e;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
        background: #2c7a4d;
        border-radius: 10px;
    }
</style>

<div class="space-y-8">
    <!-- Hero premium dengan efek gradien daun -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-950/90 via-emerald-900/95 to-teal-900/90 p-8 backdrop-blur-sm border border-emerald-500/30 shadow-2xl">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-400 opacity-20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-teal-400 opacity-20 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-8 w-1 bg-gradient-to-b from-emerald-300 to-teal-500 rounded-full"></div>
                <p class="text-emerald-200 font-medium tracking-wide">MANAJEMEN DATA TERNAK</p>
            </div>
            <h2 class="text-4xl font-extrabold text-white tracking-tight">Selamat datang, <?php echo e(session('user')['name'] ?? 'Pengguna'); ?></h2>
            <p class="text-emerald-100/80 max-w-xl mt-2">Kendalikan seluruh operasional peternakan Anda dalam satu tampilan.</p>
        </div>
    </div>

    <!-- Kartu aksi cepat dengan varian warna premium -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        <!-- Detail Ternak (hijau) -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-700 to-emerald-900 p-5 border border-emerald-400/40 shadow-xl transition-all hover:shadow-2xl hover:-translate-y-1">
            <div class="flex flex-col">
                <span class="text-emerald-200 text-xs">Akses Cepat</span>
                <span class="text-white font-bold text-xl mt-1">Detail Ternak</span>
                <div class="mt-3">
                    <select id="select-ear-tag-card" class="w-full rounded-xl bg-white/90 text-gray-800 px-3 py-2 text-sm border-0 focus:ring-2 focus:ring-emerald-400">
                        <option value="">-- Pilih Ear Tag --</option>
                    </select>
                    <button id="btn-detail-ternak-card" class="mt-3 w-full bg-white/20 hover:bg-white/30 text-white font-bold py-2.5 rounded-xl backdrop-blur transition">🔍 Lihat Detail</button>
                </div>
            </div>
            <i class="fas fa-paw absolute -bottom-4 -right-4 text-7xl text-white/10 group-hover:scale-110 transition"></i>
        </div>

        <!-- Logbook (biru langit) -->
        <a href="<?php echo e(route('logbook.index')); ?>" class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-sky-700 to-sky-900 p-5 border border-sky-400/40 shadow-xl hover:shadow-2xl hover:-translate-y-1 flex justify-between items-center">
            <div>
                <span class="text-sky-200 text-xs">Catatan</span>
                <div class="text-white font-bold text-xl">Logbook</div>
            </div>
            <i class="fas fa-book-open text-white/40 text-4xl group-hover:scale-110 transition"></i>
        </a>

        <!-- HPP (emas) -->
        <a href="<?php echo e(route('hpp.index')); ?>" class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-700 to-amber-900 p-5 border border-amber-400/40 shadow-xl hover:shadow-2xl hover:-translate-y-1 flex justify-between items-center">
            <div>
                <span class="text-amber-200 text-xs">Biaya</span>
                <div class="text-white font-bold text-xl">HPP</div>
            </div>
            <i class="fas fa-coins text-white/40 text-4xl group-hover:scale-110 transition"></i>
        </a>

        <!-- Notifikasi (merah) -->
        <a href="<?php echo e(route('notifikasi.index')); ?>" class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-700 to-rose-900 p-5 border border-rose-400/40 shadow-xl hover:shadow-2xl hover:-translate-y-1 flex justify-between items-center">
            <div>
                <span class="text-rose-200 text-xs">Peringatan</span>
                <div class="text-white font-bold text-xl">Notifikasi</div>
            </div>
            <i class="fas fa-bell text-white/40 text-4xl group-hover:scale-110 transition"></i>
        </a>
    </div>

    <!-- Statistik utama dengan angka gradien -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Total Ternak</p>
                    <p class="stat-value" id="total-livestock">-</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-paw text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Di Kandang</p>
                    <p class="stat-value" id="livestock-in-pen">-</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-warehouse text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Terjual</p>
                    <p class="stat-value" id="livestock-sold">-</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-hand-holding-usd text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Disembelih</p>
                    <p class="stat-value" id="livestock-slaughtered">-</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-drumstick-bite text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Mati</p>
                    <p class="stat-value" id="livestock-dead">-</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-skull-crossbones text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Di Mitra</p>
                    <p class="stat-value" id="livestock-partner">-</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-handshake text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Total BB (kg)</p>
                    <p class="stat-value" id="total-weight">-</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-weight-hanging text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Mortalitas</p>
                    <p class="stat-value" id="mortality-percentage">- %</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-chart-line text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Program cards mewah -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-teal-600 to-emerald-800 p-6 shadow-2xl transition hover:scale-[1.01]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-teal-100 text-sm">PROGRAM</p>
                    <p class="text-3xl font-bold text-white">Fattening Domba</p>
                    <p class="text-6xl font-black text-white mt-4" id="qty-fattening">-</p>
                    <p class="text-teal-100 mt-2">ekor ternak</p>
                </div>
                <i class="fas fa-weight-hanging text-7xl text-white/20"></i>
            </div>
        </div>
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-violet-600 to-emerald-800 p-6 shadow-2xl transition hover:scale-[1.01]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-violet-100 text-sm">PROGRAM</p>
                    <p class="text-3xl font-bold text-white">Breeding Domba</p>
                    <p class="text-6xl font-black text-white mt-4" id="qty-breeding">-</p>
                    <p class="text-violet-100 mt-2">ekor ternak</p>
                </div>
                <i class="fas fa-heart text-7xl text-white/20"></i>
            </div>
        </div>
    </div>

    <!-- Tabel dan Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-5">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-3">
                <i class="fas fa-table text-emerald-400"></i>
                <h3 class="font-bold text-white">Distribusi Subkategori</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="custom-table w-full text-sm text-white">
                    <thead>
                        <tr>
                            <th>Kategori Kandang</th>
                            <th>Kelamin</th>
                            <th>Sub Kategori</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody id="subcategory-table">
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">Memuat data...
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="glass-card p-5">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-3">
                <i class="fas fa-chart-simple text-emerald-400"></i>
                <h3 class="font-bold text-white">Komposisi Jenis Ternak</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="custom-table w-full text-sm text-white">
                    <thead>
                        <tr>
                            <th>Jenis Domba</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="breed-table">
                        <tr>
                            <td colspan="2" class="text-center py-6 text-gray-400">Memuat data...
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grafik donut premium - tidak gepeng -->
    <div class="glass-card p-6">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-5">
            <i class="fas fa-venus-mars text-emerald-400"></i>
            <h3 class="font-bold text-white">Diagram Jumlah Ternak (Jenis Kelamin)</h3>
        </div>
        <div class="flex justify-center">
            <div class="w-80 h-80 md:w-96 md:h-96">
                <canvas id="genderChart" width="400" height="400" style="width: 100%; height: 100%; display: block;"></canvas>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardStatistics();
        loadEarTagOptions();
        var detailButton = document.getElementById('btn-detail-ternak-card');
        if (detailButton) {
            detailButton.addEventListener('click', function() {
                var earTagId = document.getElementById('select-ear-tag-card').value;
                if (earTagId && earTagId !== '') {
                    window.location.href = '/livestocks/' + earTagId;
                } else {
                    TernakPark.ui.showToast('Pilih ear tag terlebih dahulu', 'warning');
                }
            });
        }
    });

    async function loadEarTagOptions() {
        try {
            var response = await TernakPark.api.fetchData('/web-api/livestocks/data?per_page=1000');
            var selectElement = document.getElementById('select-ear-tag-card');
            if (response.success && response.data.livestocks && response.data.livestocks.length > 0) {
                var optionsHtml = '<option value="">-- Pilih Ear Tag --</option>';
                for (var i = 0; i < response.data.livestocks.length; i++) {
                    var livestock = response.data.livestocks[i];
                    optionsHtml += '<option value="' + livestock.id + '">' + escapeHtml(livestock.ear_tag) + ' (' + escapeHtml(livestock.breed_type) + ')</option>';
                }
                selectElement.innerHTML = optionsHtml;
            } else {
                selectElement.innerHTML = '<option value="">Tidak ada data ternak</option>';
            }
        } catch (error) {
            console.warn(error);
            document.getElementById('select-ear-tag-card').innerHTML = '<option value="">Gagal memuat data</option>';
        }
    }

    async function loadDashboardStatistics() {
        try {
            var response = await TernakPark.api.fetchData('/web-api/dashboard/statistics');
            if (response.success) {
                var data = response.data;
                document.getElementById('total-livestock').innerText = data.total_livestock || 0;
                document.getElementById('livestock-in-pen').innerText = data.livestock_in_pen || 0;
                document.getElementById('livestock-sold').innerText = data.livestock_sold || 0;
                document.getElementById('livestock-slaughtered').innerText = data.livestock_slaughtered || 0;
                document.getElementById('livestock-dead').innerText = data.livestock_dead || 0;
                document.getElementById('livestock-partner').innerText = data.livestock_partner || 0;
                document.getElementById('total-weight').innerText = data.total_weight || 0;
                document.getElementById('mortality-percentage').innerText = (data.mortality_percentage || 0) + '%';
                document.getElementById('qty-fattening').innerText = data.qty_fattening || 0;
                document.getElementById('qty-breeding').innerText = data.qty_breeding || 0;

                renderSubcategoryTable(data.subcategory_stats);
                renderBreedTable(data.breed_stats);
                renderGenderChart(data.gender_stats);
            } else {
                TernakPark.ui.showToast('Gagal memuat data dashboard', 'error');
            }
        } catch (error) {
            console.error(error);
            TernakPark.ui.showToast('Error koneksi', 'error');
        }
    }

    function renderSubcategoryTable(stats) {
        var tbody = document.getElementById('subcategory-table');
        if (!stats || stats.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center py-6 text-gray-400">Tidak ada</td></tr>';
            return;
        }
        var html = '';
        for (var i = 0; i < stats.length; i++) {
            var item = stats[i];
            html += '<tr>';
            html += '<td class="px-3">' + escapeHtml(item.kategori_kandang || '-') + '</td>';
            html += '<td class="px-3">' + escapeHtml(item.kelamin || '-') + '</td>';
            html += '<td class="px-3">' + escapeHtml(item.sub_kategori || '-') + '</td>';
            html += '<td class="text-emerald-300 font-semibold text-center">' + (item.qty || 0) + '</td>';
            html += '</tr>';
        }
        tbody.innerHTML = html;
    }

    function renderBreedTable(breeds) {
        var tbody = document.getElementById('breed-table');
        if (!breeds || Object.keys(breeds).length === 0) {
            tbody.innerHTML = '<tr><td colspan="2" class="text-center py-6 text-gray-400">Tidak ada data</td></tr>';
            return;
        }
        var html = '';
        for (var jenis in breeds) {
            if (breeds.hasOwnProperty(jenis)) {
                var qty = breeds[jenis];
                html += '<tr>';
                html += '<td class="px-3">' + escapeHtml(jenis) + '</td>';
                html += '<td class="text-emerald-300 font-semibold text-center">' + (qty || 0) + '</td>';
                html += '</tr>';
            }
        }
        tbody.innerHTML = html;
    }

    function renderGenderChart(gender) {
        var canvas = document.getElementById('genderChart');
        if (!canvas) return;
        var ctx = canvas.getContext('2d');
        if (window.genderChartInstance) {
            window.genderChartInstance.destroy();
        }
        var female = gender?.female || 0;
        var male = gender?.male || 0;
        window.genderChartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Betina', 'Jantan'],
                datasets: [{
                    data: [female, male],
                    backgroundColor: ['#f59e0b', '#10b981'],
                    borderWidth: 0,
                    borderRadius: 12,
                    spacing: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#e2e8f0',
                            font: { weight: 'bold' },
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var total = female + male;
                                var value = context.raw;
                                var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return context.label + ': ' + value + ' ekor (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(match) {
            if (match === '&') return '&amp;';
            if (match === '<') return '&lt;';
            if (match === '>') return '&gt;';
            return match;
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/dashboard.blade.php ENDPATH**/ ?>