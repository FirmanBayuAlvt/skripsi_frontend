@extends('layouts.app')

@section('title', 'Analisis Korelasi')
@section('header-title', 'Analisis Korelasi Pakan')

@section('content')
<div class="space-y-6">
    <div class="glass-card p-6">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-6">
            <i class="fas fa-chart-line text-emerald-400 text-xl"></i>
            <h2 class="font-bold text-white text-xl">Matriks Korelasi</h2>
        </div>
        <div id="correlation-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="text-center col-span-full text-gray-400">Memuat data korelasi...</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', loadCorrelation);

async function loadCorrelation() {
    try {
        const res = await TernakPark.api.fetchData('/web-api/predictions/correlation');
        if (res.success && res.data) {
            renderCorrelation(res.data);
        } else {
            document.getElementById('correlation-grid').innerHTML = '<div class="text-center col-span-full text-red-400">Gagal memuat data korelasi</div>';
            TernakPark.ui.showToast('Gagal memuat data korelasi', 'error');
        }
    } catch (e) {
        console.error(e);
        document.getElementById('correlation-grid').innerHTML = '<div class="text-center col-span-full text-red-400">Koneksi error</div>';
        TernakPark.ui.showToast('Koneksi error saat memuat korelasi', 'error');
    }
}

function renderCorrelation(data) {
    const factors = data.factors || {};
    const grid = document.getElementById('correlation-grid');

    if (Object.keys(factors).length === 0) {
        grid.innerHTML = '<div class="text-center col-span-full text-gray-400">Tidak ada data faktor korelasi</div>';
        return;
    }

    let html = '';
    for (const [key, value] of Object.entries(factors)) {
        const correlationValue = parseFloat(value).toFixed(2);
        let colorClass = '';
        let bgClass = '';
        if (value > 0.7) {
            colorClass = 'text-emerald-300';
            bgClass = 'bg-emerald-500/10';
        } else if (value > 0.5) {
            colorClass = 'text-emerald-200';
            bgClass = 'bg-emerald-500/5';
        } else if (value > 0.3) {
            colorClass = 'text-yellow-300';
            bgClass = 'bg-yellow-500/10';
        } else {
            colorClass = 'text-gray-400';
            bgClass = 'bg-white/5';
        }

        html += `
            <div class="flex justify-between items-center p-4 rounded-xl border border-white/10 ${bgClass} hover:border-emerald-400/50 transition">
                <span class="font-medium text-white">${escapeHtml(key)}</span>
                <span class="text-lg font-bold ${colorClass}">${correlationValue}</span>
            </div>
        `;
    }
    grid.innerHTML = html;
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}
</script>
@endpush
