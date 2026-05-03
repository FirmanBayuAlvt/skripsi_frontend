@extends('layouts.app')

@section('title', 'Detail Kandang')
@section('header-title', 'Detail Kandang')

@section('content')
<div class="space-y-6">
    <div class="glass-card p-6">
        <div class="flex justify-between items-start mb-6">
            <div class="flex items-center gap-2">
                <i class="fas fa-warehouse text-emerald-400 text-2xl"></i>
                <h2 class="text-2xl font-bold text-white" id="pen-name">-</h2>
            </div>
            <span id="status-badge" class="px-3 py-1 rounded-full text-sm font-medium"></span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <dl class="space-y-3">
                    <div class="flex border-b border-white/10 pb-2"><dt class="w-1/3 text-gray-400">Kode</dt><dd class="w-2/3 font-medium text-white" id="code">-</dd></div>
                    <div class="flex border-b border-white/10 pb-2"><dt class="w-1/3 text-gray-400">Kategori</dt><dd class="w-2/3 font-medium text-white" id="category">-</dd></div>
                    <div class="flex border-b border-white/10 pb-2"><dt class="w-1/3 text-gray-400">Kapasitas</dt><dd class="w-2/3 font-medium text-white" id="capacity">-</dd></div>
                    <div class="flex"><dt class="w-1/3 text-gray-400">Jumlah Ternak</dt><dd class="w-2/3 font-medium text-white" id="occupancy">-</dd></div>
                </dl>
            </div>
            <div>
                <h3 class="font-semibold text-white mb-3 flex items-center gap-2"><i class="fas fa-paw text-emerald-400"></i> Daftar Ternak di Kandang Ini</h3>
                <div id="livestock-list" class="space-y-2 max-h-80 overflow-y-auto pr-2">
                    <div class="text-gray-400">Memuat...</div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-white mb-3 flex items-center gap-2"><i class="fas fa-seedling text-emerald-400"></i> Pakan yang Digunakan</h3>
            <div id="feed-list" class="flex flex-wrap gap-2">
                <div class="text-gray-400">Memuat...</div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('pens.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl transition border border-white/20">
                <i class="fas fa-arrow-left text-sm"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', async function() {
    const id = '{{ $penId ?? $pen["id"] ?? 0 }}';
    if (!id || id === '0') {
        document.getElementById('pen-name').innerText = 'ID Kandang tidak valid';
        TernakPark.ui.showToast('ID kandang tidak ditemukan', 'error');
        return;
    }
    try {
        const res = await TernakPark.api.fetchData(`/web-api/pens/${id}/detail`);
        if (res.success) {
            renderDetail(res.data);
        } else {
            TernakPark.ui.showToast(res.message || 'Gagal memuat detail kandang', 'error');
        }
    } catch (e) {
        console.error(e);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
});

function renderDetail(data) {
    document.getElementById('pen-name').innerHTML = `<i class="fas fa-warehouse mr-2 text-emerald-400"></i> ${escapeHtml(data.name || '-')}`;
    document.getElementById('code').innerText = data.code || '-';
    document.getElementById('category').innerText = data.category || '-';
    document.getElementById('capacity').innerText = data.capacity || 0;
    const occupancy = data.current_occupancy ?? 0;
    const capacity = data.capacity ?? 0;
    document.getElementById('occupancy').innerText = `${occupancy} / ${capacity}`;

    const badge = document.getElementById('status-badge');
    if (data.status === 'active') {
        badge.innerText = 'Aktif';
        badge.className = 'px-3 py-1 rounded-full text-sm font-medium bg-emerald-500/20 text-emerald-200';
    } else {
        badge.innerText = 'Nonaktif';
        badge.className = 'px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-200';
    }

    const livestockContainer = document.getElementById('livestock-list');
    const livestocks = data.livestocks || [];
    if (livestocks.length === 0) {
        livestockContainer.innerHTML = '<div class="text-gray-400">Tidak ada ternak di kandang ini</div>';
    } else {
        let html = '';
        for (let i = 0; i < livestocks.length; i++) {
            const l = livestocks[i];
            html += `
                <div class="flex justify-between items-center p-3 border border-white/10 rounded-xl bg-white/5">
                    <span class="font-medium text-white">${escapeHtml(l.ear_tag)}</span>
                    <span class="text-emerald-300">${l.current_weight ?? '-'} kg</span>
                </div>
            `;
        }
        livestockContainer.innerHTML = html;
    }

    const feedList = document.getElementById('feed-list');
    const category = data.category;
    const feeds = getFeedsForCategory(category);
    if (feeds.length === 0) {
        feedList.innerHTML = '<div class="text-gray-400">Tidak ada rekomendasi pakan untuk kategori ini</div>';
    } else {
        let feedHtml = '';
        for (let i = 0; i < feeds.length; i++) {
            feedHtml += `<span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-200 text-sm">${escapeHtml(feeds[i])}</span>`;
        }
        feedList.innerHTML = feedHtml;
    }
}

function getFeedsForCategory(category) {
    const feedMap = {
        'Fattening': ['Silase', 'Complete Feed Kediri', 'Complete Feed Jember', 'Ampas Tahu', 'Complete Feed Madiun', 'Onggok', 'Jagung', 'LAK 105', 'Nutrifeed'],
        'Fattening Percobaan': ['Silase', 'Complete Feed Jember', 'Jagung', 'LAK 105', 'Pakchong'],
        'Kawin': ['Silase', 'Complete Feed Jember', 'Pakchong', 'Jagung', 'Complete Feed Madiun', 'LAK 105', 'Nutrifeed'],
        'Melahirkan': ['Silase', 'Jagung', 'Complete Feed Jember', 'Complete Feed Madiun', 'LAK 105', 'Pakchong', 'Nutrifeed', 'Crepfeed'],
        'Menyusui': ['Silase', 'Complete Feed Jember', 'Jagung', 'Complete Feed Madiun', 'Pakchong', 'Nutrifeed', 'LAK 105', 'Crepfeed'],
        'Prasapih': ['Silase', 'Complete Feed Jember', 'Jagung', 'Complete Feed Madiun', 'Pakchong', 'Crepfeed', 'LAK 105', 'Nutrifeed'],
        'Kambing': ['Silase', 'Complete Feed Madiun', 'Complete Feed Jember', 'Gembilina', 'Pakchong', 'Nutrifeed', 'LAK 105', 'Pongkol Ketela', 'Jagung', 'Ramban']
    };
    return feedMap[category] || [];
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
