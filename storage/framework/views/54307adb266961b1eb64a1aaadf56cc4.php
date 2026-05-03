<?php $__env->startSection('title', 'Pengadaan Pakan'); ?>
<?php $__env->startSection('header-title', 'Pengadaan Pakan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Tombol Kembali ke Manajemen Pakan -->
    <div class="flex justify-end">
        <a href="<?php echo e(route('feeds.index')); ?>" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Pakan
        </a>
    </div>

    <!-- Form Catat Pengadaan Pakan Baru dengan desain premium -->
    <div class="glass-card p-5">
        <h3 class="text-white font-semibold text-lg mb-4"><i class="fas fa-truck mr-2 text-emerald-400"></i> Catat Pengadaan Pakan Baru</h3>
        <form id="purchase-form" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" name="date" required class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Supplier</label>
                    <input type="text" name="supplier" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white placeholder:text-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Supplier (opsional)">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Bahan Pakan</label>
                    <input type="text" name="feed_name" required class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white placeholder:text-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Contoh: Rumput Pakchong">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Harga per unit</label>
                    <input type="number" step="0.01" name="price_per_unit" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white placeholder:text-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Harga (opsional)">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Quantity</label>
                    <input type="number" step="0.01" name="quantity" required class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white placeholder:text-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Satuan</label>
                    <input type="text" name="unit" value="kg" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white placeholder:text-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="kg / sak">
                </div>
            </div>
            <div>
                <label class="block text-gray-200 text-sm font-medium mb-1">Catatan</label>
                <textarea name="notes" rows="2" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white placeholder:text-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-5 py-2 rounded-xl shadow-md transition-all transform hover:scale-[1.02] flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Pengadaan
                </button>
            </div>
        </form>
    </div>

    <!-- Filter Data Pengadaan -->
    <div class="glass-card p-5">
        <h3 class="text-white font-semibold text-lg mb-4"><i class="fas fa-filter mr-2 text-emerald-400"></i> Filter Data Pengadaan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-200 text-sm font-medium mb-1">Tanggal Mulai</label>
                <input type="date" id="filter-start-date" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-gray-200 text-sm font-medium mb-1">Tanggal Akhir</label>
                <input type="date" id="filter-end-date" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-gray-200 text-sm font-medium mb-1">Bahan Pakan</label>
                <select id="filter-feed-name" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Semua</option>
                </select>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <button onclick="applyFilters()" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-5 py-2 rounded-xl shadow-md transition-all transform hover:scale-[1.02] flex items-center gap-2">
                <i class="fas fa-search"></i> Terapkan Filter
            </button>
        </div>
    </div>

    <!-- Grafik Pengadaan Per Bulan (Record Count) -->
    <div class="glass-card p-5">
        <h3 class="text-white font-semibold text-lg mb-4"><i class="fas fa-chart-bar mr-2 text-emerald-400"></i> Pengadaan Pakan Per Bulan (Jumlah Record)</h3>
        <canvas id="monthlyPurchaseChart" width="100%" height="300" style="max-height: 400px;"></canvas>
    </div>

    <!-- Tabel Realisasi Pengadaan -->
    <div class="glass-card p-5">
        <h3 class="text-white font-semibold text-lg mb-4"><i class="fas fa-list mr-2 text-emerald-400"></i> Realisasi Pengadaan Pakan</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-white/10 text-sm">
                <thead class="bg-white/5">
                    <tr class="text-gray-200">
                        <th class="px-2 py-1 border-b border-white/10">Tanggal</th>
                        <th class="px-2 py-1 border-b border-white/10">Supplier</th>
                        <th class="px-2 py-1 border-b border-white/10">Bahan</th>
                        <th class="px-2 py-1 border-b border-white/10">Harga/Qty</th>
                        <th class="px-2 py-1 border-b border-white/10">QTY (sak/kg)</th>
                    </tr>
                </thead>
                <tbody id="purchase-table-body" class="text-gray-200"></tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let currentFilters = {};
let purchaseChart = null;

document.addEventListener('DOMContentLoaded', function() {
    loadFeedOptions();
    loadProcurementData();

    const purchaseForm = document.getElementById('purchase-form');
    if (purchaseForm) {
        purchaseForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';
            try {
                const response = await fetch('/web-api/feeds/purchase-record', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                if (result.success) {
                    TernakPark.ui.showToast('Pengadaan pakan berhasil dicatat', 'success');
                    this.reset();
                    await loadProcurementData();
                } else {
                    TernakPark.ui.showToast(result.message || 'Gagal mencatat pengadaan', 'error');
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
});

async function loadFeedOptions() {
    const bahanList = [
        'Rumput Pakchong', 'Dedek', 'Ampas Tahu', 'Bungkil Sawit', 'Complete Feed', 'Radukan',
        'Silases Jagung', 'Silase Pakchong', 'DDGS (Ngoro)', 'Booster mixfeed', 'jagung halus',
        'pollard', 'Onggok', 'Ampas Kedelai', 'Tetes Tebu', 'Bubuk Kacang Hijau', 'Tumpi Lembut',
        'Ampas Bir', 'Pongkol Ketela', 'Daun Gembilina', 'Rumput Gajah', 'Rumput Odot', 'Creepfeed'
    ];
    const filterSelect = document.getElementById('filter-feed-name');
    filterSelect.innerHTML = '<option value="">Semua</option>';
    for (const bahan of bahanList) {
        filterSelect.innerHTML += `<option value="${escapeHtml(bahan)}">${escapeHtml(bahan)}</option>`;
    }
}

async function loadProcurementData() {
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

    try {
        const response = await TernakPark.api.fetchData(`/web-api/feeds/procurement-data?${queryParameters.toString()}`);
        if (response.success) {
            const data = response.data;
            // Grafik bulanan
            if (data.monthly_purchase_count && data.monthly_purchase_count.length > 0) {
                const bulanLabels = data.monthly_purchase_count.map(item => item.month);
                const recordCounts = data.monthly_purchase_count.map(item => item.total_records);
                if (purchaseChart) {
                    purchaseChart.destroy();
                }
                purchaseChart = new Chart(document.getElementById('monthlyPurchaseChart'), {
                    type: 'bar',
                    data: {
                        labels: bulanLabels,
                        datasets: [{
                            label: 'Jumlah Record',
                            data: recordCounts,
                            backgroundColor: '#f59e0b'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                labels: { color: '#e2e8f0' }
                            }
                        },
                        scales: {
                            x: {
                                ticks: { color: '#e2e8f0' }
                            },
                            y: {
                                ticks: { color: '#e2e8f0' }
                            }
                        }
                    }
                });
            }
            // Tabel realisasi
            const tableBody = document.getElementById('purchase-table-body');
            if (data.purchases && data.purchases.length > 0) {
                let html = '';
                for (const purchase of data.purchases) {
                    html += `
                        <tr>
                            <td class="border-b border-white/10 px-2 py-1">${escapeHtml(purchase.date)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1">${escapeHtml(purchase.supplier)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1">${escapeHtml(purchase.feed_name)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1">${formatRupiah(purchase.price_per_unit)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1">${purchase.quantity} ${purchase.unit}<\/td>
                        </tr>
                    `;
                }
                tableBody.innerHTML = html;
            } else {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-gray-400">Belum ada data<\/td><\/tr>';
            }
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data pengadaan', 'error');
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    }
}

function applyFilters() {
    currentFilters = {
        start_date: document.getElementById('filter-start-date').value,
        end_date: document.getElementById('filter-end-date').value,
        feed_name: document.getElementById('filter-feed-name').value
    };
    loadProcurementData();
}

function formatRupiah(angka) {
    if (angka === undefined || angka === null || angka === 0) return 'Rp 0';
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/feeds/procurement.blade.php ENDPATH**/ ?>