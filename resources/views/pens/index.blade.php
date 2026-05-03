@extends('layouts.app')

@section('title', 'Manajemen Kandang')
@section('header-title', 'Manajemen Kandang')

@section('page-header')
<div class="flex flex-wrap justify-between items-center gap-3">
    <div class="flex items-center gap-2">
        <div class="h-8 w-1 bg-gradient-to-b from-emerald-300 to-teal-500 rounded-full"></div>
        <p class="text-emerald-200 font-medium tracking-wide">DATA KANDANG</p>
    </div>
    <div class="flex gap-2">
        <button onclick="openAddPenModal()" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl flex items-center shadow-md transition-all transform hover:scale-[1.02]">
            <i class="fas fa-plus mr-2"></i> Tambah Kandang
        </button>
        <button onclick="openImportPenModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-xl flex items-center shadow-md transition-all transform hover:scale-[1.02]">
            <i class="fas fa-file-excel mr-2"></i> Impor Excel
        </button>
        <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Stat Cards Premium --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Total Kandang</p>
                    <p class="stat-value" id="total-pens">-</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-warehouse text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Kapasitas Total</p>
                    <p class="stat-value" id="total-capacity">-</p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-2xl">
                    <i class="fas fa-cow text-blue-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Jumlah Ternak Keseluruhan</p>
                    <p class="stat-value" id="total-livestock-overall">-</p>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-2xl">
                    <i class="fas fa-paw text-purple-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Kandang Tersedia</p>
                    <p class="stat-value" id="available-pens">-</p>
                </div>
                <div class="bg-amber-500/20 p-3 rounded-2xl">
                    <i class="fas fa-check-circle text-amber-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Kandang (Tabel Utama) --}}
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-table-list text-emerald-400 text-xl"></i>
            <h3 class="font-bold text-white text-lg">Daftar Kandang</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm text-white">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-6 py-3 text-left">Kandang</th>
                        <th class="px-6 py-3 text-left">ABK</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-left">Umur (Days)</th>
                        <th class="px-6 py-3 text-left">Kapasitas</th>
                        <th class="px-6 py-3 text-left">Jumlah Ternak</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pens-table-body">
                    <tr><td colspan="8" class="text-center py-8 text-gray-400">Memuat data...</tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- List Tag dan BB Ternak Per Kandang --}}
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-tags text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">List Tag dan BB Ternak Per Kandang</h3>
        </div>
        <div class="mb-4 flex flex-wrap items-center gap-4">
            <label class="text-gray-300 font-medium">Pilih Kandang:</label>
            <select id="pen-filter-livestock" class="bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                <option value="">-- Pilih Kandang --</option>
            </select>
            <button onclick="loadLivestockByPen()" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl shadow-md transition">Tampilkan</button>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm text-white">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Jenis Kelamin</th>
                        <th class="px-3 py-2">Jenis Domba</th>
                        <th class="px-3 py-2">BB Terbaru</th>
                        <th class="px-3 py-2">Kondisi</th>
                        <th class="px-3 py-2">Anak Kandang</th>
                        <th class="px-3 py-2">Umur (hari)</th>
                    </tr>
                </thead>
                <tbody id="livestock-table-body">
                    <tr><td colspan="7" class="text-center py-6 text-gray-400">Pilih kandang terlebih dahulu</tr>
                </tbody>
            </tr>
        </div>
    </div>

    {{-- List Jumlah Ternak dan Total Bobot Per Kandang --}}
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-chart-simple text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">List Jumlah Ternak dan Total Bobot Per Kandang</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm text-white">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Kandang</th>
                        <th class="px-3 py-2">Anak Kandang (ABK)</th>
                        <th class="px-3 py-2">Kategori Kandang</th>
                        <th class="px-3 py-2">Jumlah Ternak</th>
                        <th class="px-3 py-2">Total BB (kg)</th>
                        <th class="px-3 py-2">Kapasitas</th>
                        <th class="px-3 py-2">Okupansi</th>
                    </tr>
                </thead>
                <tbody id="pen-summary-table-body">
                    <tr><td colspan="7" class="text-center py-6 text-gray-400">Memuat data...</tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah Kandang --}}
<div id="add-pen-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="bg-black/40 backdrop-blur-md rounded-2xl p-6 max-w-md w-full z-10 border border-white/20 shadow-2xl">
            <h3 class="text-white text-xl font-bold mb-5">Tambah Kandang Baru</h3>
            <form id="add-pen-form" class="space-y-4">
                @csrf
                <div><label class="block text-gray-200 text-sm font-medium mb-1">Nama Kandang</label><input type="text" name="name" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500"></div>
                <div><label class="block text-gray-200 text-sm font-medium mb-1">Kode (opsional)</label><input type="text" name="code" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500"></div>
                <div><label class="block text-gray-200 text-sm font-medium mb-1">Kategori Kandang</label>
                    <select name="category" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Kategori</option>
                        <option value="Melahirkan">Melahirkan</option>
                        <option value="Menyusui">Menyusui</option>
                        <option value="Kawin">Kawin</option>
                        <option value="Karantina">Karantina</option>
                        <option value="Persiapan Breeding">Persiapan Breeding</option>
                        <option value="Lapak">Lapak</option>
                        <option value="Fattening">Fattening</option>
                        <option value="Prasapih">Prasapih</option>
                        <option value="Kambing">Kambing</option>
                        <option value="Kambing Jantan">Kambing Jantan</option>
                        <option value="Breeding">Breeding</option>
                    </select>
                </div>
                <div><label class="block text-gray-200 text-sm font-medium mb-1">Pilih ABK</label>
                    <select name="abk" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih ABK</option>
                        <option value="Yudianto">Yudianto</option>
                        <option value="Rio Hanif">Rio Hanif</option>
                        <option value="Fais Al Aqib">Fais Al Aqib</option>
                        <option value="Didik Suharianto">Didik Suharianto</option>
                        <option value="Herianto">Herianto</option>
                    </select>
                </div>
                <div><label class="block text-gray-200 text-sm font-medium mb-1">Kapasitas (ekor)</label><input type="number" name="capacity" min="1" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500"></div>
                <div><label class="block text-gray-200 text-sm font-medium mb-1">Status</label>
                    <select name="status" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeAddPenModal()" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl transition">Batal</button>
                    <button type="button" onclick="submitAddPenForm()" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl shadow-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Impor Excel Kandang --}}
<div id="import-pen-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="bg-black/40 backdrop-blur-md rounded-2xl p-6 max-w-lg w-full z-10 border border-white/20 shadow-2xl">
            <h3 class="text-white text-xl font-bold mb-5">Impor Data Kandang dari Excel</h3>
            <form id="import-pen-form" enctype="multipart/form-data">
                @csrf
                <div class="mb-4"><label class="block text-gray-200 text-sm font-medium mb-2">Pilih file Excel</label><input type="file" name="file" accept=".xlsx,.xls,.csv" required class="block w-full bg-white/10 border border-white/20 rounded-xl p-2 text-white"></div>
                <div class="mb-4"><p class="text-sm text-gray-400">Format kolom: <code class="text-emerald-300">nama, kode, kategori, kapasitas, status</code>. Baris pertama harus header.</p></div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeImportPenModal()" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl shadow-md">Impor</button>
                </div>
            </form>
            <div id="import-pen-progress" class="hidden mt-4 text-center"><div class="loading-spinner mx-auto"></div><p class="text-gray-400 text-sm mt-2">Memproses...</p></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ==================== VARIABLES ====================
let currentPage = 1;
let filters = {};

// ==================== DOCUMENT READY ====================
document.addEventListener('DOMContentLoaded', function() {
    loadPensData();
    loadPenOptions();
    loadPenSummary();
});

// ==================== DAFTAR KANDANG (TABEL UTAMA) ====================
async function loadPensData() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/pens/data');
        if (response.success) {
            renderPensTable(response.data.pens);
            updatePensStats(response.data.stats);
        } else {
            showError(response.message);
        }
    } catch (error) {
        console.error(error);
        document.getElementById('pens-table-body').innerHTML = '<tr><td colspan="8" class="text-center py-8 text-red-400">Koneksi error<\/td><\/tr>';
    }
}

function renderPensTable(pens) {
    const tbody = document.getElementById('pens-table-body');
    if (!pens || pens.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center py-8 text-gray-400">Belum ada data<\/td><\/tr>';
        return;
    }
    let html = '';
    for (const pen of pens) {
        const occupancyPercent = pen.capacity ? (pen.current_occupancy / pen.capacity * 100) : 0;
        html += `
            <tr class="border-b border-white/10 hover:bg-white/5 transition">
                <td class="px-6 py-3 font-medium">${escapeHtml(pen.name || '-')}<\/td>
                <td class="px-6 py-3">${escapeHtml(pen.abk || '-')}<\/td>
                <td class="px-6 py-3"><span class="px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-200 text-xs">${escapeHtml(pen.category)}<\/span><\/td>
                <td class="px-6 py-3">${pen.age_days || 0} hari<\/td>
                <td class="px-6 py-3">${pen.capacity}<\/td>
                <td class="px-6 py-3">
                    ${pen.current_occupancy || 0}
                    <div class="w-24 bg-white/10 rounded-full h-1.5 mt-1">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: ${occupancyPercent}%"><\/div>
                    </div>
                <\/td>
                <td class="px-6 py-3"><span class="px-2 py-1 rounded-full text-xs ${pen.status === 'active' ? 'bg-emerald-500/20 text-emerald-200' : 'bg-red-500/20 text-red-200'}">${pen.status === 'active' ? 'Aktif' : 'Nonaktif'}<\/span><\/td>
                <td class="px-6 py-3 text-right">
                    <a href="/pens/${pen.id}" class="text-emerald-400 hover:text-emerald-300 mr-2" title="Detail"><i class="fas fa-eye"><\/i><\/a>
                    <a href="/pens/${pen.id}/analytics" class="text-blue-400 hover:text-blue-300" title="Analisis"><i class="fas fa-chart-line"><\/i><\/a>
                <\/td>
            <\/tr>
        `;
    }
    tbody.innerHTML = html;
}

function updatePensStats(stats) {
    if (!stats) return;
    document.getElementById('total-pens').innerText = stats.total_pens || 0;
    document.getElementById('total-capacity').innerText = stats.total_capacity || 0;
    document.getElementById('total-livestock-overall').innerText = stats.total_livestock_overall || 0;
    document.getElementById('available-pens').innerText = stats.available_pens || 0;
}

// ==================== LIST TAG & BB TERNAK PER KANDANG ====================
async function loadPenOptions() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/pens/data');
        if (response.success && response.data.pens) {
            const select = document.getElementById('pen-filter-livestock');
            let options = '<option value="">-- Pilih Kandang --</option>';
            for (const pen of response.data.pens) {
                options += `<option value="${pen.id}">${escapeHtml(pen.name)} (${escapeHtml(pen.category)})</option>`;
            }
            select.innerHTML = options;
        }
    } catch(error) {
        console.error(error);
        document.getElementById('pen-filter-livestock').innerHTML = '<option value="">Gagal memuat kandang</option>';
    }
}

async function loadLivestockByPen() {
    const penId = document.getElementById('pen-filter-livestock').value;
    const tbody = document.getElementById('livestock-table-body');
    if (!penId) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-6 text-gray-400">Pilih kandang terlebih dahulu<\/td><\/tr>';
        return;
    }
    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-6 text-gray-400">Memuat...<\/td><\/tr>';
    try {
        const response = await TernakPark.api.fetchData(`/web-api/pens/livestock?pen_id=${penId}`);
        if (response.success) {
            const livestocks = response.data.livestocks || [];
            if (livestocks.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-6 text-gray-400">Tidak ada ternak di kandang ini<\/td><\/tr>';
                return;
            }
            let html = '';
            for (const livestock of livestocks) {
                html += `
                    <tr class="border-b border-white/10">
                        <td class="px-3 py-2">${escapeHtml(livestock.ear_tag)}<\/td>
                        <td class="px-3 py-2">${livestock.gender === 'male' ? 'Jantan' : 'Betina'}<\/td>
                        <td class="px-3 py-2">${escapeHtml(livestock.breed_type || '-')}<\/td>
                        <td class="px-3 py-2">${livestock.current_weight}<\/td>
                        <td class="px-3 py-2">${escapeHtml(livestock.condition || '-')}<\/td>
                        <td class="px-3 py-2">${escapeHtml(response.data.pen?.abk || '-')}<\/td>
                        <td class="px-3 py-2">${livestock.age_days ?? '-'}<\/td>
                    <\/tr>
                `;
            }
            tbody.innerHTML = html;
        } else {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center py-6 text-red-400">${escapeHtml(response.message || 'Gagal memuat data')}<\/td><\/tr>`;
        }
    } catch(error) {
        console.error(error);
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-6 text-red-400">Koneksi error<\/td><\/tr>';
    }
}

// ==================== LIST JUMLAH TERNAK & TOTAL BOBOT PER KANDANG ====================
async function loadPenSummary() {
    const tbody = document.getElementById('pen-summary-table-body');
    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-6 text-gray-400">Memuat data...<\/tr>';
    try {
        const response = await TernakPark.api.fetchData('/web-api/pens/livestock');
        if (response.success && response.data) {
            const data = response.data;
            if (!data || data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-6 text-gray-400">Belum ada data kandang<\/td><\/tr>';
                return;
            }
            let html = '';
            for (const pen of data) {
                const occupancyPercentage = pen.occupancy_percent ? pen.occupancy_percent : (pen.capacity ? ((pen.livestock_count / pen.capacity) * 100).toFixed(1) : 0);
                html += `
                    <tr class="border-b border-white/10">
                        <td class="px-3 py-2">${escapeHtml(pen.name)}<\/td>
                        <td class="px-3 py-2">${escapeHtml(pen.abk || '-')}<\/td>
                        <td class="px-3 py-2">${escapeHtml(pen.category)}<\/td>
                        <td class="px-3 py-2">${pen.livestock_count}<\/td>
                        <td class="px-3 py-2">${pen.total_weight}<\/td>
                        <td class="px-3 py-2">${pen.capacity}<\/td>
                        <td class="px-3 py-2">${occupancyPercentage}%<\/td>
                    <\/tr>
                `;
            }
            tbody.innerHTML = html;
        } else {
            tbody.innerHTML = `<td><td colspan="7" class="text-center py-6 text-red-400">${escapeHtml(response.message || 'Gagal memuat data')}<\/td><\/tr>`;
        }
    } catch(error) {
        console.error(error);
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-6 text-red-400">Koneksi error<\/td><\/tr>';
    }
}

// ==================== MODAL TAMBAH KANDANG ====================
function openAddPenModal() {
    document.getElementById('add-pen-modal').classList.remove('hidden');
}
function closeAddPenModal() {
    document.getElementById('add-pen-modal').classList.add('hidden');
    document.getElementById('add-pen-form').reset();
}
async function submitAddPenForm() {
    const form = document.getElementById('add-pen-form');
    const data = Object.fromEntries(new FormData(form));
    const submitButton = form.querySelector('button[type="button"]:last-child');
    const originalText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = 'Menyimpan...';
    try {
        const response = await fetch('/web-api/pens/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (response.ok && result.success) {
            closeAddPenModal();
            loadPensData();
            loadPenOptions();
            loadPenSummary();
            TernakPark.ui.showToast('Kandang berhasil ditambahkan', 'success');
        } else {
            TernakPark.ui.showToast(result.message || 'Gagal menambahkan kandang', 'error');
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error', 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    }
}

// ==================== MODAL IMPOR EXCEL ====================
function openImportPenModal() {
    document.getElementById('import-pen-modal').classList.remove('hidden');
}
function closeImportPenModal() {
    document.getElementById('import-pen-modal').classList.add('hidden');
    document.getElementById('import-pen-form').reset();
    document.getElementById('import-pen-progress').classList.add('hidden');
}
document.getElementById('import-pen-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    submitButton.disabled = true;
    document.getElementById('import-pen-progress').classList.remove('hidden');
    try {
        const response = await fetch('/web-api/pens/import', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        });
        const result = await response.json();
        if (response.ok && result.success) {
            TernakPark.ui.showToast('Data kandang berhasil diimpor: ' + (result.imported || 0) + ' record', 'success');
            closeImportPenModal();
            loadPensData();
            loadPenOptions();
            loadPenSummary();
        } else {
            TernakPark.ui.showToast(result.message || 'Gagal impor', 'error');
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error', 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
        document.getElementById('import-pen-progress').classList.add('hidden');
    }
});

// ==================== UTILITIES ====================
function showError(message) {
    TernakPark.ui.showToast(message, 'error');
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
