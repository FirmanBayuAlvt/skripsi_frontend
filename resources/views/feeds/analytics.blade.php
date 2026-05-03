@extends('layouts.app')

@section('title', 'Analisis Pakan')
@section('header-title', 'Analisis & Kalkulasi Pakan')

@section('content')
<div class="space-y-6">
    <!-- Tombol Kembali ke Manajemen Pakan -->
    <div class="flex justify-end">
        <a href="{{ route('feeds.index') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Pakan
        </a>
    </div>

    <!-- Ringkasan Biaya per Kategori dengan glassmorphism premium -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card p-4">
            <p class="text-gray-300 text-sm font-medium">Kalkulasi Pakan Kawin</p>
            <p class="text-2xl font-bold text-emerald-300" id="cost-kawin">Rp0</p>
        </div>
        <div class="glass-card p-4">
            <p class="text-gray-300 text-sm font-medium">Kalkulasi Pakan Fattening</p>
            <p class="text-2xl font-bold text-emerald-300" id="cost-fattening">Rp0</p>
        </div>
        <div class="glass-card p-4">
            <p class="text-gray-300 text-sm font-medium">Kalkulasi Pakan Melahirkan</p>
            <p class="text-2xl font-bold text-emerald-300" id="cost-melahirkan">Rp0</p>
        </div>
        <div class="glass-card p-4">
            <p class="text-gray-300 text-sm font-medium">Kalkulasi Pakan Menyusui</p>
            <p class="text-2xl font-bold text-emerald-300" id="cost-menyusui">Rp0</p>
        </div>
        <div class="glass-card p-4">
            <p class="text-gray-300 text-sm font-medium">Kalkulasi Pakan Prasapih</p>
            <p class="text-2xl font-bold text-emerald-300" id="cost-prasapih">Rp0</p>
        </div>
        <div class="glass-card p-4">
            <p class="text-gray-300 text-sm font-medium">Kalkulasi Pakan Awal (Tim Mas Badrus)</p>
            <p class="text-2xl font-bold text-emerald-300" id="cost-early">Rp0</p>
        </div>
        <div class="glass-card p-4">
            <p class="text-gray-300 text-sm font-medium">Kalkulasi Pakan Sebelum Dikategorikan</p>
            <p class="text-2xl font-bold text-emerald-300" id="cost-uncategorized">Rp0</p>
        </div>
        <div class="glass-card p-4">
            <p class="text-gray-300 text-sm font-medium">Kalkulasi Pakan Kandang Percobaan</p>
            <p class="text-2xl font-bold text-emerald-300" id="cost-percobaan">Rp0</p>
        </div>
        <div class="glass-card p-4">
            <p class="text-gray-300 text-sm font-medium">Kalkulasi Pakan Hibah</p>
            <p class="text-2xl font-bold text-emerald-300" id="cost-hibah">Rp0</p>
        </div>
        <div class="glass-card p-4">
            <p class="text-gray-300 text-sm font-medium">Kalkulasi Pakan Terjual</p>
            <p class="text-2xl font-bold text-emerald-300" id="cost-terjual">Rp0</p>
        </div>
    </div>

    <div class="glass-card p-5">
        <h3 class="text-white font-semibold text-lg mb-3">Jumlah Kalkulasi Pakan Keluar</h3>
        <p class="text-3xl font-bold text-red-300" id="total-out-cost">Rp0</p>
    </div>

    <!-- Grafik Penggunaan Pakan Per Bulan -->
    <div class="glass-card p-5">
        <h3 class="text-white font-semibold text-lg mb-4"><i class="fas fa-chart-line mr-2 text-emerald-400"></i> Penggunaan Pakan Per Bulan (Kg)</h3>
        <canvas id="monthlyUsageChart" class="w-full h-72"></canvas>
    </div>

    <!-- Grafik Penggunaan Pakan Per Jenis -->
    <div class="glass-card p-5">
        <h3 class="text-white font-semibold text-lg mb-4"><i class="fas fa-chart-simple mr-2 text-emerald-400"></i> Penggunaan Pakan Per Jenis (Kg)</h3>
        <canvas id="feedTypeChart" class="w-full h-80"></canvas>
    </div>

    <!-- Tabel Penggunaan Pakan Harian -->
    <div class="glass-card p-5">
        <h3 class="text-white font-semibold text-lg mb-4"><i class="fas fa-table mr-2 text-emerald-400"></i> Penggunaan Pakan Harian</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-white/10 text-sm">
                <thead class="bg-white/5">
                    <tr class="text-gray-200">
                        <th class="px-2 py-1 border-b border-white/10">Tanggal</th>
                        <th class="px-2 py-1 border-b border-white/10">Jenis Pakan</th>
                        <th class="px-2 py-1 border-b border-white/10">Kandang</th>
                        <th class="px-2 py-1 border-b border-white/10">Keluar (Kg)</th>
                    </tr>
                </thead>
                <tbody id="daily-usage-table" class="text-gray-200"></tbody>
            </tr>
        </div>
    </div>

    <!-- Grafik Pengadaan Pakan Per Bulan -->
    <div class="glass-card p-5">
        <h3 class="text-white font-semibold text-lg mb-4"><i class="fas fa-chart-line mr-2 text-emerald-400"></i> Pengadaan Pakan Per Bulan (Kg)</h3>
        <canvas id="monthlyPurchaseChart" class="w-full h-72"></canvas>
    </div>

    <!-- Tabel Realisasi Pengadaan Pakan -->
    <div class="glass-card p-5">
        <h3 class="text-white font-semibold text-lg mb-4"><i class="fas fa-truck mr-2 text-emerald-400"></i> Realisasi Pengadaan Pakan</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-white/10 text-sm">
                <thead class="bg-white/5">
                    <tr class="text-gray-200">
                        <th class="px-2 py-1 border-b border-white/10">Tanggal</th>
                        <th class="px-2 py-1 border-b border-white/10">Supplier</th>
                        <th class="px-2 py-1 border-b border-white/10">Bahan</th>
                        <th class="px-2 py-1 border-b border-white/10">Harga/Qty</th>
                        <th class="px-2 py-1 border-b border-white/10">QTY (sak/kg)</th>
                    </tr>
                </thead>
                <tbody id="purchase-table" class="text-gray-200"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadFeedAnalytics();
});

async function loadFeedAnalytics() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/feeds/analytics');
        if (response.success) {
            const data = response.data;
            // Isi card biaya
            document.getElementById('cost-kawin').innerText = formatRupiah(data.category_costs?.Kawin || 0);
            document.getElementById('cost-fattening').innerText = formatRupiah(data.category_costs?.Fattening || 0);
            document.getElementById('cost-melahirkan').innerText = formatRupiah(data.category_costs?.Melahirkan || 0);
            document.getElementById('cost-menyusui').innerText = formatRupiah(data.category_costs?.Menyusui || 0);
            document.getElementById('cost-prasapih').innerText = formatRupiah(data.category_costs?.Prasapih || 0);
            document.getElementById('cost-early').innerText = formatRupiah(data.early_cost || 0);
            document.getElementById('cost-uncategorized').innerText = formatRupiah(data.uncategorized_cost || 0);
            document.getElementById('cost-percobaan').innerText = formatRupiah(data.percobaan_cost || 0);
            document.getElementById('cost-hibah').innerText = formatRupiah(data.hibah_cost || 0);
            document.getElementById('cost-terjual').innerText = formatRupiah(data.terjual_cost || 0);
            document.getElementById('total-out-cost').innerText = formatRupiah(data.total_out_cost || 0);

            // Grafik bulanan
            if (data.monthly_usage && data.monthly_usage.length) {
                const months = data.monthly_usage.map(item => item.month);
                const kgValues = data.monthly_usage.map(item => item.total_kg);
                new Chart(document.getElementById('monthlyUsageChart'), {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Kg',
                            data: kgValues,
                            backgroundColor: '#10b981'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { labels: { color: '#e2e8f0' } }
                        },
                        scales: {
                            x: { ticks: { color: '#e2e8f0' } },
                            y: { ticks: { color: '#e2e8f0' } }
                        }
                    }
                });
            }

            // Grafik per jenis pakan
            if (data.feed_type_usage && data.feed_type_usage.length) {
                const feedLabels = data.feed_type_usage.map(item => item.feed_name);
                const feedData = data.feed_type_usage.map(item => item.total_kg);
                new Chart(document.getElementById('feedTypeChart'), {
                    type: 'bar',
                    data: {
                        labels: feedLabels,
                        datasets: [{
                            label: 'Kg',
                            data: feedData,
                            backgroundColor: '#3b82f6'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        plugins: {
                            legend: { labels: { color: '#e2e8f0' } }
                        },
                        scales: {
                            x: { ticks: { color: '#e2e8f0' } },
                            y: { ticks: { color: '#e2e8f0' } }
                        }
                    }
                });
            }

            // Tabel penggunaan harian
            const dailyTableBody = document.getElementById('daily-usage-table');
            if (data.daily_usage && data.daily_usage.length) {
                let html = '';
                for (const usage of data.daily_usage) {
                    html += `
                        <tr>
                            <td class="border-b border-white/10 px-2 py-1">${escapeHtml(usage.date)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1">${escapeHtml(usage.feed_name)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1">${escapeHtml(usage.pen_name)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1 text-emerald-300 font-semibold">${usage.quantity_kg}<\/td>
                        </tr>
                    `;
                }
                dailyTableBody.innerHTML = html;
            } else {
                dailyTableBody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-gray-400">Belum ada data<\/td><\/tr>';
            }

            // Grafik pengadaan per bulan
            if (data.monthly_purchase && data.monthly_purchase.length) {
                const purchaseMonths = data.monthly_purchase.map(item => item.month);
                const purchaseKg = data.monthly_purchase.map(item => item.total_kg);
                new Chart(document.getElementById('monthlyPurchaseChart'), {
                    type: 'line',
                    data: {
                        labels: purchaseMonths,
                        datasets: [{
                            label: 'Kg',
                            data: purchaseKg,
                            borderColor: '#f59e0b',
                            fill: false,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { labels: { color: '#e2e8f0' } }
                        },
                        scales: {
                            x: { ticks: { color: '#e2e8f0' } },
                            y: { ticks: { color: '#e2e8f0' } }
                        }
                    }
                });
            }

            // Tabel realisasi pengadaan
            const purchaseTableBody = document.getElementById('purchase-table');
            if (data.purchases && data.purchases.length) {
                let html = '';
                for (const purchase of data.purchases) {
                    html += `
                        <tr>
                            <td class="border-b border-white/10 px-2 py-1">${escapeHtml(purchase.date)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1">${escapeHtml(purchase.supplier)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1">${escapeHtml(purchase.feed_name)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1">${formatRupiah(purchase.price_per_unit)}<\/td>
                            <td class="border-b border-white/10 px-2 py-1">${purchase.quantity} ${purchase.unit}<\/td>
                        </tr>
                    `;
                }
                purchaseTableBody.innerHTML = html;
            } else {
                purchaseTableBody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-gray-400">Belum ada data<\/td><\/tr>';
            }
        } else {
            TernakPark.ui.showToast(response.message || 'Gagal memuat data analitik', 'error');
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    }
}

function formatRupiah(angka) {
    if (angka === undefined || angka === null) return 'Rp 0';
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
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
