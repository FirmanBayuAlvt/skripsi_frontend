@extends('layouts.app')

@section('title', 'Breeding - Pejantan')
@section('header-title', 'Manajemen Pejantan')

@section('content')
<div class="space-y-6">
    {{-- Tombol Kembali --}}
    <div class="flex justify-end">
        <a href="{{ route('program.breeding') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Breeding
        </a>
    </div>

    {{-- Kartu Statistik Pejantan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Total Pejantan</p><p class="stat-value" id="total-pejantan">-</p></div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl"><i class="fas fa-male text-emerald-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Pejantan Aktif</p><p class="stat-value" id="aktif-count">-</p></div>
                <div class="bg-green-500/20 p-3 rounded-2xl"><i class="fas fa-check-circle text-green-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Pejantan Tidak Aktif</p><p class="stat-value" id="nonaktif-count">-</p></div>
                <div class="bg-red-500/20 p-3 rounded-2xl"><i class="fas fa-ban text-red-300 text-xl"></i></div>
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
                <div><p class="text-gray-300 text-sm">Rata-rata Umur (hari)</p><p class="stat-value" id="avg-umur">-</p></div>
                <div class="bg-blue-500/20 p-3 rounded-2xl"><i class="fas fa-calendar-alt text-blue-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Pejantan di Kandang Kawin</p><p class="stat-value" id="kandang-kawin">-</p></div>
                <div class="bg-pink-500/20 p-3 rounded-2xl"><i class="fas fa-heart text-pink-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Pejantan di Karantina</p><p class="stat-value" id="karantina-count">-</p></div>
                <div class="bg-yellow-500/20 p-3 rounded-2xl"><i class="fas fa-shield-virus text-yellow-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Rata-rata ADG (kg/hari)</p><p class="stat-value" id="avg-adg">-</p></div>
                <div class="bg-indigo-500/20 p-3 rounded-2xl"><i class="fas fa-chart-line text-indigo-300 text-xl"></i></div>
            </div>
        </div>
    </div>

    {{-- Grafik Distribusi Pejantan --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-5">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
                <i class="fas fa-chart-pie text-emerald-400"></i>
                <h3 class="font-bold text-white text-lg">Status Pejantan</h3>
            </div>
            <canvas id="statusChart" height="250" class="w-full"></canvas>
        </div>
        <div class="glass-card p-5">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
                <i class="fas fa-chart-bar text-emerald-400"></i>
                <h3 class="font-bold text-white text-lg">Distribusi Berdasarkan Jenis Domba</h3>
            </div>
            <canvas id="breedChart" height="250" class="w-full"></canvas>
        </div>
    </div>

    {{-- Filter Data Pejantan --}}
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-filter text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Filter Data Pejantan</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="text-gray-300 text-sm">Status</label>
                <select id="filterStatus" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
            <div>
                <label class="text-gray-300 text-sm">Jenis Domba</label>
                <select id="filterBreed" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua</option>
                </select>
            </div>
            <div>
                <label class="text-gray-300 text-sm">Kandang</label>
                <select id="filterPen" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua</option>
                </select>
            </div>
            <div class="flex items-end">
                <button id="btnApplyFilter" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl shadow-md transition w-full">
                    <i class="fas fa-search mr-1"></i> Terapkan Filter
                </button>
            </div>
        </div>
    </div>

    {{-- Tabel Data Pejantan --}}
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-table-list text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Pejantan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Jenis Domba</th>
                        <th class="px-3 py-2">BB (kg)</th>
                        <th class="px-3 py-2">Umur (hari)</th>
                        <th class="px-3 py-2">ADG (kg/hari)</th>
                        <th class="px-3 py-2">Kandang</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Kondisi</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pejantan-table-body">
                    <tr><td colspan="9" class="text-center py-8 text-gray-400">Memuat data...</tr>
                </tbody>
            </table>
        </div>
        <div id="pagination" class="p-5 border-t border-white/10 flex justify-between items-center"></div>
    </div>
</div>

{{-- Modal Detail Pejantan --}}
<div id="modalDetailPejantan" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity"></div>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-black/40 backdrop-blur-md rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-white/20">
            <div class="px-6 pt-6 pb-4 sm:px-8 sm:pt-8">
                <div class="flex justify-between items-center border-b border-white/10 pb-3 mb-4">
                    <h3 class="text-xl font-bold text-white">📋 Detail Pejantan</h3>
                    <button class="close-modal text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
                </div>
                <div id="detailPejantanInfo" class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm bg-white/5 rounded-xl p-4 border border-white/10">
                    <!-- Akan diisi JS -->
                </div>
                <div class="mt-6">
                    <h4 class="font-semibold text-white mb-2">📈 Riwayat Berat Badan</h4>
                    <canvas id="weightHistoryChart" height="200" class="w-full bg-white/5 rounded-xl p-2"></canvas>
                </div>
                <div class="mt-6">
                    <h4 class="font-semibold text-white mb-2">📋 Riwayat Perkawinan</h4>
                    <div class="overflow-x-auto">
                        <table class="custom-table w-full text-sm">
                            <thead class="bg-white/5">
                                <tr class="text-gray-300 text-xs">
                                    <th class="px-3 py-2">Tanggal Kawin</th>
                                    <th class="px-3 py-2">Betina</th>
                                    <th class="px-3 py-2">Kandang</th>
                                    <th class="px-3 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody id="riwayatKawinTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-white/5 sm:flex sm:flex-row-reverse sm:px-8">
                <button class="close-modal px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let statusChart, breedChart, weightHistoryChart;
let currentPage = 1;
let filters = {};

document.addEventListener('DOMContentLoaded', function() {
    loadPejantanData();
    loadFilterOptions();

    document.getElementById('btnApplyFilter').addEventListener('click', function() {
        filters = {
            status: document.getElementById('filterStatus').value,
            breed: document.getElementById('filterBreed').value,
            pen: document.getElementById('filterPen').value
        };
        currentPage = 1;
        loadPejantanData();
    });

    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('modalDetailPejantan').classList.add('hidden');
        });
    });
});

async function loadFilterOptions() {
    try {
        const [breedRes, penRes] = await Promise.all([
            TernakPark.api.fetchData('/web-api/livestocks/data?per_page=1000&gender=male'),
            TernakPark.api.fetchData('/web-api/pens/data')
        ]);
        if (breedRes.success && breedRes.data.livestocks) {
            const breeds = [...new Set(breedRes.data.livestocks.map(l => l.breed_type))];
            const breedSelect = document.getElementById('filterBreed');
            breeds.forEach(b => {
                breedSelect.innerHTML += `<option value="${escapeHtml(b)}">${escapeHtml(b.replace(/_/g, ' '))}</option>`;
            });
        }
        if (penRes.success && penRes.data.pens) {
            const penSelect = document.getElementById('filterPen');
            penRes.data.pens.forEach(p => {
                penSelect.innerHTML += `<option value="${p.id}">${escapeHtml(p.name)}</option>`;
            });
        }
    } catch(e) {
        console.error(e);
        TernakPark.ui.showToast('Gagal memuat opsi filter', 'error');
    }
}

async function loadPejantanData() {
    try {
        let url = '/web-api/program/breeding/pejantan?page=' + currentPage;
        if (filters.status) url += '&status=' + encodeURIComponent(filters.status);
        if (filters.breed) url += '&breed=' + encodeURIComponent(filters.breed);
        if (filters.pen) url += '&pen=' + encodeURIComponent(filters.pen);

        const response = await TernakPark.api.fetchData(url);
        if (response.success) {
            const data = response.data;
            // Statistik
            document.getElementById('total-pejantan').innerText = data.total_pejantan || 0;
            document.getElementById('aktif-count').innerText = data.aktif_count || 0;
            document.getElementById('nonaktif-count').innerText = data.nonaktif_count || 0;
            document.getElementById('avg-bb').innerText = (data.avg_bb || 0).toFixed(2);
            document.getElementById('avg-umur').innerText = (data.avg_umur || 0).toFixed(0);
            document.getElementById('kandang-kawin').innerText = data.kandang_kawin || 0;
            document.getElementById('karantina-count').innerText = data.karantina_count || 0;
            document.getElementById('avg-adg').innerText = (data.avg_adg || 0).toFixed(3);

            // Grafik status (Aktif vs Tidak Aktif)
            if (statusChart) statusChart.destroy();
            statusChart = new Chart(document.getElementById('statusChart'), {
                type: 'pie',
                data: { labels: ['Aktif', 'Tidak Aktif'], datasets: [{ data: [data.aktif_count || 0, data.nonaktif_count || 0], backgroundColor: ['#10b981', '#ef4444'] }] }
            });

            // Grafik distribusi jenis domba
            if (breedChart) breedChart.destroy();
            breedChart = new Chart(document.getElementById('breedChart'), {
                type: 'bar',
                data: { labels: data.breed_labels || [], datasets: [{ label: 'Jumlah', data: data.breed_counts || [], backgroundColor: '#f59e0b' }] }
            });

            // Tabel data pejantan
            renderPejantanTable(data.pejantan);
            renderPagination(data.pagination);
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data pejantan', 'error');
        }
    } catch(error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
}

function renderPejantanTable(pejantan) {
    const tbody = document.getElementById('pejantan-table-body');
    if (!pejantan || pejantan.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" class="text-center py-8 text-gray-400">Tidak ada数据</td></tr>';
        return;
    }
    let html = '';
    pejantan.forEach(function(item) {
        html += '<tr class="border-b border-white/10 hover:bg-white/5 transition">';
        html += '<td class="px-3 py-2 font-medium">' + escapeHtml(item.ear_tag) + '</td>';
        html += '<td class="px-3 py-2">' + escapeHtml(item.breed_type) + '</td>';
        html += '<td class="px-3 py-2">' + (item.current_weight || '-') + '</td>';
        html += '<td class="px-3 py-2">' + (item.age_days || '-') + ' hari</td>';
        html += '<td class="px-3 py-2">' + (item.average_daily_gain ? item.average_daily_gain.toFixed(3) : '-') + '</td>';
        html += '<td class="px-3 py-2">' + escapeHtml(item.pen_name || '-') + '</td>';
        html += '<td class="px-3 py-2"><span class="px-2 py-1 rounded-full text-xs ' + (item.status ? 'bg-emerald-500/20 text-emerald-200' : 'bg-red-500/20 text-red-200') + '">' + (item.status ? 'Aktif' : 'Tidak Aktif') + '</span></td>';
        html += '<td class="px-3 py-2">' + escapeHtml(item.condition || '-') + '</td>';
        html += '<td class="px-3 py-2"><button class="btn-detail text-emerald-400 hover:text-emerald-300" data-id="' + item.id + '"><i class="fas fa-eye"></i> Detail</button></td>';
        html += '</tr>';
    });
    tbody.innerHTML = html;

    document.querySelectorAll('.btn-detail').forEach(function(btn) {
        btn.addEventListener('click', function() {
            loadDetailPejantan(btn.getAttribute('data-id'));
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
    loadPejantanData();
}

async function loadDetailPejantan(id) {
    try {
        const response = await TernakPark.api.fetchData('/web-api/livestocks/' + id + '/detail');
        if (response.success) {
            const data = response.data;
            const detailHtml = `
                <div><span class="text-gray-400">Tagging:</span> ${escapeHtml(data.ear_tag)}</div>
                <div><span class="text-gray-400">Jenis Domba:</span> ${escapeHtml(data.breed_type)}</div>
                <div><span class="text-gray-400">BB Terbaru:</span> ${data.current_weight} kg</div>
                <div><span class="text-gray-400">Umur:</span> ${data.age_days} hari</div>
                <div><span class="text-gray-400">ADG:</span> ${data.average_daily_gain?.toFixed(3) || '-'} kg/hari</div>
                <div><span class="text-gray-400">Tanggal Lahir:</span> ${data.birth_date || '-'}</div>
                <div><span class="text-gray-400">Kandang:</span> ${escapeHtml(data.pen?.name || '-')}</div>
                <div><span class="text-gray-400">Status:</span> ${data.status ? 'Aktif' : 'Tidak Aktif'}</div>
                <div><span class="text-gray-400">Kondisi:</span> ${escapeHtml(data.condition || '-')}</div>
                <div><span class="text-gray-400">Kesehatan:</span> ${escapeHtml(data.health_status || '-')}</div>
                <div><span class="text-gray-400">Catatan:</span> ${escapeHtml(data.notes || '-')}</div>
            `;
            document.getElementById('detailPejantanInfo').innerHTML = detailHtml;

            // Grafik riwayat berat
            const weightRecords = data.weight_records || [];
            const labels = weightRecords.map(w => new Date(w.record_date).toLocaleDateString('id-ID'));
            const values = weightRecords.map(w => w.weight_kg);
            if (weightHistoryChart) weightHistoryChart.destroy();
            const ctx = document.getElementById('weightHistoryChart').getContext('2d');
            weightHistoryChart = new Chart(ctx, {
                type: 'line',
                data: { labels: labels.length ? labels : ['Belum ada data'], datasets: [{ label: 'Berat (kg)', data: values.length ? values : [0], borderColor: '#10b981', fill: false }] }
            });

            // Riwayat perkawinan (contoh, sesuaikan dengan struktur data dari backend)
            const riwayatKawin = data.mating_records || [];
            let kawinHtml = '';
            riwayatKawin.forEach(function(rec) {
                kawinHtml += `<tr class="border-b border-white/10"><td class="px-3 py-2">${rec.mating_date || '-'}</td><td class="px-3 py-2">${escapeHtml(rec.female_ear_tag || '-')}</td><td class="px-3 py-2">${escapeHtml(rec.pen_name || '-')}</td><td class="px-3 py-2"><span class="px-2 py-1 rounded-full text-xs ${rec.success ? 'bg-emerald-500/20 text-emerald-200' : 'bg-yellow-500/20 text-yellow-200'}">${rec.success ? 'Berhasil' : 'Proses'}</span></td></tr>`;
            });
            document.getElementById('riwayatKawinTable').innerHTML = kawinHtml || '<tr><td colspan="4" class="text-center py-2 text-gray-400">Tidak ada data perkawinan</td></tr>';
            document.getElementById('modalDetailPejantan').classList.remove('hidden');
        } else {
            TernakPark.ui.showToast('Gagal memuat detail pejantan', 'error');
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
@endpush
