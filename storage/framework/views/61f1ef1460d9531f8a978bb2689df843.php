<?php $__env->startSection('title', 'Breeding - Indukan'); ?>
<?php $__env->startSection('header-title', 'Manajemen Indukan'); ?>

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
                <div><p class="text-gray-300 text-sm">Qty Indukan</p><p class="stat-value" id="qty-indukan">-</p></div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl"><i class="fas fa-female text-emerald-300 text-xl"></i></div>
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
                <div><p class="text-gray-300 text-sm">Qty di Kandang Kawin</p><p class="stat-value" id="qty-kandang-kawin">-</p></div>
                <div class="bg-purple-500/20 p-3 rounded-2xl"><i class="fas fa-heart text-purple-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Qty di Kandang Karantina</p><p class="stat-value" id="qty-karantina">-</p></div>
                <div class="bg-red-500/20 p-3 rounded-2xl"><i class="fas fa-shield-virus text-red-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Qty Persiapan Breeding</p><p class="stat-value" id="qty-persiapan">-</p></div>
                <div class="bg-amber-500/20 p-3 rounded-2xl"><i class="fas fa-calendar-alt text-amber-300 text-xl"></i></div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div><p class="text-gray-300 text-sm">Skore IPI</p><p class="stat-value" id="skor-ipi">-</p></div>
                <div class="bg-indigo-500/20 p-3 rounded-2xl"><i class="fas fa-chart-line text-indigo-300 text-xl"></i></div>
            </div>
        </div>
    </div>

    
    <div class="glass-card p-6">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-chart-pie text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Persentase Kondisi Indukan</h3>
        </div>
        <canvas id="kondisiChart" height="250" class="w-full"></canvas>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-bug text-red-400"></i>
            <h3 class="font-bold text-white text-lg">Data Indukan Betina yang Sakit</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">JENIS DOMBA</th>
                        <th class="px-3 py-2">KANDANG</th>
                        <th class="px-3 py-2">Umur</th>
                        <th class="px-3 py-2">BB Terbaru</th>
                    </tr>
                </thead>
                <tbody id="tabel-sakit"></tbody>
            </table>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-heart text-pink-400"></i>
            <h3 class="font-bold text-white text-lg">Data Indukan Betina di Kandang Kawin</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">JENIS DOMBA</th>
                        <th class="px-3 py-2">KANDANG</th>
                        <th class="px-3 py-2">Umur</th>
                        <th class="px-3 py-2">BB Terbaru</th>
                    </tr>
                </thead>
                <tbody id="tabel-kandang-kawin"></tbody>
            </table>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-hand-holding-heart text-blue-400"></i>
            <h3 class="font-bold text-white text-lg">Data Indukan Betina Menyusui</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">SUB KATEGORI</th>
                        <th class="px-3 py-2">KANDANG</th>
                    </tr>
                </thead>
                <tbody id="tabel-menyusui"></tbody>
            </table>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-fetus text-pink-400"></i>
            <h3 class="font-bold text-white text-lg">Data Indukan Betina Hamil</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">SUB KATEGORI</th>
                        <th class="px-3 py-2">KANDANG</th>
                    </tr>
                </thead>
                <tbody id="tabel-hamil"></tbody>
            </table>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-seedling text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Calon Indukan Betina</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">JENIS DOMBA</th>
                        <th class="px-3 py-2">KANDANG</th>
                        <th class="px-3 py-2">Umur</th>
                        <th class="px-3 py-2">BB Terbaru</th>
                    </tr>
                </thead>
                <tbody id="tabel-calon-indukan"></tbody>
            </table>
        </div>
    </div>

    
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-filter text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Filter Data Indukan Berdasar Sub Kategori</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-gray-300 text-sm">Sub Kategori</label>
                <select id="filterSubKategori" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua</option>
                    <option value="Dewasa (>12 Bulan)">Dewasa (>12 Bulan)</option>
                    <option value="Pertama">Pertama</option>
                    <option value="Kedua">Kedua</option>
                    <option value="Dara (6-12 Bulan)">Dara (6-12 Bulan)</option>
                    <option value="Ketiga">Ketiga</option>
                </select>
            </div>
            <div class="flex items-end">
                <button id="btnApplyFilter" class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-4 py-2 rounded-xl">Terapkan Filter</button>
            </div>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-table text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Indukan Berdasar Sub Kategori</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">SUB KATEGORI</th>
                        <th class="px-3 py-2">KANDANG</th>
                        <th class="px-3 py-2">UMUR (days)</th>
                        <th class="px-3 py-2">KONDISI</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-sub-kategori"></tbody>
            </table>
        </div>
    </div>

    
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-filter text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Filter Jenis Kelahiran per Induk</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-gray-300 text-sm">Tagging</label>
                <select id="filterTaggingLaktasi" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua</option>
                </select>
            </div>
            <div>
                <label class="text-gray-300 text-sm">Tipe Laktasi</label>
                <select id="filterTipeLaktasi" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white">
                    <option value="">Semua</option>
                    <option value="Laktasi 1 Tunggal">Laktasi 1 Tunggal</option>
                    <option value="Laktasi 1 Prolifik">Laktasi 1 Prolifik</option>
                    <option value="Laktasi 2 Tunggal">Laktasi 2 Tunggal</option>
                    <option value="Laktasi 2 Prolifik">Laktasi 2 Prolifik</option>
                    <option value="Laktasi 3 Tunggal">Laktasi 3 Tunggal</option>
                    <option value="Laktasi 3 Prolifik">Laktasi 3 Prolifik</option>
                    <option value="Laktasi 4 Tunggal">Laktasi 4 Tunggal</option>
                    <option value="Laktasi 4 Prolifik">Laktasi 4 Prolifik</option>
                    <option value="Laktasi 5 Tunggal">Laktasi 5 Tunggal</option>
                    <option value="Laktasi 5 Prolifik">Laktasi 5 Prolifik</option>
                    <option value="Laktasi 6 Tunggal">Laktasi 6 Tunggal</option>
                    <option value="Laktasi 6 Prolifik">Laktasi 6 Prolifik</option>
                </select>
            </div>
            <div class="flex items-end">
                <button id="btnApplyLaktasiFilter" class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-4 py-2 rounded-xl">Terapkan Filter</button>
            </div>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-baby-carriage text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Jenis Kelahiran per Induk</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-xs">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">KANDANG</th>
                        <th class="px-3 py-2">UMUR</th>
                        <th class="px-3 py-2">BB Terbaru</th>
                        <th class="px-3 py-2">Laktasi 1</th>
                        <th class="px-3 py-2">Laktasi 2</th>
                        <th class="px-3 py-2">Laktasi 3</th>
                        <th class="px-3 py-2">Laktasi 4</th>
                        <th class="px-3 py-2">Laktasi 5</th>
                        <th class="px-3 py-2">Laktasi 6</th>
                    </tr>
                </thead>
                <tbody id="tabel-jenis-kelahiran"></tbody>
            </table>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="glass-card p-4 text-center">
            <i class="fas fa-chart-simple text-emerald-400 text-xl mb-2 block"></i>
            <p class="text-gray-300 text-sm">Skore IPI</p>
            <p class="text-2xl font-bold text-white" id="skor-ipi-bawah">-</p>
        </div>
        <div class="glass-card p-4 text-center">
            <i class="fas fa-info-circle text-emerald-400 text-xl mb-2 block"></i>
            <p class="text-gray-300 text-sm">Performa Indukan</p>
            <p class="text-md font-semibold text-white" id="performa-indukan">-</p>
        </div>
        <div class="glass-card p-4 text-center">
            <i class="fas fa-baby text-emerald-400 text-xl mb-2 block"></i>
            <p class="text-gray-300 text-sm">Performa Hasil Anakan</p>
            <p class="text-md font-semibold text-white" id="performa-anakan">-</p>
        </div>
    </div>

    
    <div id="modalDetailIndukan" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-black/40 backdrop-blur-md rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full border border-white/20">
                <div class="px-6 pt-6 pb-4 sm:px-8 sm:pt-8">
                    <div class="flex justify-between items-center border-b border-white/10 pb-3 mb-4">
                        <h3 class="text-xl font-bold text-white">📋 Detail Indukan</h3>
                        <button class="close-modal text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div><label class="text-gray-400 block mb-1">Pilih Ternak</label><select id="detailTagSelect" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"><option value="">-- Pilih Tag --</option></select></div>
                        <div></div>
                    </div>
                    <div id="detailIndukanInfo" class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm bg-white/5 rounded-xl p-4 border border-white/10"></div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-white/5 p-3 rounded-xl"><p class="text-emerald-300">Skore IPI</p><p id="detail-skor-ipi" class="text-2xl font-bold">-</p></div>
                        <div class="bg-white/5 p-3 rounded-xl"><p class="text-emerald-300">Performa Indukan</p><p id="detail-performa-indukan">-</p></div>
                        <div class="bg-white/5 p-3 rounded-xl"><p class="text-emerald-300">Performa Hasil Anakan</p><p id="detail-performa-anakan">-</p></div>
                    </div>
                    <div class="mt-6" id="laktasiTables"></div>
                </div>
                <div class="px-6 py-4 bg-white/5 sm:flex sm:flex-row-reverse sm:px-8">
                    <button class="close-modal px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let kondisiChart = null;
let currentSubKategoriPage = 1;
let currentLaktasiPage = 1;
let allLivestock = [];

document.addEventListener('DOMContentLoaded', function() {
    loadIndukanData();
    loadTaggingOptions();
    document.getElementById('btnApplyFilter').addEventListener('click', loadFilteredSubKategori);
    document.getElementById('btnApplyLaktasiFilter').addEventListener('click', loadFilteredJenisKelahiran);
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', () => document.getElementById('modalDetailIndukan').classList.add('hidden'));
    });
    document.getElementById('detailTagSelect').addEventListener('change', function() {
        if (this.value) loadDetailIndukan(this.value);
    });
});

async function loadIndukanData() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/program/breeding/indukan');
        if (response.success) {
            const data = response.data;
            // Statistik
            document.getElementById('qty-indukan').innerText = data.qty_indukan || 0;
            document.getElementById('qty-hamil').innerText = data.qty_hamil || 0;
            document.getElementById('qty-menyusui').innerText = data.qty_menyusui || 0;
            document.getElementById('qty-tidak-hamil').innerText = data.qty_tidak_hamil || 0;
            document.getElementById('qty-kandang-kawin').innerText = data.qty_kandang_kawin || 0;
            document.getElementById('qty-karantina').innerText = data.qty_karantina || 0;
            document.getElementById('qty-persiapan').innerText = data.qty_persiapan || 0;
            document.getElementById('skor-ipi').innerText = data.skor_ipi?.toFixed(2) || '0';
            document.getElementById('skor-ipi-bawah').innerText = data.skor_ipi?.toFixed(2) || '0';
            document.getElementById('performa-indukan').innerText = data.performa_indukan || '-';
            document.getElementById('performa-anakan').innerText = data.performa_anakan || '-';

            // Grafik kondisi
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

            // Tabel-tabel
            renderSimpleTable('tabel-sakit', data.data_sakit, ['ear_tag', 'breed_type', 'pen_name', 'sub_kategori', 'current_weight']);
            renderSimpleTable('tabel-kandang-kawin', data.data_kandang_kawin, ['ear_tag', 'breed_type', 'pen_name', 'sub_kategori', 'current_weight']);
            renderSimpleTable('tabel-menyusui', data.data_menyusui, ['ear_tag', 'sub_kategori', 'pen_name']);
            renderSimpleTable('tabel-hamil', data.data_hamil, ['ear_tag', 'sub_kategori', 'pen_name']);
            renderSimpleTable('tabel-calon-indukan', data.data_calon_indukan, ['ear_tag', 'breed_type', 'pen_name', 'sub_kategori', 'current_weight']);
            renderSimpleTable('tabel-sub-kategori', data.data_sub_kategori, ['ear_tag', 'sub_kategori', 'pen_name', 'umur', 'kondisi'], true);
            renderJenisKelahiranTable(data.data_jenis_kelahiran);

            // Dropdown tagging untuk filter laktasi
            const taggingSelect = document.getElementById('filterTaggingLaktasi');
            taggingSelect.innerHTML = '<option value="">Semua</option>';
            if (data.list_tagging && data.list_tagging.length) {
                data.list_tagging.forEach(tag => {
                    taggingSelect.innerHTML += `<option value="${escapeHtml(tag)}">${escapeHtml(tag)}</option>`;
                });
            }
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data indukan', 'error');
        }
    } catch(error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
}

async function loadTaggingOptions() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/livestocks/data?per_page=1000&gender=female');
        if (response.success && response.data.livestocks) {
            allLivestock = response.data.livestocks;
            const select = document.getElementById('detailTagSelect');
            select.innerHTML = '<option value="">-- Pilih Indukan --</option>';
            allLivestock.forEach(l => {
                select.innerHTML += `<option value="${l.ear_tag}">${escapeHtml(l.ear_tag)} - ${escapeHtml(l.breed_type)}</option>`;
            });
        }
    } catch(e) { console.error(e); }
}

function renderSimpleTable(tbodyId, data, fields, withDetail = false) {
    const tbody = document.getElementById(tbodyId);
    if (!data || data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="${fields.length}" class="text-center py-4 text-gray-400">Tidak ada data</td></tr>`;
        return;
    }
    let html = '';
    data.forEach(row => {
        html += '<tr class="border-b border-white/10">';
        fields.forEach(f => {
            let val = row[f] !== undefined ? row[f] : '-';
            if (f === 'umur') val = val + ' hari';
            if (f === 'current_weight') val = val + ' kg';
            html += `<td class="px-3 py-2">${escapeHtml(String(val))}</td>`;
        });
        if (withDetail) {
            const earTag = row.ear_tag;
            html += `<td class="px-3 py-2"><button class="btn-detail-sub text-emerald-400 hover:text-emerald-300" data-tag="${escapeHtml(earTag)}">Detail</button></td>`;
        }
        html += '</tr>';
    });
    tbody.innerHTML = html;
    if (withDetail) {
        document.querySelectorAll('#tabel-sub-kategori .btn-detail-sub').forEach(btn => {
            btn.addEventListener('click', () => {
                const tag = btn.getAttribute('data-tag');
                if (tag) loadDetailIndukan(tag);
            });
        });
    }
}

function renderJenisKelahiranTable(data) {
    const tbody = document.getElementById('tabel-jenis-kelahiran');
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-center py-4 text-gray-400">Tidak ada数据</td></tr>';
        return;
    }
    let html = '';
    data.forEach(row => {
        html += '<tr class="border-b border-white/10">';
        html += `<td class="px-3 py-2">${escapeHtml(row.ear_tag)}</td>`;
        html += `<td class="px-3 py-2">${escapeHtml(row.pen_name || '-')}</td>`;
        html += `<td class="px-3 py-2">${row.umur || '-'}</td>`;
        html += `<td class="px-3 py-2">${row.current_weight || '-'}</td>`;
        for (let i = 1; i <= 6; i++) {
            const tipe = row[`tipe_laktasi_${i}`] || '-';
            html += `<td class="px-3 py-2">${escapeHtml(tipe)}</td>`;
        }
        html += '</tr>';
    });
    tbody.innerHTML = html;
}

async function loadFilteredSubKategori() {
    const sub = document.getElementById('filterSubKategori').value;
    try {
        const response = await TernakPark.api.fetchData(`/web-api/program/breeding/indukan?sub_kategori=${encodeURIComponent(sub)}`);
        if (response.success) {
            renderSimpleTable('tabel-sub-kategori', response.data.data_sub_kategori, ['ear_tag', 'sub_kategori', 'pen_name', 'umur', 'kondisi'], true);
        }
    } catch(e) {
        TernakPark.ui.showToast('Filter gagal', 'error');
    }
}

async function loadFilteredJenisKelahiran() {
    const tag = document.getElementById('filterTaggingLaktasi').value;
    const tipe = document.getElementById('filterTipeLaktasi').value;
    try {
        const response = await TernakPark.api.fetchData(`/web-api/program/breeding/jenis-kelahiran?tagging=${encodeURIComponent(tag)}&tipe=${encodeURIComponent(tipe)}`);
        if (response.success) {
            renderJenisKelahiranTable(response.data);
        }
    } catch(e) {
        TernakPark.ui.showToast('Filter gagal', 'error');
    }
}

async function loadDetailIndukan(earTag) {
    if (!earTag) return;
    try {
        const response = await TernakPark.api.fetchData(`/web-api/program/breeding/indukan/detail?tag=${encodeURIComponent(earTag)}`);
        if (response.success) {
            const d = response.data;
            const infoHtml = `
                <div><span class="text-gray-400">Tag:</span> ${escapeHtml(d.ear_tag)}</div>
                <div><span class="text-gray-400">SEX:</span> ${d.gender === 'male' ? 'Jantan' : 'Betina'}</div>
                <div><span class="text-gray-400">JENIS DOMBA:</span> ${escapeHtml(d.breed_type)}</div>
                <div><span class="text-gray-400">BB Terbaru:</span> ${d.current_weight} kg</div>
                <div><span class="text-gray-400">Tanggal Timbang:</span> ${d.last_weight_date || '-'}</div>
                <div><span class="text-gray-400">Tanggal Lahir:</span> ${d.birth_date || '-'}</div>
                <div><span class="text-gray-400">UMUR:</span> ${d.age_days} hari</div>
                <div><span class="text-gray-400">KONDISI:</span> ${d.condition || '-'}</div>
                <div><span class="text-gray-400">STATUS:</span> ${d.status ? 'Di Kandang' : 'Tidak Aktif'}</div>
                <div><span class="text-gray-400">KANDANG:</span> ${escapeHtml(d.pen?.name || '-')}</div>
                <div><span class="text-gray-400">Reproduksi:</span> ${d.reproductive_age || '-'}</div>
                <div><span class="text-gray-400">Induk Jantan:</span> ${d.father_ear_tag || '-'}</div>
                <div><span class="text-gray-400">Induk Betina:</span> ${d.mother_ear_tag || '-'}</div>
                <div><span class="text-gray-400">SUB KATEGORI:</span> ${d.sub_kategori || '-'}</div>
                <div><span class="text-gray-400">Jangan Dikawin: ${d.jangan_dikawin ? 'Ya' : 'Tidak'}</span></div>
                <div><span class="text-gray-400">Sedang Kawin dengan: ${d.sedang_kawin_dengan || '-'}</span></div>
            `;
            document.getElementById('detailIndukanInfo').innerHTML = infoHtml;
            document.getElementById('detail-skor-ipi').innerText = d.skor_ipi?.toFixed(2) || '-';
            document.getElementById('detail-performa-indukan').innerText = d.performa_indukan || '-';
            document.getElementById('detail-performa-anakan').innerText = d.performa_anakan || '-';

            let laktasiHtml = '';
            for (let i = 1; i <= 6; i++) {
                const l = d[`laktasi_${i}`];
                if (l && l.tanggal) {
                    laktasiHtml += `
                        <div class="bg-white/5 rounded-xl p-3 mt-2">
                            <h5 class="font-semibold text-emerald-300">Laktasi ${i}</h5>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                                <div>Tanggal: ${l.tanggal}</div>
                                <div>Anak: ${l.anak}</div>
                                <div>Tipe Kelahiran: ${l.tipe_kelahiran}</div>
                                <div>BB Induk: ${l.bb_induk} kg</div>
                                <div>BB Lahir Anak: ${l.bb_lahir}</div>
                                <div>BB Lepas Sapih: ${l.bb_lepas_sapih}</div>
                                <div>Sex Anak: ${l.sex_anak}</div>
                            </div>
                        </div>
                    `;
                }
            }
            document.getElementById('laktasiTables').innerHTML = laktasiHtml || '<p class="text-gray-400">Tidak ada data laktasi</p>';
            document.getElementById('modalDetailIndukan').classList.remove('hidden');
        } else {
            TernakPark.ui.showToast('Gagal memuat detail', 'error');
        }
    } catch(e) {
        console.error(e);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
}

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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/program/breeding-indukan.blade.php ENDPATH**/ ?>