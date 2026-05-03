<?php $__env->startSection('title', 'Breeding - Anakan'); ?>
<?php $__env->startSection('header-title', 'Manajemen Anakan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="flex justify-end">
        <a href="<?php echo e(route('program.breeding')); ?>" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Breeding
        </a>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Total Anakan</p><p class="stat-value" id="total-anak">-</p></div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl"><i class="fas fa-baby text-emerald-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Anakan Jantan</p><p class="stat-value" id="jantan-count">-</p></div>
                <div class="bg-blue-500/20 p-3 rounded-2xl"><i class="fas fa-mars text-blue-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Anakan Betina</p><p class="stat-value" id="betina-count">-</p></div>
                <div class="bg-pink-500/20 p-3 rounded-2xl"><i class="fas fa-venus text-pink-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Rata-rata BB (kg)</p><p class="stat-value" id="avg-bb">-</p></div>
                <div class="bg-purple-500/20 p-3 rounded-2xl"><i class="fas fa-weight-scale text-purple-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Lepas Sapih</p><p class="stat-value text-emerald-300" id="lepas-sapih">-</p></div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl"><i class="fas fa-check-circle text-emerald-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Belum Lepas Sapih</p><p class="stat-value text-yellow-300" id="belum-lepas">-</p></div>
                <div class="bg-yellow-500/20 p-3 rounded-2xl"><i class="fas fa-clock text-yellow-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Anakan di Kandang Khusus</p><p class="stat-value" id="kandang-khusus">-</p></div>
                <div class="bg-indigo-500/20 p-3 rounded-2xl"><i class="fas fa-warehouse text-indigo-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Mortalitas</p><p class="stat-value text-red-300" id="mortalitas">-</p></div>
                <div class="bg-red-500/20 p-3 rounded-2xl"><i class="fas fa-skull-crossbones text-red-300 text-xl"></i></div>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-5">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
                <i class="fas fa-chart-pie text-emerald-400"></i>
                <h3 class="font-bold text-white text-lg">Distribusi Jenis Kelamin</h3>
            </div>
            <canvas id="genderChart" height="250" class="w-full"></canvas>
        </div>
        <div class="glass-card p-5">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
                <i class="fas fa-chart-line text-emerald-400"></i>
                <h3 class="font-bold text-white text-lg">Distribusi Umur (hari)</h3>
            </div>
            <canvas id="ageChart" height="250" class="w-full"></canvas>
        </div>
    </div>

    
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-filter text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Filter Data Anakan</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="text-gray-300 text-sm">Jenis Kelamin</label>
                <select id="filterGender" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua</option>
                    <option value="male">Jantan</option>
                    <option value="female">Betina</option>
                </select>
            </div>
            <div>
                <label class="text-gray-300 text-sm">Status Sapih</label>
                <select id="filterSapih" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua</option>
                    <option value="lepas">Sudah Lepas Sapih</option>
                    <option value="belum">Belum Lepas Sapih</option>
                </select>
            </div>
            <div>
                <label class="text-gray-300 text-sm">Induk (Ear Tag)</label>
                <select id="filterInduk" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua Induk</option>
                </select>
            </div>
            <div class="flex items-end">
                <button id="btnApplyFilter" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl shadow-md transition w-full">
                    <i class="fas fa-search mr-1"></i> Terapkan Filter
                </button>
            </div>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-table-list text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Anakan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Jenis Domba</th>
                        <th class="px-3 py-2">Kelamin</th>
                        <th class="px-3 py-2">BB (kg)</th>
                        <th class="px-3 py-2">Umur (hari)</th>
                        <th class="px-3 py-2">Induk Betina</th>
                        <th class="px-3 py-2">Induk Jantan</th>
                        <th class="px-3 py-2">Status Sapih</th>
                        <th class="px-3 py-2">Kandang</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="anakan-table-body">
                    <tr><td colspan="10" class="text-center py-8 text-gray-400">Memuat data...</tr>
                </tbody>
            </table>
        </div>
        <div id="pagination" class="p-5 border-t border-white/10 flex justify-between items-center"></div>
    </div>
</div>


<div id="modalDetailAnakan" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity"></div>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-black/40 backdrop-blur-md rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-white/20">
            <div class="px-6 pt-6 pb-4 sm:px-8 sm:pt-8">
                <div class="flex justify-between items-center border-b border-white/10 pb-3 mb-4">
                    <h3 class="text-xl font-bold text-white">📋 Detail Anakan</h3>
                    <button class="close-modal text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
                </div>
                <div id="detailAnakanInfo" class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm bg-white/5 rounded-xl p-4 border border-white/10">
                    <!-- Akan diisi JS -->
                </div>
                <div class="mt-6">
                    <h4 class="font-semibold text-white mb-2">📈 Riwayat Berat Badan</h4>
                    <canvas id="weightHistoryChart" height="200" class="w-full bg-white/5 rounded-xl p-2"></canvas>
                </div>
            </div>
            <div class="px-6 py-4 bg-white/5 sm:flex sm:flex-row-reverse sm:px-8">
                <button class="close-modal px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let genderChart, ageChart, weightHistoryChart;
let currentPage = 1;
let filters = {};

document.addEventListener('DOMContentLoaded', function() {
    loadAnakanData();
    loadIndukOptions();

    document.getElementById('btnApplyFilter').addEventListener('click', function() {
        filters = {
            gender: document.getElementById('filterGender').value,
            sapih: document.getElementById('filterSapih').value,
            induk: document.getElementById('filterInduk').value
        };
        currentPage = 1;
        loadAnakanData();
    });

    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('modalDetailAnakan').classList.add('hidden');
        });
    });
});

async function loadIndukOptions() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/livestocks/data?per_page=1000&gender=female&status=1');
        if (response.success && response.data.livestocks) {
            const select = document.getElementById('filterInduk');
            select.innerHTML = '<option value="">Semua Induk</option>';
            response.data.livestocks.forEach(function(induk) {
                select.innerHTML += '<option value="' + escapeHtml(induk.ear_tag) + '">' + escapeHtml(induk.ear_tag) + ' - ' + escapeHtml(induk.breed_type) + '</option>';
            });
        }
    } catch(error) {
        console.error(error);
        TernakPark.ui.showToast('Gagal memuat daftar induk', 'error');
    }
}

async function loadAnakanData() {
    try {
        let url = '/web-api/program/breeding/anakan?page=' + currentPage;
        if (filters.gender) url += '&gender=' + encodeURIComponent(filters.gender);
        if (filters.sapih) url += '&sapih=' + encodeURIComponent(filters.sapih);
        if (filters.induk) url += '&induk=' + encodeURIComponent(filters.induk);

        const response = await TernakPark.api.fetchData(url);
        if (response.success) {
            const data = response.data;
            // Statistik
            document.getElementById('total-anak').innerText = data.total_anak || 0;
            document.getElementById('jantan-count').innerText = data.jantan_count || 0;
            document.getElementById('betina-count').innerText = data.betina_count || 0;
            document.getElementById('avg-bb').innerText = (data.avg_bb || 0).toFixed(2);
            document.getElementById('lepas-sapih').innerText = data.lepas_sapih || 0;
            document.getElementById('belum-lepas').innerText = data.belum_lepas || 0;
            document.getElementById('kandang-khusus').innerText = data.kandang_khusus || 0;
            document.getElementById('mortalitas').innerText = data.mortalitas || 0;

            // Grafik gender
            if (genderChart) genderChart.destroy();
            genderChart = new Chart(document.getElementById('genderChart'), {
                type: 'pie',
                data: { labels: ['Jantan', 'Betina'], datasets: [{ data: [data.jantan_count || 0, data.betina_count || 0], backgroundColor: ['#3b82f6', '#ec4899'] }] }
            });

            // Grafik umur (distribusi)
            if (ageChart) ageChart.destroy();
            ageChart = new Chart(document.getElementById('ageChart'), {
                type: 'bar',
                data: { labels: data.age_labels || ['0-30','31-60','61-90','91-120','>120'], datasets: [{ label: 'Jumlah Anakan', data: data.age_distribution || [0,0,0,0,0], backgroundColor: '#f59e0b' }] }
            });

            // Tabel data anakan
            renderAnakanTable(data.anakan);
            renderPagination(data.pagination);
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data anakan', 'error');
        }
    } catch(error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
}

function renderAnakanTable(anakan) {
    const tbody = document.getElementById('anakan-table-body');
    if (!anakan || anakan.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>';
        return;
    }
    let html = '';
    anakan.forEach(function(item) {
        html += '<tr class="border-b border-white/10 hover:bg-white/5 transition">';
        html += '<td class="px-3 py-2 font-medium">' + escapeHtml(item.ear_tag) + '</td>';
        html += '<td class="px-3 py-2">' + escapeHtml(item.breed_type) + '</td>';
        html += '<td class="px-3 py-2">' + (item.gender === 'male' ? 'Jantan' : 'Betina') + '</td>';
        html += '<td class="px-3 py-2">' + (item.current_weight || '-') + '</td>';
        html += '<td class="px-3 py-2">' + (item.age_days || '-') + ' hari</td>';
        html += '<td class="px-3 py-2">' + escapeHtml(item.mother_ear_tag || '-') + '</td>';
        html += '<td class="px-3 py-2">' + escapeHtml(item.father_ear_tag || '-') + '</td>';
        html += '<td class="px-3 py-2"><span class="px-2 py-1 rounded-full text-xs ' + (item.is_weaned ? 'bg-emerald-500/20 text-emerald-200' : 'bg-yellow-500/20 text-yellow-200') + '">' + (item.is_weaned ? 'Lepas Sapih' : 'Belum Lepas Sapih') + '</span></td>';
        html += '<td class="px-3 py-2">' + escapeHtml(item.pen_name || '-') + '</td>';
        html += '<td class="px-3 py-2"><button class="btn-detail text-emerald-400 hover:text-emerald-300" data-id="' + item.id + '"><i class="fas fa-eye"></i> Detail</button></td>';
        html += '</tr>';
    });
    tbody.innerHTML = html;

    // Event listener untuk tombol detail
    document.querySelectorAll('.btn-detail').forEach(function(btn) {
        btn.addEventListener('click', function() {
            loadDetailAnakan(btn.getAttribute('data-id'));
        });
    });
}

function renderPagination(pagination) {
    const container = document.getElementById('pagination');
    if (!pagination || pagination.total <= pagination.per_page) {
        container.innerHTML = '';
        return;
    }
    const start = (pagination.current_page - 1) * pagination.per_page + 1;
    const end = Math.min(pagination.current_page * pagination.per_page, pagination.total);
    let html = '<div class="text-sm text-gray-400">Menampilkan ' + start + ' - ' + end + ' dari ' + pagination.total + '</div>';
    html += '<div class="flex space-x-2">';
    if (pagination.current_page > 1) {
        html += '<button onclick="changePage(' + (pagination.current_page - 1) + ')" class="px-3 py-1 bg-white/10 rounded-xl hover:bg-white/20">Prev</button>';
    }
    if (pagination.current_page < pagination.last_page) {
        html += '<button onclick="changePage(' + (pagination.current_page + 1) + ')" class="px-3 py-1 bg-white/10 rounded-xl hover:bg-white/20">Next</button>';
    }
    html += '</div>';
    container.innerHTML = html;
}

function changePage(page) {
    currentPage = page;
    loadAnakanData();
}

async function loadDetailAnakan(id) {
    try {
        const response = await TernakPark.api.fetchData('/web-api/livestocks/' + id + '/detail');
        if (response.success) {
            const data = response.data;
            const detailHtml = `
                <div><span class="text-gray-400">Tagging:</span> ${escapeHtml(data.ear_tag)}</div>
                <div><span class="text-gray-400">Jenis Domba:</span> ${escapeHtml(data.breed_type)}</div>
                <div><span class="text-gray-400">Jenis Kelamin:</span> ${data.gender === 'male' ? 'Jantan' : 'Betina'}</div>
                <div><span class="text-gray-400">BB Terbaru:</span> ${data.current_weight} kg</div>
                <div><span class="text-gray-400">Umur:</span> ${data.age_days} hari</div>
                <div><span class="text-gray-400">Tanggal Lahir:</span> ${data.birth_date || '-'}</div>
                <div><span class="text-gray-400">Induk Jantan:</span> ${escapeHtml(data.father_ear_tag || '-')}</div>
                <div><span class="text-gray-400">Induk Betina:</span> ${escapeHtml(data.mother_ear_tag || '-')}</div>
                <div><span class="text-gray-400">Kandang:</span> ${escapeHtml(data.pen?.name || '-')}</div>
                <div><span class="text-gray-400">Status:</span> ${data.status ? 'Aktif' : 'Tidak Aktif'}</div>
                <div><span class="text-gray-400">Kondisi:</span> ${escapeHtml(data.condition || '-')}</div>
                <div><span class="text-gray-400">Catatan:</span> ${escapeHtml(data.notes || '-')}</div>
            `;
            document.getElementById('detailAnakanInfo').innerHTML = detailHtml;

            // Grafik riwayat berat
            const weightRecords = data.weight_records || [];
            const labels = weightRecords.map(function(w) { return new Date(w.record_date).toLocaleDateString('id-ID'); });
            const values = weightRecords.map(function(w) { return w.weight_kg; });
            if (weightHistoryChart) weightHistoryChart.destroy();
            const ctx = document.getElementById('weightHistoryChart').getContext('2d');
            weightHistoryChart = new Chart(ctx, {
                type: 'line',
                data: { labels: labels.length ? labels : ['Belum ada data'], datasets: [{ label: 'Berat (kg)', data: values.length ? values : [0], borderColor: '#10b981', fill: false }] }
            });
            document.getElementById('modalDetailAnakan').classList.remove('hidden');
        } else {
            TernakPark.ui.showToast('Gagal memuat detail anakan', 'error');
        }
    } catch(error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error', 'error');
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/program/breeding-anakan.blade.php ENDPATH**/ ?>