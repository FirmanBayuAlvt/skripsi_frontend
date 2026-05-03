@extends('layouts.app')

@section('title', 'Stok Pakan')
@section('header-title', 'Stok Pakan')

@section('content')
<div class="space-y-6">
    <!-- Tombol Kembali ke Manajemen Pakan -->
    <div class="flex justify-end">
        <a href="{{ route('feeds.index') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Pakan
        </a>
    </div>

    <div class="glass-card p-6">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-boxes text-emerald-400 text-xl"></i>
            <h2 class="font-bold text-white text-xl">Tingkat Stok Pakan</h2>
        </div>

        <div id="stock-list" class="space-y-4">
            <div class="text-center text-gray-300">Memuat...</div>
        </div>

        <div class="mt-6">
            <h3 class="text-gray-200 font-semibold text-lg mb-3">Ringkasan</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="stat-card p-4">
                    <span class="text-gray-300 text-sm">Total Nilai Stok</span>
                    <p class="text-2xl font-bold text-emerald-300" id="total-value">-</p>
                </div>
                <div class="stat-card p-4">
                    <span class="text-gray-300 text-sm">Stok Rendah</span>
                    <p class="text-2xl font-bold text-emerald-300" id="low-count">-</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', loadStock);

async function loadStock() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/feeds/stock-levels');
        if (response.success) {
            renderStockData(response.data);
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data stok', 'error');
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    }
}

function renderStockData(data) {
    const container = document.getElementById('stock-list');
    if (!data.feed_types || data.feed_types.length === 0) {
        container.innerHTML = '<div class="text-center text-gray-400">Belum ada data pakan</div>';
        document.getElementById('total-value').innerText = TernakPark.format.currency(0);
        document.getElementById('low-count').innerText = '0';
        return;
    }

    let html = '';
    for (const feed of data.feed_types) {
        const stockValue = feed.current_stock;
        const isLowStock = stockValue < 100;
        // Persentase bar (asumsi kapasitas max 500 kg untuk tampilan visual)
        const widthPercent = Math.min((stockValue / 500) * 100, 100);

        html += `
            <div class="flex items-center justify-between p-3 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-sm hover:border-emerald-400/50 transition">
                <div>
                    <span class="font-medium text-white">${escapeHtml(feed.name)}</span>
                    <span class="ml-2 text-sm text-gray-300">${escapeHtml(feed.category)}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="${isLowStock ? 'text-red-300 font-bold' : 'text-white'}">${stockValue} kg</span>
                    <div class="w-32 bg-gray-700 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: ${widthPercent}%"></div>
                    </div>
                </div>
            </div>
        `;
    }
    container.innerHTML = html;

    document.getElementById('total-value').innerText = TernakPark.format.currency(data.stock_summary.total_value);
    document.getElementById('low-count').innerText = data.stock_summary.low_stock_count;
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
