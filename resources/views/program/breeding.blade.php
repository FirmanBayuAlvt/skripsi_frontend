@extends('layouts.app')

@section('title', 'Breeding Domba')
@section('header-title', 'Program Breeding Domba')

@section('content')
<div class="space-y-6">
    {{-- TOMBOL NAVIGASI KE HALAMAN LAIN (INDUKAN, PEJANTAN, ANAKAN, DATA KAWIN & IB) --}}
    <div class="flex flex-wrap gap-3 justify-end">
        <a href="{{ route('program.breeding.indukan') }}" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-5 py-2.5 rounded-xl flex items-center gap-2 shadow-md transition transform hover:scale-105">
            <i class="fas fa-female"></i> Indukan
        </a>
        <a href="{{ route('program.breeding.pejantan') }}" class="bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white px-5 py-2.5 rounded-xl flex items-center gap-2 shadow-md transition transform hover:scale-105">
            <i class="fas fa-male"></i> Pejantan
        </a>
        <a href="{{ route('program.breeding.anakan') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-xl flex items-center gap-2 shadow-md transition transform hover:scale-105">
            <i class="fas fa-baby-carriage"></i> Anakan
        </a>
        <a href="{{ route('program.breeding.kawin-ib') }}" class="bg-gradient-to-r from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800 text-white px-5 py-2.5 rounded-xl flex items-center gap-2 shadow-md transition transform hover:scale-105">
            <i class="fas fa-heartbeat"></i> Data Kawin & IB
        </a>
    </div>

    {{-- Ringkasan Statistik Utama --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Total Ternak Breeding</p><p class="stat-value" id="total-overall">-</p></div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl"><i class="fas fa-paw text-emerald-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Qty Anakan</p><p class="stat-value" id="qty-anakan">-</p></div>
                <div class="bg-blue-500/20 p-3 rounded-2xl"><i class="fas fa-baby text-blue-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Qty Indukan</p><p class="stat-value" id="qty-indukan">-</p></div>
                <div class="bg-purple-500/20 p-3 rounded-2xl"><i class="fas fa-female text-purple-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Qty Pejantan</p><p class="stat-value" id="qty-pejantan">-</p></div>
                <div class="bg-amber-500/20 p-3 rounded-2xl"><i class="fas fa-male text-amber-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Betina Hamil</p><p class="stat-value" id="qty-hamil">-</p></div>
                <div class="bg-pink-500/20 p-3 rounded-2xl"><i class="fas fa-heartbeat text-pink-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Betina Menyusui</p><p class="stat-value" id="qty-menyusui">-</p></div>
                <div class="bg-rose-500/20 p-3 rounded-2xl"><i class="fas fa-hand-holding-heart text-rose-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Betina Tidak Hamil</p><p class="stat-value" id="qty-tidak-hamil">-</p></div>
                <div class="bg-gray-500/20 p-3 rounded-2xl"><i class="fas fa-ban text-gray-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Ternak Afkir</p><p class="stat-value text-red-300" id="qty-afkir">-</p></div>
                <div class="bg-red-500/20 p-3 rounded-2xl"><i class="fas fa-skull-crossbones text-red-300 text-xl"></i></div>
            </div>
        </div>
    </div>

    {{-- Grafik Distribusi Kondisi Betina & Umur --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-5">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
                <i class="fas fa-chart-pie text-emerald-400"></i>
                <h3 class="font-bold text-white text-lg">Distribusi Kondisi Indukan</h3>
            </div>
            <canvas id="kondisiChart" height="250" class="w-full"></canvas>
        </div>
        <div class="glass-card p-5">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
                <i class="fas fa-chart-bar text-emerald-400"></i>
                <h3 class="font-bold text-white text-lg">Distribusi Umur Ternak</h3>
            </div>
            <canvas id="ageChart" height="250" class="w-full"></canvas>
        </div>
    </div>

    {{-- Tabel Anakan (Dengan Filter) --}}
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center justify-between border-b border-white/10 p-5">
            <div class="flex items-center gap-2">
                <i class="fas fa-baby-carriage text-emerald-400"></i>
                <h3 class="font-bold text-white text-lg">Data Anakan</h3>
            </div>
            <div class="flex gap-2">
                <select id="filterAnakanGender" class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5 text-sm text-white">
                    <option value="">Semua Kelamin</option>
                    <option value="male">Jantan</option>
                    <option value="female">Betina</option>
                </select>
                <select id="filterAnakanWeaned" class="bg-white/10 border border-white/20 rounded-xl px-3 py-1.5 text-sm text-white">
                    <option value="">Status Sapih</option>
                    <option value="1">Sudah Lepas</option>
                    <option value="0">Belum Lepas</option>
                </select>
                <button id="btnFilterAnakan" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-xl text-sm transition">Filter</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Jenis</th>
                        <th class="px-3 py-2">Kelamin</th>
                        <th class="px-3 py-2">BB (kg)</th>
                        <th class="px-3 py-2">Umur (hari)</th>
                        <th class="px-3 py-2">Induk</th>
                        <th class="px-3 py-2">Status Sapih</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="anakan-table-body">
                    <tr><td colspan="8" class="text-center py-6 text-gray-400">Memuat data...</td>
                </tbody>
            </table>
        </div>
        <div id="paginationAnakan" class="p-4 border-t border-white/10 flex justify-between items-center"></div>
    </div>

    {{-- Tabel Induk Betina --}}
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-female text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Induk Betina</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Jenis</th>
                        <th class="px-3 py-2">BB (kg)</th>
                        <th class="px-3 py-2">Umur (hari)</th>
                        <th class="px-3 py-2">Kondisi</th>
                        <th class="px-3 py-2">Kandang</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="induk-betina-body">
                    <tr><td colspan="7" class="text-center py-6 text-gray-400">Memuat data...</tr>
                </tbody>
            </table>
        </div>
        <div id="paginationInduk" class="p-4 border-t border-white/10 flex justify-between items-center"></div>
    </div>

    {{-- Tabel Induk Jantan --}}
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-mars text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Induk Jantan (Pejantan)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Jenis</th>
                        <th class="px-3 py-2">BB (kg)</th>
                        <th class="px-3 py-2">Umur (hari)</th>
                        <th class="px-3 py-2">Kandang</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="induk-jantan-body">
                    <tr><td colspan="6" class="text-center py-6 text-gray-400">Memuat data...</tr>
                </tbody>
            </table>
        </div>
        <div id="paginationJantan" class="p-4 border-t border-white/10 flex justify-between items-center"></div>
    </div>

    {{-- Kandang Khusus Betina --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="glass-card p-4 text-center">
            <i class="fas fa-heart text-pink-400 text-xl mb-2 block"></i>
            <p class="text-gray-300 font-medium">Betina di Kandang Kawin</p>
            <p class="text-3xl font-bold text-white" id="qty-kawin">-</p>
        </div>
        <div class="glass-card p-4 text-center">
            <i class="fas fa-shield-virus text-yellow-400 text-xl mb-2 block"></i>
            <p class="text-gray-300 font-medium">Betina di Kandang Karantina</p>
            <p class="text-3xl font-bold text-white" id="qty-karantina">-</p>
        </div>
        <div class="glass-card p-4 text-center">
            <i class="fas fa-calendar-alt text-blue-400 text-xl mb-2 block"></i>
            <p class="text-gray-300 font-medium">Betina di Kandang Persiapan Breeding</p>
            <p class="text-3xl font-bold text-white" id="qty-persiapan">-</p>
        </div>
    </div>

    {{-- Keluarga Ternak --}}
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-family text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Keluarga Ternak</h3>
        </div>
        <div class="mb-4 flex flex-wrap items-center gap-4">
            <label class="text-gray-300 font-medium">Pilih Ternak:</label>
            <select id="family-select" class="bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500 w-64">
                <option value="">-- Pilih Ear Tag --</option>
            </select>
            <button id="btn-load-family" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl shadow-md transition">Tampilkan Keluarga</button>
        </div>
        <div id="family-result" class="hidden space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                    <p class="font-bold text-emerald-300 mb-2"><i class="fas fa-user mr-1"></i> Ternak Terpilih</p>
                    <div id="selected-info" class="text-gray-300 text-sm space-y-1"></div>
                </div>
                <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                    <p class="font-bold text-emerald-300 mb-2"><i class="fas fa-mars mr-1"></i> Induk Jantan</p>
                    <div id="father-info" class="text-gray-300 text-sm space-y-1"></div>
                </div>
                <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                    <p class="font-bold text-emerald-300 mb-2"><i class="fas fa-venus mr-1"></i> Induk Betina</p>
                    <div id="mother-info" class="text-gray-300 text-sm space-y-1"></div>
                </div>
            </div>
            <div>
                <p class="font-bold text-white mb-2"><i class="fas fa-children mr-1 text-emerald-400"></i> Anak-anak:</p>
                <div class="overflow-x-auto">
                    <table class="custom-table w-full text-sm">
                        <thead class="bg-white/5 border-b border-white/10">
                            <tr>
                                <th class="px-3 py-2">Tagging</th>
                                <th class="px-3 py-2">Jenis</th>
                                <th class="px-3 py-2">Kelamin</th>
                                <th class="px-3 py-2">BB (kg)</th>
                                <th class="px-3 py-2">Umur</th>
                            </tr>
                        </thead>
                        <tbody id="children-table-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail Ternak (untuk tabel anakan, induk) --}}
<div id="modalDetailTernak" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-black/40 backdrop-blur-md rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-white/20">
            <div class="px-6 pt-6 pb-4 sm:px-8 sm:pt-8">
                <div class="flex justify-between items-center border-b border-white/10 pb-3 mb-4">
                    <h3 class="text-xl font-bold text-white">📋 Detail Ternak</h3>
                    <button class="close-modal text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
                </div>
                <div id="detailTernakInfo" class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm bg-white/5 rounded-xl p-4 border border-white/10"></div>
                <div class="mt-6">
                    <h4 class="font-semibold text-white mb-2">📈 Riwayat Berat</h4>
                    <canvas id="detailWeightChart" height="200" class="w-full bg-white/5 rounded-xl p-2"></canvas>
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
let kondisiChart = null;
let ageChart = null;
let weightHistoryChart = null;
let currentPageAnakan = 1;
let currentPageInduk = 1;
let currentPageJantan = 1;
let filterAnakanGender = '';
let filterAnakanWeaned = '';

document.addEventListener('DOMContentLoaded', function() {
    loadBreedingData();
    loadLivestockOptions();
    document.getElementById('btn-load-family').addEventListener('click', loadFamilyData);
    document.getElementById('btnFilterAnakan').addEventListener('click', function() {
        filterAnakanGender = document.getElementById('filterAnakanGender').value;
        filterAnakanWeaned = document.getElementById('filterAnakanWeaned').value;
        currentPageAnakan = 1;
        loadAnakanTable();
    });
    document.querySelectorAll('.close-modal').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('modalDetailTernak').classList.add('hidden');
        });
    });
});

async function loadLivestockOptions() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/livestocks/data?per_page=1000');
        if (response.success && response.data.livestocks) {
            const select = document.getElementById('family-select');
            select.innerHTML = '<option value="">-- Pilih Ear Tag --</option>';
            response.data.livestocks.forEach(function(livestock) {
                select.innerHTML += '<option value="' + escapeHtml(livestock.ear_tag) + '">' + escapeHtml(livestock.ear_tag) + ' - ' + escapeHtml(livestock.breed_type) + '</option>';
            });
        }
    } catch(error) {
        console.error(error);
        TernakPark.ui.showToast('Gagal memuat daftar ternak', 'error');
    }
}

async function loadFamilyData() {
    const earTag = document.getElementById('family-select').value;
    if (!earTag) {
        TernakPark.ui.showToast('Pilih ear tag terlebih dahulu', 'warning');
        return;
    }
    try {
        const response = await TernakPark.api.fetchData('/web-api/program/family?ear_tag=' + encodeURIComponent(earTag));
        if (response.success) {
            const data = response.data;
            document.getElementById('family-result').classList.remove('hidden');
            document.getElementById('selected-info').innerHTML = `
                <p><span class="text-gray-400">Tag:</span> ${escapeHtml(data.selected.ear_tag)}</p>
                <p><span class="text-gray-400">Jenis:</span> ${escapeHtml(data.selected.breed_type)}</p>
                <p><span class="text-gray-400">Kelamin:</span> ${data.selected.gender === 'male' ? 'Jantan' : 'Betina'}</p>
                <p><span class="text-gray-400">BB:</span> ${data.selected.current_weight} kg</p>
            `;
            if (data.father) {
                document.getElementById('father-info').innerHTML = '<p><span class="text-gray-400">Tag:</span> ' + escapeHtml(data.father.ear_tag) + '</p><p><span class="text-gray-400">Jenis:</span> ' + escapeHtml(data.father.breed_type) + '</p><p><span class="text-gray-400">BB:</span> ' + data.father.current_weight + ' kg</p>';
            } else {
                document.getElementById('father-info').innerHTML = '<p class="text-gray-500">Tidak ada data</p>';
            }
            if (data.mother) {
                document.getElementById('mother-info').innerHTML = '<p><span class="text-gray-400">Tag:</span> ' + escapeHtml(data.mother.ear_tag) + '</p><p><span class="text-gray-400">Jenis:</span> ' + escapeHtml(data.mother.breed_type) + '</p><p><span class="text-gray-400">BB:</span> ' + data.mother.current_weight + ' kg</p>';
            } else {
                document.getElementById('mother-info').innerHTML = '<p class="text-gray-500">Tidak ada data</p>';
            }
            const childrenBody = document.getElementById('children-table-body');
            if (data.children && data.children.length > 0) {
                let childrenHtml = '';
                data.children.forEach(function(child) {
                    childrenHtml += '<tr class="border-b border-white/10">';
                    childrenHtml += '<td class="px-3 py-2">' + escapeHtml(child.ear_tag) + '</td>';
                    childrenHtml += '<td class="px-3 py-2">' + escapeHtml(child.breed_type) + '</td>';
                    childrenHtml += '<td class="px-3 py-2">' + (child.gender === 'male' ? 'Jantan' : 'Betina') + '</td>';
                    childrenHtml += '<td class="px-3 py-2">' + child.current_weight + '</td>';
                    childrenHtml += '<td class="px-3 py-2">' + child.age_days + ' hari</td>';
                    childrenHtml += '</tr>';
                });
                childrenBody.innerHTML = childrenHtml;
            } else {
                childrenBody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-gray-400">Tidak ada anak</td></tr>';
            }
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat keluarga', 'error');
        }
    } catch(error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
}

async function loadBreedingData() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/program/breeding');
        if (response.success) {
            const data = response.data;
            document.getElementById('total-overall').innerText = data.total_overall ?? 0;
            document.getElementById('qty-anakan').innerText = data.qty_anakan ?? 0;
            document.getElementById('qty-indukan').innerText = data.qty_indukan ?? 0;
            document.getElementById('qty-pejantan').innerText = data.qty_pejantan ?? 0;
            document.getElementById('qty-hamil').innerText = data.qty_betina_hamil ?? 0;
            document.getElementById('qty-menyusui').innerText = data.qty_betina_menyusui ?? 0;
            document.getElementById('qty-tidak-hamil').innerText = data.qty_betina_tidak_hamil ?? 0;
            document.getElementById('qty-afkir').innerText = data.qty_afkir ?? 0;
            document.getElementById('qty-kawin').innerText = data.qty_betina_kawin ?? 0;
            document.getElementById('qty-karantina').innerText = data.qty_betina_karantina ?? 0;
            document.getElementById('qty-persiapan').innerText = data.qty_betina_persiapan_breeding ?? 0;

            if (kondisiChart) kondisiChart.destroy();
            kondisiChart = new Chart(document.getElementById('kondisiChart'), {
                type: 'pie',
                data: {
                    labels: ['Sehat', 'Menyusui', 'Hamil', 'Afkir', 'Sakit'],
                    datasets: [{
                        data: [data.persen_sehat || 0, data.persen_menyusui || 0, data.persen_hamil || 0, data.persen_afkir || 0, data.persen_sakit || 0],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6']
                    }]
                }
            });

            if (ageChart) ageChart.destroy();
            ageChart = new Chart(document.getElementById('ageChart'), {
                type: 'bar',
                data: {
                    labels: data.age_labels || ['0-30', '31-90', '91-180', '181-365', '>365'],
                    datasets: [{
                        label: 'Jumlah Ternak',
                        data: data.age_distribution || [0, 0, 0, 0, 0],
                        backgroundColor: '#f59e0b'
                    }]
                }
            });

            loadAnakanTable();
            loadIndukTable();
            loadJantanTable();
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data breeding', 'error');
        }
    } catch(error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
}

async function loadAnakanTable() {
    try {
        let url = '/web-api/program/breeding/anakan?page=' + currentPageAnakan;
        if (filterAnakanGender) url += '&gender=' + encodeURIComponent(filterAnakanGender);
        if (filterAnakanWeaned !== '') url += '&weaned=' + encodeURIComponent(filterAnakanWeaned);
        const response = await TernakPark.api.fetchData(url);
        if (response.success) {
            renderTable('anakan-table-body', response.data.anakan, [
                { field: 'ear_tag', label: 'Tagging' },
                { field: 'breed_type', label: 'Jenis' },
                { field: 'gender', label: 'Kelamin', transform: function(v) { return v === 'male' ? 'Jantan' : 'Betina'; } },
                { field: 'current_weight', label: 'BB (kg)' },
                { field: 'age_days', label: 'Umur (hari)', suffix: ' hari' },
                { field: 'mother_ear_tag', label: 'Induk' },
                { field: 'is_weaned', label: 'Status Sapih', transform: function(v) { return v ? 'Sudah' : 'Belum'; }, badge: true }
            ], true);
            renderPagination('paginationAnakan', response.data.pagination, 'anakan');
        }
    } catch(e) { console.error(e); }
}

async function loadIndukTable() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/program/breeding/induk?page=' + currentPageInduk);
        if (response.success) {
            renderTable('induk-betina-body', response.data.induk, [
                { field: 'ear_tag', label: 'Tagging' },
                { field: 'breed_type', label: 'Jenis' },
                { field: 'current_weight', label: 'BB (kg)' },
                { field: 'age_days', label: 'Umur (hari)', suffix: ' hari' },
                { field: 'condition', label: 'Kondisi' },
                { field: 'pen_name', label: 'Kandang' }
            ], true);
            renderPagination('paginationInduk', response.data.pagination, 'induk');
        }
    } catch(e) { console.error(e); }
}

async function loadJantanTable() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/program/breeding/jantan?page=' + currentPageJantan);
        if (response.success) {
            renderTable('induk-jantan-body', response.data.jantan, [
                { field: 'ear_tag', label: 'Tagging' },
                { field: 'breed_type', label: 'Jenis' },
                { field: 'current_weight', label: 'BB (kg)' },
                { field: 'age_days', label: 'Umur (hari)', suffix: ' hari' },
                { field: 'pen_name', label: 'Kandang' }
            ], true);
            renderPagination('paginationJantan', response.data.pagination, 'jantan');
        }
    } catch(e) { console.error(e); }
}

function renderTable(tbodyId, data, columns, withDetail) {
    const tbody = document.getElementById(tbodyId);
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="' + (columns.length + (withDetail ? 1 : 0)) + '" class="text-center py-6 text-gray-400">Tidak ada data</td></td>';
        return;
    }
    let html = '';
    data.forEach(function(row) {
        html += '<tr class="border-b border-white/10 hover:bg-white/5 transition">';
        columns.forEach(function(col) {
            let value = row[col.field] !== undefined ? row[col.field] : '-';
            if (col.transform) value = col.transform(value);
            if (col.suffix && value !== '-') value = value + col.suffix;
            if (col.badge) {
                var badgeClass = value === 'Sudah' ? 'bg-emerald-500/20 text-emerald-200' : 'bg-yellow-500/20 text-yellow-200';
                value = '<span class="px-2 py-1 rounded-full text-xs ' + badgeClass + '">' + value + '</span>';
            }
            html += '<td class="px-3 py-2">' + value + '</td>';
        });
        if (withDetail) {
            html += '<td class="px-3 py-2"><button class="btn-detail-ternak text-emerald-400 hover:text-emerald-300" data-id="' + row.id + '"><i class="fas fa-eye"></i> Detail</button></td>';
        }
        html += '</tr>';
    });
    tbody.innerHTML = html;
    if (withDetail) {
        var buttons = document.querySelectorAll('#' + tbodyId + ' .btn-detail-ternak');
        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                loadDetailTernak(btn.getAttribute('data-id'));
            });
        });
    }
}

function renderPagination(containerId, pagination, type) {
    var container = document.getElementById(containerId);
    if (!pagination || pagination.total <= pagination.per_page) {
        container.innerHTML = '';
        return;
    }
    var start = (pagination.current_page - 1) * pagination.per_page + 1;
    var end = Math.min(pagination.current_page * pagination.per_page, pagination.total);
    var html = '<div class="text-sm text-gray-400">Menampilkan ' + start + ' - ' + end + ' dari ' + pagination.total + '</div>';
    html += '<div class="flex space-x-2">';
    if (pagination.current_page > 1) {
        html += '<button onclick="changePage(\'' + type + '\', ' + (pagination.current_page - 1) + ')" class="px-3 py-1 bg-white/10 rounded-xl hover:bg-white/20">Prev</button>';
    }
    if (pagination.current_page < pagination.last_page) {
        html += '<button onclick="changePage(\'' + type + '\', ' + (pagination.current_page + 1) + ')" class="px-3 py-1 bg-white/10 rounded-xl hover:bg-white/20">Next</button>';
    }
    html += '</div>';
    container.innerHTML = html;
}

function changePage(type, page) {
    if (type === 'anakan') {
        currentPageAnakan = page;
        loadAnakanTable();
    } else if (type === 'induk') {
        currentPageInduk = page;
        loadIndukTable();
    } else if (type === 'jantan') {
        currentPageJantan = page;
        loadJantanTable();
    }
}

async function loadDetailTernak(id) {
    try {
        var response = await TernakPark.api.fetchData('/web-api/livestocks/' + id + '/detail');
        if (response.success) {
            var data = response.data;
            var detailHtml = '';
            detailHtml += '<div><span class="text-gray-400">Tag:</span> ' + escapeHtml(data.ear_tag) + '</div>';
            detailHtml += '<div><span class="text-gray-400">Jenis:</span> ' + escapeHtml(data.breed_type) + '</div>';
            detailHtml += '<div><span class="text-gray-400">Kelamin:</span> ' + (data.gender === 'male' ? 'Jantan' : 'Betina') + '</div>';
            detailHtml += '<div><span class="text-gray-400">BB Terbaru:</span> ' + data.current_weight + ' kg</div>';
            detailHtml += '<div><span class="text-gray-400">Umur:</span> ' + data.age_days + ' hari</div>';
            detailHtml += '<div><span class="text-gray-400">Kandang:</span> ' + escapeHtml(data.pen ? data.pen.name : '-') + '</div>';
            detailHtml += '<div><span class="text-gray-400">Kondisi:</span> ' + escapeHtml(data.condition || '-') + '</div>';
            detailHtml += '<div><span class="text-gray-400">Status:</span> ' + (data.status ? 'Aktif' : 'Tidak Aktif') + '</div>';
            detailHtml += '<div><span class="text-gray-400">Induk Jantan:</span> ' + escapeHtml(data.father_ear_tag || '-') + '</div>';
            detailHtml += '<div><span class="text-gray-400">Induk Betina:</span> ' + escapeHtml(data.mother_ear_tag || '-') + '</div>';
            document.getElementById('detailTernakInfo').innerHTML = detailHtml;

            var weightRecords = data.weight_records || [];
            var labels = [];
            var values = [];
            for (var i = 0; i < weightRecords.length; i++) {
                labels.push(new Date(weightRecords[i].record_date).toLocaleDateString('id-ID'));
                values.push(weightRecords[i].weight_kg);
            }
            if (weightHistoryChart) weightHistoryChart.destroy();
            var ctx = document.getElementById('detailWeightChart').getContext('2d');
            weightHistoryChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels.length ? labels : ['Belum ada data'],
                    datasets: [{
                        label: 'Berat (kg)',
                        data: values.length ? values : [0],
                        borderColor: '#10b981',
                        fill: false
                    }]
                }
            });
            document.getElementById('modalDetailTernak').classList.remove('hidden');
        } else {
            TernakPark.ui.showToast('Gagal memuat detail', 'error');
        }
    } catch(e) {
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
