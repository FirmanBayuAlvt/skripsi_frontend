@extends('layouts.app')

@section('title', 'Detail per Ternak - Fattening')
@section('header-title', 'Detail per Ternak (Fattening)')

@section('content')
<div class="space-y-6">
    <div class="flex justify-end">
        <a href="{{ route('program.fattening') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Fattening
        </a>
    </div>

    <div class="glass-card p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-300 text-sm mb-1">Pilih Ear Tag</label>
                <select id="tagSelect" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white">
                    <option value="">-- Pilih Ternak --</option>
                </select>
            </div>
            <div></div>
        </div>

        <div id="detailInfo" class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-3 text-sm bg-white/5 rounded-xl p-4 border border-white/10">
            <!-- Akan diisi JS -->
        </div>

        <div class="mt-6">
            <h4 class="font-semibold text-white mb-2">📊 Upweight Ternak 6 Bulan Terakhir (kg)</h4>
            <canvas id="upweightChart" height="250" class="w-full bg-white/5 rounded-xl p-2"></canvas>
        </div>

        <div class="mt-6">
            <h4 class="font-semibold text-white mb-2">📋 Data Timbang Ternak Per Bulan</h4>
            <div class="overflow-x-auto">
                <table class="custom-table w-full text-sm">
                    <thead class="bg-white/5"><tr class="text-gray-300"><th class="px-3 py-2">Tagging</th><th>BB IN (kg)</th><th>BB 4 bln lalu</th><th>BB 3 bln lalu</th><th>BB 2 bln lalu</th><th>BB Bulan Lalu</th><th>BB Terbaru</th></tr></thead>
                    <tbody id="tabelTimbang"></tbody>
                ｜DSML｜
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let upweightChart;

document.addEventListener('DOMContentLoaded', function() {
    loadTernakList();
    document.getElementById('tagSelect').addEventListener('change', function() {
        if (this.value) loadDetail(this.value);
    });
});

async function loadTernakList() {
    try {
        const res = await TernakPark.api.fetchData('/web-api/livestocks/data?per_page=1000');
        if (res.success && res.data.livestocks) {
            const select = document.getElementById('tagSelect');
            select.innerHTML = '<option value="">-- Pilih Ternak --</option>';
            res.data.livestocks.forEach(l => {
                select.innerHTML += `<option value="${l.id}">${escapeHtml(l.ear_tag)} - ${escapeHtml(l.breed_type)}</option>`;
            });
        }
    } catch(e) { TernakPark.ui.showToast('Gagal memuat daftar ternak', 'error'); }
}

async function loadDetail(id) {
    try {
        const res = await TernakPark.api.fetchData(`/web-api/livestocks/${id}/detail`);
        if (res.success) {
            const l = res.data;
            const infoHtml = `
                <div><span class="text-gray-400">Tag:</span> ${escapeHtml(l.ear_tag)}</div>
                <div><span class="text-gray-400">KANDANG:</span> ${escapeHtml(l.pen?.name || '-')}</div>
                <div><span class="text-gray-400">KONDISI:</span> ${escapeHtml(l.condition || '-')}</div>
                <div><span class="text-gray-400">SEX:</span> ${l.gender === 'male' ? 'Jantan' : 'Betina'}</div>
                <div><span class="text-gray-400">BB IN (kg):</span> ${l.initial_weight}</div>
                <div><span class="text-gray-400">BB Terbaru:</span> ${l.current_weight}</div>
                <div><span class="text-gray-400">ADG Terbaru:</span> ${l.average_daily_gain?.toFixed(3) || 'null'}</div>
                <div><span class="text-gray-400">DAY ON FARM:</span> ${l.day_on_farm || 0}</div>
                <div><span class="text-gray-400">UMUR (days):</span> ${l.age_days}</div>
                <div><span class="text-gray-400">JENIS DOMBA:</span> ${escapeHtml(l.breed_type?.replace(/_/g, ' ') || '-')}</div>
            `;
            document.getElementById('detailInfo').innerHTML = infoHtml;

            const weightRecords = l.weight_records || [];
            const last6 = weightRecords.slice(-6);
            const labels = last6.map(w => new Date(w.record_date).toLocaleDateString('id-ID', { month:'short', year:'numeric' }));
            const values = last6.map(w => w.weight_kg);
            if (upweightChart) upweightChart.destroy();
            upweightChart = new Chart(document.getElementById('upweightChart'), {
                type: 'bar',
                data: { labels: labels.length ? labels : ['Tidak cukup data'], datasets: [{ label: 'Upweight (kg)', data: values.length ? values : [0], backgroundColor: '#10b981' }] }
            });

            let timbangHtml = '';
            if (weightRecords.length) {
                const bbList = [l.initial_weight, ...weightRecords.slice(-5).map(w=>w.weight_kg)];
                while(bbList.length<6) bbList.push('-');
                timbangHtml = `<tr><td class="px-3 py-2">${escapeHtml(l.ear_tag)}</td>${bbList.map(v=>`<td class="px-3 py-2">${v}</td>`).join('')}</tr>`;
            } else {
                timbangHtml = '<tr><td colspan="6" class="text-center text-gray-400">Belum ada data timbang</td></tr>';
            }
            document.getElementById('tabelTimbang').innerHTML = timbangHtml;
        } else {
            TernakPark.ui.showToast('Gagal memuat detail', 'error');
        }
    } catch(e) { TernakPark.ui.showToast('Koneksi error', 'error'); }
}

function escapeHtml(str) { return String(str).replace(/[&<>]/g, m => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;' }[m])); }
</script>
@endpush
