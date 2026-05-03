@extends('layouts.app')

@section('title', 'HPP Ternak')
@section('header-title', 'Harga Pokok Produksi (HPP)')

@section('content')
<div class="space-y-8">
    <!-- Tombol Kembali ke Dashboard -->
    <div class="flex justify-end">
        <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Ringkasan HPP Premium dengan Kartu Glassmorphism -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Total HPP Jantan</p>
                    <p class="stat-value" id="total-hpp-jantan">Rp -</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-mars text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Total HPP Betina</p>
                    <p class="stat-value" id="total-hpp-betina">Rp -</p>
                </div>
                <div class="bg-pink-500/20 p-3 rounded-2xl">
                    <i class="fas fa-venus text-pink-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Qty Jantan Breeding</p>
                    <p class="stat-value" id="qty-jantan-breeding">-</p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-2xl">
                    <i class="fas fa-heartbeat text-blue-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Total HPP Jantan Breeding</p>
                    <p class="stat-value" id="total-hpp-jantan-breeding">Rp -</p>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-2xl">
                    <i class="fas fa-chart-line text-purple-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Qty Jantan Fattening</p>
                    <p class="stat-value" id="qty-jantan-fattening">-</p>
                </div>
                <div class="bg-amber-500/20 p-3 rounded-2xl">
                    <i class="fas fa-weight-hanging text-amber-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Total HPP Jantan Fattening</p>
                    <p class="stat-value" id="total-hpp-jantan-fattening">Rp -</p>
                </div>
                <div class="bg-orange-500/20 p-3 rounded-2xl">
                    <i class="fas fa-chart-simple text-orange-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Qty Betina</p>
                    <p class="stat-value" id="qty-betina">-</p>
                </div>
                <div class="bg-rose-500/20 p-3 rounded-2xl">
                    <i class="fas fa-female text-rose-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Total HPP Betina</p>
                    <p class="stat-value" id="total-hpp-betina-detail">Rp -</p>
                </div>
                <div class="bg-teal-500/20 p-3 rounded-2xl">
                    <i class="fas fa-coins text-teal-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail HPP dengan Gaya Glassmorphism Premium -->
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-table-list text-emerald-400 text-xl"></i>
            <h3 class="font-bold text-white text-lg">Detail HPP per Ternak</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm text-white">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Tagging</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">HPP Pembelian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Pakan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Operasional</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Total HPP</th>
                    </tr>
                </thead>
                <tbody id="hpp-table">
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Memuat data...</td>
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
    loadHppData();
});

async function loadHppData() {
    try {
        const res = await TernakPark.api.fetchData('/web-api/hpp');
        if (res.success) {
            const data = res.data;
            document.getElementById('total-hpp-jantan').innerText = formatRupiah(data.total_hpp_jantan);
            document.getElementById('total-hpp-betina').innerText = formatRupiah(data.total_hpp_betina);
            document.getElementById('qty-jantan-breeding').innerText = data.qty_jantan_breeding;
            document.getElementById('total-hpp-jantan-breeding').innerText = formatRupiah(data.total_hpp_jantan_breeding);
            document.getElementById('qty-jantan-fattening').innerText = data.qty_jantan_fattening;
            document.getElementById('total-hpp-jantan-fattening').innerText = formatRupiah(data.total_hpp_jantan_fattening);
            document.getElementById('qty-betina').innerText = data.qty_betina;
            document.getElementById('total-hpp-betina-detail').innerText = formatRupiah(data.total_hpp_betina_detail);
            renderHppTable(data.detail);
        } else {
            TernakPark.ui.showToast(res.message || 'Gagal memuat data HPP', 'error');
        }
    } catch(e) {
        console.error(e);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
}

function renderHppTable(detail) {
    const tbody = document.getElementById('hpp-table');
    if (!detail || detail.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada data</td></tr>';
        return;
    }
    let html = '';
    detail.forEach(d => {
        html += `
            <tr class="border-b border-white/10 hover:bg-white/5 transition">
                <td class="px-6 py-3 font-medium">${escapeHtml(d.tagging)}</td>
                <td class="px-6 py-3">${formatRupiah(d.hpp_pembelian)}</td>
                <td class="px-6 py-3">${formatRupiah(d.pakan)}</td>
                <td class="px-6 py-3">${formatRupiah(d.operasional)}</td>
                <td class="px-6 py-3 text-emerald-300 font-semibold">${formatRupiah(d.total)}</td>
            </tr>
        `;
    });
    tbody.innerHTML = html;
}

function formatRupiah(angka) {
    if (angka === undefined || angka === null) return 'Rp 0';
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
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
