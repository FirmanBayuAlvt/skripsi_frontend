@extends('layouts.app')

@section('title', 'Manajemen Pakan')
@section('header-title', 'Manajemen Pakan')

@section('page-header')
<div class="flex flex-wrap justify-between items-center gap-3">
    <div class="flex items-center gap-2">
        <div class="h-8 w-1 bg-gradient-to-b from-emerald-300 to-teal-500 rounded-full"></div>
        <p class="text-emerald-200 font-medium tracking-wide">MANAJEMEN PAKAN</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('feeds.usage') }}" class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white px-4 py-2 rounded-xl flex items-center shadow-md transition-all transform hover:scale-[1.02]">
            <i class="fas fa-chart-line mr-2"></i> Penggunaan Pakan
        </a>
        <a href="{{ route('feeds.procurement') }}" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-4 py-2 rounded-xl flex items-center shadow-md transition-all transform hover:scale-[1.02]">
            <i class="fas fa-truck mr-2"></i> Pengadaan Pakan
        </a>
        <a href="{{ route('feeds.requirements') }}" class="bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white px-4 py-2 rounded-xl flex items-center shadow-md transition-all transform hover:scale-[1.02]">
            <i class="fas fa-calculator mr-2"></i> Kebutuhan Pakan
        </a>
        <a href="{{ route('feeds.stock') }}" class="bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white px-4 py-2 rounded-xl flex items-center shadow-md transition-all transform hover:scale-[1.02]">
            <i class="fas fa-boxes mr-2"></i> Stok Pakan
        </a>
        <button onclick="openAddFeedModal()" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl flex items-center shadow-md transition-all transform hover:scale-[1.02]">
            <i class="fas fa-plus mr-2"></i> Tambah Pakan
        </button>
        <button onclick="openImportFeedModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-xl flex items-center shadow-md transition-all transform hover:scale-[1.02]">
            <i class="fas fa-file-excel mr-2"></i> Impor Excel
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Tombol Kembali ke Dashboard -->
    <div class="flex justify-end">
        <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Stat Cards dengan glassmorphism -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card p-5">
            <div class="flex items-center">
                <div class="p-3 bg-emerald-500/20 rounded-2xl text-emerald-300"><i class="fas fa-seedling text-xl"></i></div>
                <div class="ml-4">
                    <p class="text-gray-300 text-sm font-medium">Jenis Pakan</p>
                    <p class="stat-value" id="total-feed-types">-</p>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex items-center">
                <div class="p-3 bg-emerald-500/20 rounded-2xl text-emerald-300"><i class="fas fa-warehouse text-xl"></i></div>
                <div class="ml-4">
                    <p class="text-gray-300 text-sm font-medium">Total Stok (kg)</p>
                    <p class="stat-value" id="total-stock">-</p>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-500/20 rounded-2xl text-yellow-300"><i class="fas fa-exclamation-triangle text-xl"></i></div>
                <div class="ml-4">
                    <p class="text-gray-300 text-sm font-medium">Stok Rendah</p>
                    <p class="stat-value" id="low-stock">-</p>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex items-center">
                <div class="p-3 bg-blue-500/20 rounded-2xl text-blue-300"><i class="fas fa-money-bill-wave text-xl"></i></div>
                <div class="ml-4">
                    <p class="text-gray-300 text-sm font-medium">Nilai Stok</p>
                    <p class="stat-value" id="stock-value">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pakan per Kategori Kandang -->
    <div class="space-y-6">
        <h2 class="text-white text-xl font-bold">Pakan Berdasarkan Kategori Kandang</h2>
        <div id="pen-categories" class="grid grid-cols-1 lg:grid-cols-2 gap-6"></div>

        <!-- Grafik Kebutuhan Pakan per Kategori -->
        <div class="glass-card p-6">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
                <i class="fas fa-chart-bar mr-2 text-emerald-400"></i>
                <h3 class="font-bold text-white text-lg">Grafik Kebutuhan Pakan per Kategori Kandang</h3>
            </div>
            <canvas id="categoryFeedChart" class="w-full h-72"></canvas>
        </div>
    </div>
</div>

<!-- Modal Tambah Pakan -->
<div id="add-feed-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="bg-black/40 backdrop-blur-md rounded-2xl p-6 max-w-md w-full z-10 shadow-2xl border border-white/20">
            <h3 class="text-white text-xl font-bold mb-5">Tambah Pakan Baru</h3>
            <form id="add-feed-form" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Nama Pakan</label>
                    <input type="text" name="name" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Kategori</label>
                    <select name="category" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="silase">Silase</option>
                        <option value="cf_jember">CF Jember</option>
                        <option value="jagung_halus">Jagung Halus</option>
                        <option value="konsentrat">Konsentrat</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Stok Awal (kg)</label>
                    <input type="number" step="0.01" name="current_stock" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Harga per kg</label>
                    <input type="number" step="0.01" name="price_per_kg" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Satuan</label>
                    <input type="text" name="unit" value="kg" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Status</label>
                    <select name="is_active" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeAddFeedModal()" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl transition">Batal</button>
                    <button type="button" onclick="submitAddFeedForm()" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white rounded-xl shadow-md transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Impor Excel Pakan -->
<div id="import-feed-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="bg-black/40 backdrop-blur-md rounded-2xl p-6 max-w-lg w-full z-10 shadow-2xl border border-white/20">
            <h3 class="text-white text-xl font-bold mb-5">Impor Data Pakan dari Excel</h3>
            <form id="import-feed-form" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-200 text-sm font-medium mb-2">Pilih file Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="block w-full bg-white/10 border border-white/20 rounded-xl p-2 text-white focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="mb-4">
                    <p class="text-gray-300 text-sm">Format kolom: <code class="text-emerald-300">nama, kategori, stok_awal, harga_per_kg, satuan, aktif</code>. Baris pertama harus header.</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeImportFeedModal()" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white rounded-xl shadow-md transition">Impor</button>
                </div>
            </form>
            <div id="import-feed-progress" class="hidden mt-4 text-center">
                <div class="loading-spinner mx-auto"></div>
                <p class="text-white/70 text-sm mt-2">Memproses...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadFeedsData();
});

async function loadFeedsData() {
    try {
        const [feedsResponse, requirementsResponse] = await Promise.all([
            TernakPark.api.fetchData('/web-api/feeds/data'),
            TernakPark.api.fetchData('/web-api/feeds/requirements')
        ]);

        if (feedsResponse.success && requirementsResponse.success) {
            updateFeedsStatistics(feedsResponse.data);
            renderFeedsByCategory(feedsResponse.data.feed_types, requirementsResponse.data.pen_category_feeds);
            if (requirementsResponse.data.pen_categories) {
                initializeCategoryFeedChart(requirementsResponse.data.pen_categories);
            }
        } else {
            const errorMessage = feedsResponse.message || requirementsResponse.message || 'Gagal memuat data';
            showErrorMessage(errorMessage);
        }
    } catch (error) {
        console.error('Error loading feeds data:', error);
        document.getElementById('pen-categories').innerHTML = '<div class="text-center text-red-400">Koneksi error</div>';
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    }
}

function renderFeedsByCategory(feeds, penCategoryFeeds) {
    const container = document.getElementById('pen-categories');
    if (!penCategoryFeeds) {
        container.innerHTML = '<div class="text-center text-gray-400">Data kategori kandang belum tersedia</div>';
        return;
    }

    const categories = Object.keys(penCategoryFeeds);
    if (categories.length === 0) {
        container.innerHTML = '<div class="text-center text-gray-400">Belum ada kategori kandang</div>';
        return;
    }

    let html = '';
    for (const category of categories) {
        const categoryFeedNames = penCategoryFeeds[category] || [];
        const relevantFeeds = feeds.filter(feed => categoryFeedNames.includes(feed.name));
        html += `
            <div class="bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 shadow-md p-6 hover:border-emerald-400/50 transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-semibold text-lg">${escapeHtml(category)}</h3>
                    <span class="px-3 py-1 bg-blue-500/20 text-blue-200 rounded-full text-xs">${relevantFeeds.length} jenis pakan</span>
                </div>
                <div class="space-y-3">
        `;
        if (relevantFeeds.length > 0) {
            for (const feed of relevantFeeds) {
                const isStockLow = feed.is_stock_low;
                const stockStatusClass = isStockLow ? 'bg-red-500/30 text-red-200' : 'bg-green-500/30 text-green-200';
                const stockStatusText = isStockLow ? 'Stok Rendah' : 'Aman';
                html += `
                    <div class="flex items-center justify-between p-3 bg-black/20 rounded-xl">
                        <div>
                            <p class="font-medium text-white">${escapeHtml(feed.name)}</p>
                            <p class="text-sm text-gray-300">Stok: ${feed.current_stock} kg</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-white">${TernakPark.format.currency(feed.price_per_kg)}</p>
                            <span class="px-2 py-1 rounded-full text-xs ${stockStatusClass}">${stockStatusText}</span>
                        </div>
                    </div>
                `;
            }
        } else {
            html += '<p class="text-gray-400 text-center py-4">Belum ada data pakan untuk kategori ini</p>';
        }
        html += `
                </div>
            </div>
        `;
    }
    container.innerHTML = html;
}

function updateFeedsStatistics(data) {
    document.getElementById('total-feed-types').innerText = data.total_types || 0;
    document.getElementById('total-stock').innerText = data.stock_summary?.total_stock_kg || 0;
    document.getElementById('low-stock').innerText = data.low_stock_count || 0;
    document.getElementById('stock-value').innerText = TernakPark.format.currency(data.stock_summary?.total_value || 0);
}

function openAddFeedModal() {
    document.getElementById('add-feed-modal').classList.remove('hidden');
}

function closeAddFeedModal() {
    document.getElementById('add-feed-modal').classList.add('hidden');
    document.getElementById('add-feed-form').reset();
}

async function submitAddFeedForm() {
    const form = document.getElementById('add-feed-form');
    const formData = Object.fromEntries(new FormData(form));
    formData.is_active = formData.is_active === '1';

    const submitButton = form.querySelector('button[type="button"]:last-child');
    const originalButtonText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = 'Menyimpan...';

    try {
        const response = await fetch('/web-api/feeds/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });
        const result = await response.json();
        if (result.success) {
            closeAddFeedModal();
            await loadFeedsData();
            TernakPark.ui.showToast('Pakan berhasil ditambahkan', 'success');
        } else {
            TernakPark.ui.showToast(result.message || 'Gagal menambahkan pakan', 'error');
        }
    } catch (error) {
        console.error('Error adding feed:', error);
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
    }
}

function openImportFeedModal() {
    document.getElementById('import-feed-modal').classList.remove('hidden');
}

function closeImportFeedModal() {
    document.getElementById('import-feed-modal').classList.add('hidden');
    document.getElementById('import-feed-form').reset();
    document.getElementById('import-feed-progress').classList.add('hidden');
}

document.getElementById('import-feed-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    submitButton.disabled = true;
    document.getElementById('import-feed-progress').classList.remove('hidden');

    try {
        const response = await fetch('/web-api/feeds/import', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });
        const result = await response.json();
        if (result.success) {
            TernakPark.ui.showToast('Data pakan berhasil diimpor: ' + (result.imported || 0) + ' record', 'success');
            closeImportFeedModal();
            await loadFeedsData();
        } else {
            TernakPark.ui.showToast(result.message || 'Gagal mengimpor data', 'error');
        }
    } catch (error) {
        console.error('Error importing feeds:', error);
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
        document.getElementById('import-feed-progress').classList.add('hidden');
    }
});

function initializeCategoryFeedChart(penCategories) {
    const canvas = document.getElementById('categoryFeedChart');
    if (!canvas) return;

    const labels = [];
    const dataValues = [];
    for (const category of penCategories) {
        labels.push(category.category);
        dataValues.push(Number(category.daily_ration_kg));
    }

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Kebutuhan Harian (kg)',
                data: dataValues,
                backgroundColor: '#10b981',
                borderRadius: 8,
                barPercentage: 0.7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: { color: '#e2e8f0' },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: '#e2e8f0' },
                    grid: { color: 'rgba(255,255,255,0.05)' }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#a7f3d0',
                    bodyColor: '#cbd5e1'
                }
            }
        }
    });
}

function showErrorMessage(message) {
    TernakPark.ui.showToast(message, 'error');
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
