@extends('layouts.app')

@section('title', 'Analisis Kandang')
@section('header-title', 'Analisis Kandang')

@section('content')
<div class="space-y-6">
    {{-- Card Utama dengan glassmorphism --}}
    <div class="glass-card p-6">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-chart-line text-emerald-400"></i>
            <h2 class="font-bold text-white text-xl" id="pen-name">Analisis Kandang</h2>
        </div>

        {{-- Statistik dalam grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <div class="bg-white/5 rounded-xl p-4 border border-white/10 hover:border-emerald-400/50 transition">
                <p class="text-gray-300 text-sm">Rata-rata Berat</p>
                <p class="text-3xl font-bold text-emerald-300" id="avg-weight">- kg</p>
            </div>
            <div class="bg-white/5 rounded-xl p-4 border border-white/10 hover:border-emerald-400/50 transition">
                <p class="text-gray-300 text-sm">Total Berat</p>
                <p class="text-3xl font-bold text-emerald-300" id="total-weight">- kg</p>
            </div>
            <div class="bg-white/5 rounded-xl p-4 border border-white/10 hover:border-emerald-400/50 transition">
                <p class="text-gray-300 text-sm">Kebutuhan Pakan Harian</p>
                <p class="text-3xl font-bold text-emerald-300" id="feed-daily">- kg</p>
            </div>
        </div>

        {{-- Grafik --}}
        <div class="mt-4">
            <canvas id="penChart" height="280" class="w-full"></canvas>
        </div>

        {{-- Tombol kembali --}}
        <div class="mt-6 flex justify-end">
            <a href="{{ route('pens.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl transition border border-white/20">
                <i class="fas fa-arrow-left text-sm"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async function() {
    const id = '{{ $penId ?? $data["pen"]["id"] ?? 0 }}';
    if (!id || id === '0') {
        document.getElementById('pen-name').innerText = 'ID Kandang tidak valid';
        TernakPark.ui.showToast('ID kandang tidak ditemukan', 'error');
        return;
    }
    try {
        const res = await TernakPark.api.fetchData(`/web-api/pens/${id}/analytics`);
        if (res.success) {
            renderAnalytics(res.data);
        } else {
            TernakPark.ui.showToast(res.message || 'Gagal memuat data', 'error');
        }
    } catch (e) {
        console.error(e);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
});

function renderAnalytics(data) {
    const penName = data.pen?.name || 'Kandang';
    document.getElementById('pen-name').innerHTML = `<i class="fas fa-warehouse mr-2 text-emerald-400"></i> Analisis ${escapeHtml(penName)}`;

    const avgWeight = data.livestock_stats?.average_weight || 0;
    const totalWeight = data.livestock_stats?.total_weight || 0;
    document.getElementById('avg-weight').innerText = avgWeight.toFixed(2) + ' kg';
    document.getElementById('total-weight').innerText = totalWeight.toFixed(2) + ' kg';

    const feedDaily = data.feed_requirements?.daily_kg || 0;
    document.getElementById('feed-daily').innerText = feedDaily.toFixed(2) + ' kg';

    const maleCount = data.livestock_stats?.by_gender?.male || 0;
    const femaleCount = data.livestock_stats?.by_gender?.female || 0;

    const ctx = document.getElementById('penChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jantan', 'Betina'],
            datasets: [{
                label: 'Jumlah Ternak',
                data: [maleCount, femaleCount],
                backgroundColor: ['#10b981', '#f59e0b'],
                borderRadius: 8,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#cbd5e1' },
                    grid: { color: 'rgba(255,255,255,0.05)' }
                },
                x: {
                    ticks: { color: '#e2e8f0' },
                    grid: { display: false }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { color: '#e2e8f0', font: { weight: 'bold' } }
                },
                tooltip: {
                    callbacks: { label: (ctx) => `${ctx.raw} ekor` },
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#a7f3d0'
                }
            }
        }
    });
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
