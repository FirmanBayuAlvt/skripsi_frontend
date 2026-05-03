@extends('layouts.app')

@section('title', 'Data Timbang - Fattening')
@section('header-title', 'Data Timbang (Fattening)')

@section('content')
<div class="space-y-6">
    <div class="flex justify-end">
        <a href="{{ route('program.fattening') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Fattening
        </a>
    </div>

    <div class="glass-card p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div><label class="text-gray-300 text-sm">Tagging</label><select id="filterTagging" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"><option value="">Semua</option></select></div>
            <div><label class="text-gray-300 text-sm">Jenis Domba</label><select id="filterJenis" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"><option value="">Semua</option></select></div>
            <div><label class="text-gray-300 text-sm">Kategori Kandang</label><select id="filterKategori" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"><option value="">Semua</option></select></div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white/5 rounded-xl p-4">
                <p class="text-gray-300">🐏 Qty ternak dengan ADG minus 2x berturut-turut</p>
                <p class="text-3xl font-bold text-red-300" id="qtyMinus2x">0</p>
                <div class="mt-3 overflow-x-auto">
                    <table class="custom-table w-full text-xs"><thead><tr><th>Tagging</th><th>Kandang</th><th>Kategori</th><th>Jenis Domba</th><th>ADG Terbaru</th></tr></thead><tbody id="tabelMinus2x"></tbody></table>
                </div>
            </div>
            <div class="bg-white/5 rounded-xl p-4">
                <p class="text-gray-300">📈 Qty ternak upweight minus timbang terakhir</p>
                <p class="text-3xl font-bold text-emerald-300" id="qtyUpweightMinus">0</p>
                <div class="mt-3 overflow-x-auto">
                    <table class="custom-table w-full text-xs"><thead><tr><th>Tagging</th><th>Kandang</th><th>Kategori</th><th>Jenis Domba</th><th>ADG Terbaru</th></tr></thead><tbody id="tabelUpweightMinus"></tbody></table>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <h4 class="font-semibold text-white">📋 Data Timbang Ternak Per Bulan</h4>
            <div class="overflow-x-auto"><table class="custom-table w-full text-sm"><thead><tr><th>Tagging</th><th>BB IN</th><th>BB 4 bln lalu</th><th>BB 3 bln lalu</th><th>BB 2 bln lalu</th><th>BB Bulan Lalu</th><th>BB Terbaru</th></tr></thead><tbody id="tabelTimbangData"></tbody></table></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadFilters();
    loadDataTimbang();
    document.getElementById('filterTagging').addEventListener('change', loadDataTimbang);
    document.getElementById('filterJenis').addEventListener('change', loadDataTimbang);
    document.getElementById('filterKategori').addEventListener('change', loadDataTimbang);
});

async function loadFilters() {
    try {
        const [livestockRes, penRes] = await Promise.all([
            TernakPark.api.fetchData('/web-api/livestocks/data?per_page=1000'),
            TernakPark.api.fetchData('/web-api/pens/data')
        ]);
        if (livestockRes.success) {
            const taggingSelect = document.getElementById('filterTagging');
            taggingSelect.innerHTML = '<option value="">Semua</option>';
            livestockRes.data.livestocks.forEach(l => taggingSelect.innerHTML += `<option value="${escapeHtml(l.ear_tag)}">${escapeHtml(l.ear_tag)}</option>`);
            const jenisSelect = document.getElementById('filterJenis');
            const breeds = [...new Set(livestockRes.data.livestocks.map(l=>l.breed_type))];
            jenisSelect.innerHTML = '<option value="">Semua</option>';
            breeds.forEach(b => jenisSelect.innerHTML += `<option value="${b}">${escapeHtml(b.replace(/_/g,' '))}</option>`);
        }
        if (penRes.success) {
            const kategoriSelect = document.getElementById('filterKategori');
            const kats = [...new Set(penRes.data.pens.map(p=>p.category))];
            kategoriSelect.innerHTML = '<option value="">Semua</option>';
            kats.forEach(k => kategoriSelect.innerHTML += `<option value="${k}">${escapeHtml(k)}</option>`);
        }
    } catch(e) { console.error(e); }
}

async function loadDataTimbang() {
    const params = new URLSearchParams({
        tagging: document.getElementById('filterTagging').value,
        jenis: document.getElementById('filterJenis').value,
        kategori: document.getElementById('filterKategori').value
    });
    try {
        const res = await TernakPark.api.fetchData(`/web-api/program/fattening-timbang?${params}`);
        if (res.success) {
            const d = res.data;
            document.getElementById('qtyMinus2x').innerText = d.qty_minus_2x || 0;
            document.getElementById('qtyUpweightMinus').innerText = d.qty_upweight_minus || 0;
            renderSimpleTable('tabelMinus2x', d.minus_2x_list, ['ear_tag','pen_name','pen_category','breed_type','adg']);
            renderSimpleTable('tabelUpweightMinus', d.upweight_minus_list, ['ear_tag','pen_name','pen_category','breed_type','adg']);
            renderSimpleTable('tabelTimbangData', d.timbang_per_bulan, ['ear_tag','bb_in','bb_4','bb_3','bb_2','bb_1','bb_now']);
        } else TernakPark.ui.showToast(res.message || 'Gagal memuat data timbang', 'error');
    } catch(e) { TernakPark.ui.showToast('Koneksi error', 'error'); }
}

function renderSimpleTable(tbodyId, data, fields) {
    const tbody = document.getElementById(tbodyId);
    if (!data || data.length === 0) { tbody.innerHTML = `<td><td colspan="${fields.length}" class="text-center py-2 text-gray-400">Tidak ada数据</td></td>`; return; }
    let html = '';
    data.forEach(row => {
        html += '<tr class="border-b border-white/10">';
        fields.forEach(f => {
            let val = row[f] ?? '-';
            if (f === 'adg') val = parseFloat(val).toFixed(4);
            html += `<td class="px-2 py-1">${escapeHtml(String(val))}</td>`;
        });
        html += '<tr>';
    });
    tbody.innerHTML = html;
}
function escapeHtml(str) { return String(str).replace(/[&<>]/g, m => ({ '&':'&amp;','<':'&lt;','>':'&gt;' }[m])); }
</script>
@endpush
