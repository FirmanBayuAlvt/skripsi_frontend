<?php $__env->startSection('title', 'Breeding - Data Kawin & IB'); ?>
<?php $__env->startSection('header-title', 'Data Kawin & Inseminasi Buatan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="flex justify-end">
        <a href="<?php echo e(route('dashboard')); ?>" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Total Perkawinan</p><p class="stat-value" id="total-kawin">-</p></div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl"><i class="fas fa-heartbeat text-emerald-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Kawin Alami</p><p class="stat-value" id="kawin-alami">-</p></div>
                <div class="bg-blue-500/20 p-3 rounded-2xl"><i class="fas fa-venus-mars text-blue-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Inseminasi Buatan (IB)</p><p class="stat-value" id="total-ib">-</p></div>
                <div class="bg-purple-500/20 p-3 rounded-2xl"><i class="fas fa-syringe text-purple-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Tingkat Keberhasilan</p><p class="stat-value" id="success-rate">-</p></div>
                <div class="bg-yellow-500/20 p-3 rounded-2xl"><i class="fas fa-chart-line text-yellow-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Betina Bunting</p><p class="stat-value" id="pregnant-count">-</p></div>
                <div class="bg-pink-500/20 p-3 rounded-2xl"><i class="fas fa-fetus text-pink-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Perkawinan Bulan Ini</p><p class="stat-value" id="monthly-count">-</p></div>
                <div class="bg-indigo-500/20 p-3 rounded-2xl"><i class="fas fa-calendar-week text-indigo-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Pejantan Aktif</p><p class="stat-value" id="active-male">-</p></div>
                <div class="bg-amber-500/20 p-3 rounded-2xl"><i class="fas fa-male text-amber-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Petugas IB</p><p class="stat-value" id="ib-officer">-</p></div>
                <div class="bg-rose-500/20 p-3 rounded-2xl"><i class="fas fa-user-md text-rose-300 text-xl"></i></div>
            </div>
        </div>
    </div>

    
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-chart-line text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Tren Keberhasilan Perkawinan per Bulan</h3>
        </div>
        <canvas id="successTrendChart" height="250" class="w-full"></canvas>
    </div>

    
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-filter text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Filter Data Perkawinan</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="text-gray-300 text-sm">Tipe</label>
                <select id="filterType" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua</option>
                    <option value="kawin">Kawin Alami</option>
                    <option value="ib">Inseminasi Buatan</option>
                </select>
            </div>
            <div>
                <label class="text-gray-300 text-sm">Status</label>
                <select id="filterStatus" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua</option>
                    <option value="success">Berhasil (Bunting)</option>
                    <option value="failed">Gagal</option>
                    <option value="pending">Proses</option>
                </select>
            </div>
            <div>
                <label class="text-gray-300 text-sm">Tanggal Mulai</label>
                <input type="date" id="filterStartDate" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
            </div>
            <div>
                <label class="text-gray-300 text-sm">Tanggal Akhir</label>
                <input type="date" id="filterEndDate" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
            </div>
            <div class="flex items-end">
                <button id="btnApplyFilter" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl shadow-md transition w-full">
                    <i class="fas fa-search mr-1"></i> Terapkan Filter
                </button>
            </div>
        </div>
    </div>

    
    <div class="flex border-b border-white/10">
        <button id="tabKawin" class="tab-button px-6 py-3 text-white font-medium border-b-2 border-emerald-500 transition">Kawin Alami</button>
        <button id="tabIB" class="tab-button px-6 py-3 text-gray-400 font-medium hover:text-white transition">Inseminasi Buatan (IB)</button>
    </div>

    
    <div id="tableKawin" class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-venus-mars text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Kawin Alami</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tanggal Kawin</th>
                        <th class="px-3 py-2">Betina (Tag)</th>
                        <th class="px-3 py-2">Pejantan (Tag)</th>
                        <th class="px-3 py-2">Kandang</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Tanggal Bunting</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="kawin-table-body">
                    <tr><td colspan="7" class="text-center py-8 text-gray-400">Memuat data...</tr>
                </tbody>
            </table>
        </div>
        <div id="paginationKawin" class="p-5 border-t border-white/10 flex justify-between items-center"></div>
    </div>

    
    <div id="tableIB" class="glass-card p-0 overflow-hidden hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-syringe text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Inseminasi Buatan (IB)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tanggal IB</th>
                        <th class="px-3 py-2">Betina (Tag)</th>
                        <th class="px-3 py-2">Sumber Semen</th>
                        <th class="px-3 py-2">Petugas</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Tanggal Bunting</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="ib-table-body">
                    <tr><td colspan="7" class="text-center py-8 text-gray-400">Memuat data...</td>
                </tbody>
            </table>
        </div>
        <div id="paginationIB" class="p-5 border-t border-white/10 flex justify-between items-center"></div>
    </div>
</div>


<div id="modalDetailKawin" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity"></div>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-black/40 backdrop-blur-md rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-white/20">
            <div class="px-6 pt-6 pb-4 sm:px-8 sm:pt-8">
                <div class="flex justify-between items-center border-b border-white/10 pb-3 mb-4">
                    <h3 class="text-xl font-bold text-white">📋 Detail Perkawinan / IB</h3>
                    <button class="close-modal text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
                </div>
                <div id="detailKawinInfo" class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm bg-white/5 rounded-xl p-4 border border-white/10">
                    <!-- Akan diisi JS -->
                </div>
                <div class="mt-6">
                    <h4 class="font-semibold text-white mb-2">📝 Catatan Tambahan</h4>
                    <div id="detailNotes" class="bg-white/5 p-3 rounded-xl text-gray-300 text-sm"></div>
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
// ==================== VARIABLES ====================
let successTrendChart = null;
let currentTab = 'kawin';
let currentPageKawin = 1;
let currentPageIB = 1;
let filters = {};

// ==================== EVENT LISTENERS ====================
document.addEventListener('DOMContentLoaded', function() {
    loadKawinIbData();
    setupEventListeners();
});

function setupEventListeners() {
    const tabKawin = document.getElementById('tabKawin');
    const tabIB = document.getElementById('tabIB');
    const btnApplyFilter = document.getElementById('btnApplyFilter');
    const closeModalButtons = document.querySelectorAll('.close-modal');
    const modalDetail = document.getElementById('modalDetailKawin');

    if (tabKawin) {
        tabKawin.addEventListener('click', function() {
            currentTab = 'kawin';
            document.getElementById('tableKawin').classList.remove('hidden');
            document.getElementById('tableIB').classList.add('hidden');
            tabKawin.classList.add('border-b-2', 'border-emerald-500', 'text-white');
            tabKawin.classList.remove('text-gray-400');
            if (tabIB) {
                tabIB.classList.remove('border-b-2', 'border-emerald-500', 'text-white');
                tabIB.classList.add('text-gray-400');
            }
            loadKawinTable();
        });
    }

    if (tabIB) {
        tabIB.addEventListener('click', function() {
            currentTab = 'ib';
            document.getElementById('tableKawin').classList.add('hidden');
            document.getElementById('tableIB').classList.remove('hidden');
            tabIB.classList.add('border-b-2', 'border-emerald-500', 'text-white');
            tabIB.classList.remove('text-gray-400');
            if (tabKawin) {
                tabKawin.classList.remove('border-b-2', 'border-emerald-500', 'text-white');
                tabKawin.classList.add('text-gray-400');
            }
            loadIBTable();
        });
    }

    if (btnApplyFilter) {
        btnApplyFilter.addEventListener('click', function() {
            filters = {
                type: document.getElementById('filterType')?.value || '',
                status: document.getElementById('filterStatus')?.value || '',
                start_date: document.getElementById('filterStartDate')?.value || '',
                end_date: document.getElementById('filterEndDate')?.value || ''
            };
            currentPageKawin = 1;
            currentPageIB = 1;
            loadKawinIbData();
        });
    }

    if (closeModalButtons) {
        closeModalButtons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (modalDetail) modalDetail.classList.add('hidden');
            });
        });
    }
}

// ==================== LOAD MAIN DATA ====================
async function loadKawinIbData() {
    try {
        let url = '/web-api/program/breeding/kawin-ib';
        const queryParams = new URLSearchParams();
        if (filters.type) queryParams.append('type', filters.type);
        if (filters.status) queryParams.append('status', filters.status);
        if (filters.start_date) queryParams.append('start_date', filters.start_date);
        if (filters.end_date) queryParams.append('end_date', filters.end_date);
        if (queryParams.toString()) url += '?' + queryParams.toString();

        const response = await TernakPark.api.fetchData(url);
        if (response.success && response.data) {
            const data = response.data;
            document.getElementById('total-kawin').innerText = data.total_kawin || 0;
            document.getElementById('kawin-alami').innerText = data.kawin_alami || 0;
            document.getElementById('total-ib').innerText = data.total_ib || 0;
            document.getElementById('success-rate').innerText = (data.success_rate || 0).toFixed(1) + '%';
            document.getElementById('pregnant-count').innerText = data.pregnant_count || 0;
            document.getElementById('monthly-count').innerText = data.monthly_count || 0;
            document.getElementById('active-male').innerText = data.active_male || 0;
            document.getElementById('ib-officer').innerText = data.ib_officer || 0;

            if (successTrendChart) successTrendChart.destroy();
            const chartCanvas = document.getElementById('successTrendChart');
            if (chartCanvas && data.trend_labels && data.trend_values) {
                successTrendChart = new Chart(chartCanvas, {
                    type: 'line',
                    data: {
                        labels: data.trend_labels,
                        datasets: [{
                            label: 'Keberhasilan (%)',
                            data: data.trend_values,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: true }
                });
            }
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data', 'error');
        }
    } catch (error) {
        console.error('loadKawinIbData error:', error);
        TernakPark.ui.showToast('Koneksi error saat memuat data utama', 'error');
    }

    if (currentTab === 'kawin') {
        await loadKawinTable();
    } else {
        await loadIBTable();
    }
}

// ==================== LOAD KAWIN TABLE ====================
async function loadKawinTable() {
    try {
        const queryParams = new URLSearchParams();
        queryParams.append('page', currentPageKawin);
        if (filters.status) queryParams.append('status', filters.status);
        if (filters.start_date) queryParams.append('start_date', filters.start_date);
        if (filters.end_date) queryParams.append('end_date', filters.end_date);

        const response = await TernakPark.api.fetchData('/web-api/program/breeding/kawin-ib?' + queryParams.toString());
        if (response.success && response.data) {
            renderKawinTable(response.data.kawin || []);
            renderPagination('paginationKawin', response.data.pagination, 'kawin');
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data kawin', 'error');
            document.getElementById('kawin-table-body').innerHTML = '<td><td colspan="7" class="text-center py-8 text-red-400">Gagal memuat data</td></tr>';
        }
    } catch (error) {
        console.error('loadKawinTable error:', error);
        TernakPark.ui.showToast('Koneksi error', 'error');
        document.getElementById('kawin-table-body').innerHTML = '<tr><td colspan="7" class="text-center py-8 text-red-400">Koneksi error</td></tr>';
    }
}

// ==================== LOAD IB TABLE ====================
async function loadIBTable() {
    try {
        const queryParams = new URLSearchParams();
        queryParams.append('page', currentPageIB);
        if (filters.status) queryParams.append('status', filters.status);
        if (filters.start_date) queryParams.append('start_date', filters.start_date);
        if (filters.end_date) queryParams.append('end_date', filters.end_date);
        queryParams.append('type', 'ib');

        const response = await TernakPark.api.fetchData('/web-api/program/breeding/kawin-ib?' + queryParams.toString());
        if (response.success && response.data) {
            renderIBTable(response.data.ib || []);
            renderPagination('paginationIB', response.data.ib_pagination || response.data.pagination, 'ib');
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data IB', 'error');
            document.getElementById('ib-table-body').innerHTML = '<tr><td colspan="7" class="text-center py-8 text-red-400">Gagal memuat data</td></tr>';
        }
    } catch (error) {
        console.error('loadIBTable error:', error);
        TernakPark.ui.showToast('Koneksi error', 'error');
        document.getElementById('ib-table-body').innerHTML = '<tr><td colspan="7" class="text-center py-8 text-red-400">Koneksi error</td></tr>';
    }
}

// ==================== RENDER TABLES ====================
function renderKawinTable(data) {
    const tbody = document.getElementById('kawin-table-body');
    if (!data || data.length === 0) {
        tbody.innerHTML = '<table><td colspan="7" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>';
        return;
    }

    let html = '';
    for (const item of data) {
        let statusClass = '';
        let statusText = '';
        if (item.status === 'success') {
            statusClass = 'bg-emerald-500/20 text-emerald-200';
            statusText = 'Berhasil (Bunting)';
        } else if (item.status === 'failed') {
            statusClass = 'bg-red-500/20 text-red-200';
            statusText = 'Gagal';
        } else {
            statusClass = 'bg-yellow-500/20 text-yellow-200';
            statusText = 'Proses';
        }
        html += `
            <tr class="border-b border-white/10 hover:bg-white/5 transition">
                <td class="px-3 py-2">${escapeHtml(item.mating_date)}</td>
                <td class="px-3 py-2">${escapeHtml(item.female_tag)}</td>
                <td class="px-3 py-2">${escapeHtml(item.male_tag)}</td>
                <td class="px-3 py-2">${escapeHtml(item.pen_name)}</td>
                <td class="px-3 py-2"><span class="px-2 py-1 rounded-full text-xs ${statusClass}">${statusText}</span></td>
                <td class="px-3 py-2">${item.pregnancy_date || '-'}</td>
                <td class="px-3 py-2"><button class="btn-detail-kawin text-emerald-400 hover:text-emerald-300" data-id="${item.id}" data-type="kawin"><i class="fas fa-eye"></i> Detail</button></td>
            </tr>
        `;
    }
    tbody.innerHTML = html;

    document.querySelectorAll('.btn-detail-kawin').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const type = this.getAttribute('data-type');
            loadDetailKawin(id, type);
        });
    });
}

function renderIBTable(data) {
    const tbody = document.getElementById('ib-table-body');
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>';
        return;
    }

    let html = '';
    for (const item of data) {
        let statusClass = '';
        let statusText = '';
        if (item.status === 'success') {
            statusClass = 'bg-emerald-500/20 text-emerald-200';
            statusText = 'Berhasil (Bunting)';
        } else if (item.status === 'failed') {
            statusClass = 'bg-red-500/20 text-red-200';
            statusText = 'Gagal';
        } else {
            statusClass = 'bg-yellow-500/20 text-yellow-200';
            statusText = 'Proses';
        }
        html += `
            <tr class="border-b border-white/10 hover:bg-white/5 transition">
                <td class="px-3 py-2">${escapeHtml(item.ib_date)}</td>
                <td class="px-3 py-2">${escapeHtml(item.female_tag)}</td>
                <td class="px-3 py-2">${escapeHtml(item.semen_source)}</td>
                <td class="px-3 py-2">${escapeHtml(item.officer_name)}</td>
                <td class="px-3 py-2"><span class="px-2 py-1 rounded-full text-xs ${statusClass}">${statusText}</span></td>
                <td class="px-3 py-2">${item.pregnancy_date || '-'}</td>
                <td class="px-3 py-2"><button class="btn-detail-ib text-emerald-400 hover:text-emerald-300" data-id="${item.id}" data-type="ib"><i class="fas fa-eye"></i> Detail</button></td>
            </tr>
        `;
    }
    tbody.innerHTML = html;

    document.querySelectorAll('.btn-detail-ib').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const type = this.getAttribute('data-type');
            loadDetailKawin(id, type);
        });
    });
}

// ==================== PAGINATION ====================
function renderPagination(containerId, pagination, type) {
    const container = document.getElementById(containerId);
    if (!container) return;
    if (!pagination || pagination.total <= pagination.per_page) {
        container.innerHTML = '';
        return;
    }

    const start = (pagination.current_page - 1) * pagination.per_page + 1;
    const end = Math.min(pagination.current_page * pagination.per_page, pagination.total);
    let html = `<div class="text-sm text-gray-400">Menampilkan ${start} - ${end} dari ${pagination.total}</div>`;
    html += '<div class="flex space-x-2">';
    if (pagination.current_page > 1) {
        html += `<button onclick="changePage('${type}', ${pagination.current_page - 1})" class="px-3 py-1 bg-white/10 rounded-xl hover:bg-white/20">Prev</button>`;
    }
    if (pagination.current_page < pagination.last_page) {
        html += `<button onclick="changePage('${type}', ${pagination.current_page + 1})" class="px-3 py-1 bg-white/10 rounded-xl hover:bg-white/20">Next</button>`;
    }
    html += '</div>';
    container.innerHTML = html;
}

function changePage(type, page) {
    if (type === 'kawin') {
        currentPageKawin = page;
        loadKawinTable();
    } else if (type === 'ib') {
        currentPageIB = page;
        loadIBTable();
    }
}

// ==================== DETAIL ====================
async function loadDetailKawin(id, type) {
    try {
        const url = `/web-api/program/breeding/kawin-ib/detail?id=${id}&type=${type}`;
        const response = await TernakPark.api.fetchData(url);
        if (response.success && response.data) {
            const d = response.data;
            let infoHtml = '';
            if (type === 'kawin') {
                infoHtml = `
                    <div><span class="text-gray-400">Tanggal Kawin:</span> ${escapeHtml(d.mating_date)}</div>
                    <div><span class="text-gray-400">Betina:</span> ${escapeHtml(d.female_tag)}</div>
                    <div><span class="text-gray-400">Pejantan:</span> ${escapeHtml(d.male_tag)}</div>
                    <div><span class="text-gray-400">Kandang:</span> ${escapeHtml(d.pen_name)}</div>
                    <div><span class="text-gray-400">Status:</span> ${d.status === 'success' ? 'Berhasil (Bunting)' : (d.status === 'failed' ? 'Gagal' : 'Proses')}</div>
                    <div><span class="text-gray-400">Tanggal Bunting:</span> ${d.pregnancy_date || '-'}</div>
                    <div><span class="text-gray-400">Petugas:</span> ${escapeHtml(d.officer_name || '-')}</div>
                `;
            } else {
                infoHtml = `
                    <div><span class="text-gray-400">Tanggal IB:</span> ${escapeHtml(d.ib_date)}</div>
                    <div><span class="text-gray-400">Betina:</span> ${escapeHtml(d.female_tag)}</div>
                    <div><span class="text-gray-400">Sumber Semen:</span> ${escapeHtml(d.semen_source)}</div>
                    <div><span class="text-gray-400">Petugas:</span> ${escapeHtml(d.officer_name)}</div>
                    <div><span class="text-gray-400">Status:</span> ${d.status === 'success' ? 'Berhasil (Bunting)' : (d.status === 'failed' ? 'Gagal' : 'Proses')}</div>
                    <div><span class="text-gray-400">Tanggal Bunting:</span> ${d.pregnancy_date || '-'}</div>
                `;
            }
            document.getElementById('detailKawinInfo').innerHTML = infoHtml;
            document.getElementById('detailNotes').innerHTML = d.notes || 'Tidak ada catatan tambahan.';
            document.getElementById('modalDetailKawin').classList.remove('hidden');
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat detail', 'error');
        }
    } catch (error) {
        console.error('loadDetailKawin error:', error);
        TernakPark.ui.showToast('Koneksi error saat memuat detail', 'error');
    }
}

// ==================== UTILITIES ====================
function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/program/breeding-kawin-ib.blade.php ENDPATH**/ ?>