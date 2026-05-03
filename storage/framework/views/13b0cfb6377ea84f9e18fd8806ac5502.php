<?php $__env->startSection('title', 'Penggunaan Pakan'); ?>
<?php $__env->startSection('header-title', 'Penggunaan Pakan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Tombol Kembali ke Manajemen Pakan -->
    <div class="flex justify-end">
        <a href="<?php echo e(route('feeds.index')); ?>" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Pakan
        </a>
    </div>

    
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-pen-alt text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Catat Pemakaian Pakan Harian</h3>
        </div>
        <form id="feeding-form" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" name="feeding_date" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-1">Jenis Pakan</label>
                    <select name="feed_id" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">Pilih Pakan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-1">Kandang (opsional)</label>
                    <select name="pen_id" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">Pilih Kandang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-1">Jumlah (kg)</label>
                    <input type="number" step="0.1" name="quantity_kg" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Catatan (opsional)</label>
                <textarea name="notes" rows="2" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-5 py-2.5 rounded-xl shadow-md transition transform hover:scale-105 flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Pemakaian
                </button>
            </div>
        </form>
    </div>

    
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-filter text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Filter Data Penggunaan</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Tanggal Mulai</label>
                <input type="date" id="filter-start-date" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Tanggal Akhir</label>
                <input type="date" id="filter-end-date" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Jenis Pakan</label>
                <select id="filter-feed-name" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Semua</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Kategori Kandang</label>
                <select id="filter-category" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Semua</option>
                    <option value="Kawin">Kawin</option>
                    <option value="Fattening">Fattening</option>
                    <option value="Melahirkan">Melahirkan</option>
                    <option value="Menyusui">Menyusui</option>
                    <option value="Prasapih">Prasapih</option>
                    <option value="Persiapan Breeding">Persiapan Breeding</option>
                    <option value="Karantina">Karantina</option>
                </select>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <button id="btn-apply-filter" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-5 py-2.5 rounded-xl shadow-md transition transform hover:scale-105 flex items-center gap-2">
                <i class="fas fa-search"></i> Terapkan Filter
            </button>
        </div>
    </div>

    
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-chart-line text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Penggunaan Pakan Per Bulan (kg)</h3>
        </div>
        <canvas id="monthlyUsageChart" height="300" class="w-full"></canvas>
    </div>

    
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-chart-simple text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Penggunaan Pakan Per Jenis (kg)</h3>
        </div>
        <canvas id="feedTypeChart" height="400" class="w-full"></canvas>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-table text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Penggunaan Pakan Harian</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tanggal</th>
                        <th class="px-3 py-2">Jenis Pakan</th>
                        <th class="px-3 py-2">Kandang</th>
                        <th class="px-3 py-2">Keluar (kg)</th>
                    </tr>
                </thead>
                <tbody id="daily-usage-table-body" class="text-gray-200"></tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let currentFilters = {};
let monthlyChart = null;
let feedTypeChart = null;

document.addEventListener('DOMContentLoaded', function() {
    loadFeedOptions();
    loadUsageData();
    loadFeedsForSelect();
    loadPensForSelect();

    const feedingForm = document.getElementById('feeding-form');
    if (feedingForm) {
        feedingForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';

            try {
                const response = await fetch('/web-api/feeds/feeding-record', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                if (result.success) {
                    TernakPark.ui.showToast('Pemakaian pakan dicatat', 'success');
                    this.reset();
                    await loadUsageData();
                } else {
                    TernakPark.ui.showToast(result.message || 'Gagal mencatat pemakaian', 'error');
                }
            } catch (error) {
                console.error(error);
                TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
    }

    const applyFilterButton = document.getElementById('btn-apply-filter');
    if (applyFilterButton) {
        applyFilterButton.addEventListener('click', function() {
            currentFilters = {
                start_date: document.getElementById('filter-start-date').value,
                end_date: document.getElementById('filter-end-date').value,
                feed_name: document.getElementById('filter-feed-name').value,
                category: document.getElementById('filter-category').value
            };
            loadUsageData();
        });
    }
});

async function loadFeedOptions() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/feeds/data?per_page=1000');
        if (response.success && response.data.feed_types) {
            const filterSelect = document.getElementById('filter-feed-name');
            filterSelect.innerHTML = '<option value="">Semua</option>';
            for (const feed of response.data.feed_types) {
                filterSelect.innerHTML += `<option value="${escapeHtml(feed.name)}">${escapeHtml(feed.name)}</option>`;
            }
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Gagal memuat opsi pakan', 'error');
    }
}

async function loadFeedsForSelect() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/feeds/data?per_page=1000');
        if (response.success && response.data.feed_types) {
            const feedSelect = document.querySelector('select[name="feed_id"]');
            feedSelect.innerHTML = '<option value="">Pilih Pakan</option>';
            for (const feed of response.data.feed_types) {
                feedSelect.innerHTML += `<option value="${feed.id}">${escapeHtml(feed.name)} (Stok: ${feed.current_stock} kg)</option>`;
            }
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Gagal memuat daftar pakan', 'error');
    }
}

async function loadPensForSelect() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/pens/data');
        if (response.success && response.data.pens) {
            const penSelect = document.querySelector('select[name="pen_id"]');
            penSelect.innerHTML = '<option value="">Pilih Kandang</option>';
            for (const pen of response.data.pens) {
                penSelect.innerHTML += `<option value="${pen.id}">${escapeHtml(pen.name)} (${escapeHtml(pen.category)})</option>`;
            }
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Gagal memuat daftar kandang', 'error');
    }
}

async function loadUsageData() {
    const queryParameters = new URLSearchParams();
    if (currentFilters.start_date) {
        queryParameters.append('start_date', currentFilters.start_date);
    }
    if (currentFilters.end_date) {
        queryParameters.append('end_date', currentFilters.end_date);
    }
    if (currentFilters.feed_name) {
        queryParameters.append('feed_name', currentFilters.feed_name);
    }
    if (currentFilters.category) {
        queryParameters.append('category', currentFilters.category);
    }

    try {
        const response = await TernakPark.api.fetchData(`/web-api/feeds/usage-data?${queryParameters.toString()}`);
        if (response.success && response.data) {
            const data = response.data;

            // Grafik penggunaan per bulan
            if (data.monthly_usage && data.monthly_usage.length > 0) {
                const bulanLabels = data.monthly_usage.map(item => item.month);
                const nilaiKg = data.monthly_usage.map(item => item.total_kg);

                if (monthlyChart !== null) {
                    monthlyChart.destroy();
                }
                monthlyChart = new Chart(document.getElementById('monthlyUsageChart'), {
                    type: 'bar',
                    data: {
                        labels: bulanLabels,
                        datasets: [{
                            label: 'Kg',
                            data: nilaiKg,
                            backgroundColor: '#10b981'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { labels: { color: '#e2e8f0' } }
                        },
                        scales: {
                            x: { ticks: { color: '#e2e8f0' } },
                            y: { ticks: { color: '#e2e8f0' } }
                        }
                    }
                });
            }

            // Grafik penggunaan per jenis pakan
            if (data.feed_type_usage && data.feed_type_usage.length > 0) {
                const jenisLabels = data.feed_type_usage.map(item => item.feed_name);
                const nilaiKg = data.feed_type_usage.map(item => item.total_kg);

                if (feedTypeChart !== null) {
                    feedTypeChart.destroy();
                }
                feedTypeChart = new Chart(document.getElementById('feedTypeChart'), {
                    type: 'bar',
                    data: {
                        labels: jenisLabels,
                        datasets: [{
                            label: 'Kg',
                            data: nilaiKg,
                            backgroundColor: '#3b82f6'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        indexAxis: 'y',
                        plugins: {
                            legend: { labels: { color: '#e2e8f0' } }
                        },
                        scales: {
                            x: { ticks: { color: '#e2e8f0' } },
                            y: { ticks: { color: '#e2e8f0' } }
                        }
                    }
                });
            }

            // Tabel penggunaan harian
            const tableBody = document.getElementById('daily-usage-table-body');
            if (data.daily_usage && data.daily_usage.length > 0) {
                let tableHtml = '';
                for (const row of data.daily_usage) {
                    tableHtml += `
                        <tr class="border-b border-white/10">
                            <td class="px-3 py-2">${escapeHtml(row.date)}</td>
                            <td class="px-3 py-2">${escapeHtml(row.feed_name)}</td>
                            <td class="px-3 py-2">${escapeHtml(row.pen_name || '-')}</td>
                            <td class="px-3 py-2 text-emerald-300 font-semibold">${row.quantity_kg}</td>
                        </tr>
                    `;
                }
                tableBody.innerHTML = tableHtml;
            } else {
                tableBody.innerHTML = '<td><td colspan="4" class="text-center py-6 text-gray-400">Belum ada数据</td><\/tr>';
            }
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data penggunaan', 'error');
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    }
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(match) {
        if (match === '&') return '&amp;';
        if (match === '<') return '&lt;';
        if (match === '>') return '&gt;';
        return match;
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/feeds/usage.blade.php ENDPATH**/ ?>