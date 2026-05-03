@extends('layouts.app')

@section('title', 'Logbook Kejadian')
@section('header-title', 'Logbook Kejadian')

@section('content')
<div class="space-y-6">
    <!-- Tombol Kembali ke Dashboard -->
    <div class="flex justify-end">
        <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Filter Section Premium -->
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-filter text-emerald-400"></i>
            <h3 class="font-bold text-white">Filter Logbook</h3>
        </div>
        <form id="logbook-filter" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Tagging</label>
                <input type="text" name="tagging" placeholder="Cari ear tag..." class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white placeholder:text-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Kejadian</label>
                <select name="kejadian" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Semua Kejadian</option>
                    <option>Vaksin</option>
                    <option>Pindah Kandang</option>
                    <option>Domba Masuk</option>
                    <option>Ganti Tag</option>
                    <option>Sakit</option>
                    <option>Melahirkan</option>
                    <option>Mati</option>
                    <option>Terjual</option>
                    <option>Lepas Sapih</option>
                    <option>Timbang 30 hari</option>
                    <option>Timbang 60 hari</option>
                    <option>Timbang 90 hari</option>
                    <option>Timbang 100 hari</option>
                    <option>Timbang 180 hari</option>
                    <option>Hamil</option>
                    <option>Rekam IB</option>
                    <option>Birahi</option>
                    <option>Timbang 360 hari</option>
                    <option>Disembelih</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl shadow-md transition-all transform hover:scale-[1.02]">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Logbook Premium -->
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-history text-emerald-400 text-xl"></i>
            <h3 class="font-bold text-white text-lg">Riwayat Kejadian</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm text-white">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Tanggal Kejadian</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Tagging</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Jenis Ternak</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kandang</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kelamin</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kejadian</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Keterangan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Penanganan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Tag Baru</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kandang Baru</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kategori Baru</th>
                    </tr>
                </thead>
                <tbody id="logbook-table">
                    <tr>
                        <td colspan="11" class="text-center py-8 text-gray-400">Memuat data...<\/td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load initial data
    loadLogbookData();

    // Event listener filter form
    const filterForm = document.getElementById('logbook-filter');
    if (filterForm) {
        filterForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            await loadLogbookData();
        });
    }
});

async function loadLogbookData() {
    const filterForm = document.getElementById('logbook-filter');
    const formData = new FormData(filterForm);
    const queryParameters = new URLSearchParams();

    for (const [key, value] of formData.entries()) {
        if (value) {
            queryParameters.append(key, value);
        }
    }

    const tableBody = document.getElementById('logbook-table');
    tableBody.innerHTML = '<tr><td colspan="11" class="text-center py-8 text-gray-400"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...<\/td><\/tr>';

    try {
        const response = await TernakPark.api.fetchData(`/web-api/logbook?${queryParameters.toString()}`);
        if (response.success) {
            renderLogbookTable(response.data);
        } else {
            const errorMessage = response.message || 'Gagal memuat data';
            tableBody.innerHTML = `<tr><td colspan="11" class="text-center py-8 text-red-400">${escapeHtml(errorMessage)}<\/td><\/tr>`;
            TernakPark.ui.showToast(errorMessage, 'error');
        }
    } catch (error) {
        console.error(error);
        tableBody.innerHTML = `<tr><td colspan="11" class="text-center py-8 text-red-400">Koneksi error: ${escapeHtml(error.message)}<\/td><\/tr>`;
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    }
}

function renderLogbookTable(records) {
    const tableBody = document.getElementById('logbook-table');
    if (!records || records.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="11" class="text-center py-8 text-gray-400">Tidak ada data logbook<\/td><\/tr>';
        return;
    }

    let html = '';
    for (const record of records) {
        html += `
            <tr class="border-b border-white/10 hover:bg-white/5 transition">
                <td class="px-4 py-3">${escapeHtml(record.tanggal_kejadian)}<\/td>
                <td class="px-4 py-3 font-medium">${escapeHtml(record.tagging)}<\/td>
                <td class="px-4 py-3">${escapeHtml(record.jenis_ternak)}<\/td>
                <td class="px-4 py-3">${escapeHtml(record.kandang)}<\/td>
                <td class="px-4 py-3">${escapeHtml(record.kelamin)}<\/td>
                <td class="px-4 py-3"><span class="px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-200 text-xs">${escapeHtml(record.kejadian)}<\/span><\/td>
                <td class="px-4 py-3">${escapeHtml(record.keterangan)}<\/td>
                <td class="px-4 py-3">${escapeHtml(record.penanganan)}<\/td>
                <td class="px-4 py-3">${escapeHtml(record.tag_baru)}<\/td>
                <td class="px-4 py-3">${escapeHtml(record.kandang_baru)}<\/td>
                <td class="px-4 py-3">${escapeHtml(record.kategori_kandang_baru)}<\/td>
            <\/tr>
        `;
    }
    tableBody.innerHTML = html;
}

function escapeHtml(str) {
    if (!str) return '-';
    return String(str).replace(/[&<>]/g, function(match) {
        if (match === '&') return '&amp;';
        if (match === '<') return '&lt;';
        if (match === '>') return '&gt;';
        return match;
    });
}
</script>
@endpush
