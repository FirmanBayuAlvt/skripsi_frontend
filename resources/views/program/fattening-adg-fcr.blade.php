@extends('layouts.app')

@section('title', 'ADG & FCR - Fattening')
@section('header-title', 'ADG & FCR Analysis')

@section('content')
<div class="space-y-6">
    <div class="flex justify-end">
        <a href="{{ route('program.fattening') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Fattening
        </a>
    </div>

    <div class="glass-card p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white/5 p-3 rounded-xl text-center"><p class="text-gray-400">ADG (kg/hari)</p><p class="text-2xl font-bold text-emerald-300" id="summaryAdg">-</p></div>
            <div class="bg-white/5 p-3 rounded-xl text-center"><p class="text-gray-400">Upweight (kg)</p><p class="text-2xl font-bold text-emerald-300" id="summaryUpweight">-</p></div>
            <div class="bg-white/5 p-3 rounded-xl text-center"><p class="text-gray-400">QTY ternak</p><p class="text-2xl font-bold text-emerald-300" id="summaryQty">-</p></div>
            <div class="bg-white/5 p-3 rounded-xl text-center"><p class="text-gray-400">FCR</p><p class="text-2xl font-bold text-emerald-300" id="summaryFcr">-</p></div>
        </div>

        <div class="mb-6"><h4 class="font-semibold text-white">📈 Average ADG per bulan</h4><canvas id="adgPerBulanChart" height="250"></canvas></div>

        <div class="mb-6">
            <div class="flex flex-wrap gap-4 items-end mb-3">
                <div><label class="text-gray-300 text-sm">Tanggal Awal</label><input type="date" id="startDate" class="bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"></div>
                <div><label class="text-gray-300 text-sm">Tanggal Akhir</label><input type="date" id="endDate" class="bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"></div>
                <button id="filterDateBtn" class="bg-emerald-600 px-4 py-2 rounded-xl">Filter</button>
            </div>
            <div class="overflow-x-auto"><table class="custom-table w-full text-sm"><thead><tr><th>Bulan</th><th>TAGGING</th><th>BB</th><th>Upweight</th><th>ADG</th></tr></thead><tbody id="tabelDataTernak"></tbody></table></div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white/5 p-4 rounded-xl"><p class="text-gray-300">🌾 Qty pakan (kg)</p><p class="text-2xl font-bold" id="qtyPakan">-</p><p class="mt-2">📈 Total upweight (kg)</p><p class="text-2xl font-bold" id="totalUpweight">-</p></div>
            <div><h4 class="font-semibold text-white">🥕 Jenis pakan yang digunakan</h4><canvas id="pieChartPakan" height="200"></canvas></div>
        </div>

        <div class="overflow-x-auto mb-6"><table class="custom-table w-full text-sm"><thead><tr><th>JENIS PAKAN</th><th>KELUAR (Kg)</th><th>Persentase</th></tr></thead><tbody id="tabelPakan"></tbody></table></div>
        <div><h4 class="font-semibold text-white">📉 FCR per bulan</h4><canvas id="fcrPerBulanChart" height="250"></canvas></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let adgPerBulanChart, pieChartPakan, fcrPerBulanChart;

document.addEventListener('DOMContentLoaded', function() {
    loadAdgFcrData();
    document.getElementById('filterDateBtn').addEventListener('click', applyDateFilter);
});

async function loadAdgFcrData(startDate='', endDate='') {
    let url = '/web-api/program/fattening-adg-fcr';
    if (startDate && endDate) url += `?start_date=${startDate}&end_date=${endDate}`;
    try {
        const res = await TernakPark.api.fetchData(url);
        if (res.success) {
            const d = res.data;
            document.getElementById('summaryAdg').innerText = d.avg_adg?.toFixed(3) || '0';
            document.getElementById('summaryUpweight').innerText = d.total_upweight?.toFixed(2) || '0';
            document.getElementById('summaryQty').innerText = d.qty_ternak || '0';
            document.getElementById('summaryFcr').innerText = d.fcr?.toFixed(2) || '0';
            document.getElementById('qtyPakan').innerText = (d.qty_pakan || 0).toLocaleString();
            document.getElementById('totalUpweight').innerText = (d.total_upweight || 0).toLocaleString();

            if (adgPerBulanChart) adgPerBulanChart.destroy();
            adgPerBulanChart = new Chart(document.getElementById('adgPerBulanChart'), { type:'bar', data:{ labels:d.adg_bulan_labels||[], datasets:[{ label:'ADG (kg/hari)', data:d.adg_bulan_values||[], backgroundColor:'#f59e0b' }] } });

            renderSimpleTable('tabelDataTernak', d.data_ternak, ['bulan','ear_tag','bb','upweight','adg']);

            if (pieChartPakan) pieChartPakan.destroy();
            pieChartPakan = new Chart(document.getElementById('pieChartPakan'), { type:'pie', data:{ labels:d.pakan_labels||[], datasets:[{ data:d.pakan_values||[], backgroundColor:['#10b981','#3b82f6','#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6','#f97316','#6b7280','#a855f7'] }] } });

            renderSimpleTable('tabelPakan', d.pakan_rincian, ['nama_pakan','keluar_kg','persentase']);

            if (fcrPerBulanChart) fcrPerBulanChart.destroy();
            fcrPerBulanChart = new Chart(document.getElementById('fcrPerBulanChart'), { type:'bar', data:{ labels:d.fcr_bulan_labels||[], datasets:[{ label:'Nilai FCR', data:d.fcr_bulan_values||[], backgroundColor:'#ef4444' }] } });
        } else TernakPark.ui.showToast(res.message || 'Gagal memuat data', 'error');
    } catch(e) { TernakPark.ui.showToast('Koneksi error', 'error'); }
}

async function applyDateFilter() {
    const start = document.getElementById('startDate').value, end = document.getElementById('endDate').value;
    if (!start || !end) { TernakPark.ui.showToast('Pilih kedua tanggal', 'warning'); return; }
    await loadAdgFcrData(start, end);
}

function renderSimpleTable(tbodyId, data, fields) {
    const tbody = document.getElementById(tbodyId);
    if (!data || data.length === 0) { tbody.innerHTML = `<tr><td colspan="${fields.length}" class="text-center py-2 text-gray-400">Tidak ada data</td></table>`; return; }
    let html = '';
    data.forEach(row => {
        html += '<tr class="border-b border-white/10">';
        fields.forEach(f => { html += `<td class="px-2 py-1">${escapeHtml(row[f]??'-')}</td>`; });
        html += '</tr>';
    });
    tbody.innerHTML = html;
}
function escapeHtml(str) { return String(str).replace(/[&<>]/g, m => ({ '&':'&amp;','<':'&lt;','>':'&gt;' }[m])); }
</script>
@endpush
