<?php $__env->startSection('title', 'Kebutuhan Pakan'); ?>
<?php $__env->startSection('header-title', 'Kebutuhan Pakan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Tombol Kembali ke Manajemen Pakan -->
    <div class="flex justify-end">
        <a href="<?php echo e(route('feeds.index')); ?>" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Pakan
        </a>
    </div>

    <div class="glass-card p-6">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-calculator text-emerald-400 text-xl"></i>
            <h2 class="font-bold text-white text-xl">Kebutuhan Pakan Harian</h2>
        </div>
        <div id="requirements" class="space-y-6">
            <div class="text-center text-gray-300">Memuat...</div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', loadRequirements);

async function loadRequirements() {
    try {
        const response = await TernakPark.api.fetchData('/web-api/feeds/requirements');
        if (response.success && response.data) {
            renderRequirements(response.data);
        } else {
            const errorMessage = response.message || 'Gagal memuat data pakan';
            document.getElementById('requirements').innerHTML = `<div class="text-center text-red-300">${escapeHtml(errorMessage)}</div>`;
            TernakPark.ui.showToast(errorMessage, 'error');
        }
    } catch (error) {
        console.error(error);
        document.getElementById('requirements').innerHTML = '<div class="text-center text-red-300">Gagal memuat data pakan</div>';
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    }
}

function renderRequirements(data) {
    const requirements = data.requirements || {
        daily: { total_kg: 0, cost: 0, composition: { silase: 0, cf_jember: 0, jagung_halus: 0 } },
        weekly: { total_kg: 0, cost: 0 },
        monthly: { total_kg: 0, cost: 0 }
    };
    requirements.daily.composition = requirements.daily.composition || { silase: 0, cf_jember: 0, jagung_halus: 0 };

    const penCategories = Array.isArray(data.pen_categories) ? data.pen_categories : [];
    const fallbackCategoryFeeds = data.pen_category_feeds || {};
    const usageByFeed = Array.isArray(data.usage_by_feed) ? data.usage_by_feed : [];
    const recentUsage = Array.isArray(data.recent_usage) ? data.recent_usage : [];

    // Prepare categories to render
    const categoriesToRender = penCategories.length
        ? penCategories
        : Object.entries(fallbackCategoryFeeds).map(([category, feeds]) => ({
            category: category,
            animal_count: 0,
            daily_ration_kg: 0,
            ration_per_animal_kg: 0,
            feeds: feeds,
        }));

    // Build category cards HTML
    let categoryHtml = '';
    for (const categoryItem of categoriesToRender) {
        const feedList = categoryItem.feeds || [];
        categoryHtml += `
            <div class="bg-white/5 border border-white/10 rounded-xl p-4 shadow-md hover:border-emerald-400/50 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-white">${escapeHtml(categoryItem.category)}</h4>
                        <p class="text-gray-300 text-sm">Jumlah hewan dan ransum</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-emerald-500/20 text-emerald-200">${feedList.length} jenis</span>
                </div>
                <div class="mt-4 grid grid-cols-1 gap-2 text-sm text-gray-200">
                    <div class="flex justify-between"><span>Jumlah Hewan</span><strong class="text-white">${categoryItem.animal_count ?? 0}</strong></div>
                    <div class="flex justify-between"><span>Ransum pakan/kg</span><strong class="text-white">${categoryItem.daily_ration_kg ?? 0} kg</strong></div>
                    <div class="flex justify-between"><span>Ransum/ekor</span><strong class="text-white">${categoryItem.ration_per_animal_kg ?? 0} kg</strong></div>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
        `;
        for (const feedName of feedList) {
            categoryHtml += `<span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-700/50 text-gray-200 text-xs">${escapeHtml(feedName)}</span>`;
        }
        categoryHtml += `
                </div>
            </div>
        `;
    }

    // Build recent usage table rows
    let recentHtml = '';
    if (recentUsage.length) {
        for (const record of recentUsage) {
            recentHtml += `
                <tr class="border-b border-white/10 hover:bg-white/5">
                    <td class="px-3 py-2 text-gray-200">${escapeHtml(record.date || '-')}</td>
                    <td class="px-3 py-2 text-gray-200">${escapeHtml(record.feed || '-')}</td>
                    <td class="px-3 py-2 text-gray-200">${escapeHtml(record.pen || '-')}</td>
                    <td class="px-3 py-2 text-gray-200">${record.quantity_kg ?? '-'}</td>
                    <td class="px-3 py-2 text-gray-200">${escapeHtml(record.notes || '-')}</td>
                </tr>
            `;
        }
    } else {
        recentHtml = '<tr><td colspan="5" class="px-3 py-4 text-center text-gray-400">Belum ada data penggunaan</td></tr>';
    }

    const html = `
        <!-- Ringkasan kebutuhan harian, mingguan, bulanan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white/5 border border-white/10 rounded-xl p-4 shadow-md">
                <p class="text-gray-300 text-sm">Harian</p>
                <p class="text-3xl font-bold text-emerald-300">${requirements.daily.total_kg} kg</p>
                <p class="text-gray-300 text-sm">Biaya: ${TernakPark.format.currency(requirements.daily.cost)}</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-4 shadow-md">
                <p class="text-gray-300 text-sm">Mingguan</p>
                <p class="text-3xl font-bold text-emerald-300">${requirements.weekly.total_kg} kg</p>
                <p class="text-gray-300 text-sm">Biaya: ${TernakPark.format.currency(requirements.weekly.cost)}</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-4 shadow-md">
                <p class="text-gray-300 text-sm">Bulanan</p>
                <p class="text-3xl font-bold text-emerald-300">${requirements.monthly.total_kg} kg</p>
                <p class="text-gray-300 text-sm">Biaya: ${TernakPark.format.currency(requirements.monthly.cost)}</p>
            </div>
        </div>

        <!-- Komposisi Harian -->
        <h3 class="text-white font-semibold text-lg mt-8">Komposisi Harian</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
            <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                <p class="font-medium text-gray-200">Silase</p>
                <p class="text-emerald-300 font-semibold">${requirements.daily.composition.silase} kg</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                <p class="font-medium text-gray-200">Complete Feed Jember</p>
                <p class="text-emerald-300 font-semibold">${requirements.daily.composition.cf_jember} kg</p>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                <p class="font-medium text-gray-200">Jagung Halus</p>
                <p class="text-emerald-300 font-semibold">${requirements.daily.composition.jagung_halus} kg</p>
            </div>
        </div>

        <!-- Pembagian Pakan per Kategori Kandang -->
        <h3 class="text-white font-semibold text-lg mt-8">Pembagian Pakan per Kategori Kandang</h3>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mt-4">
            <div class="bg-white/5 border border-white/10 rounded-xl p-4 shadow-md">
                <h4 class="font-semibold text-gray-200 mb-4">Kebutuhan Pakan per Kategori</h4>
                <canvas id="categoryFeedChart" class="w-full h-72"></canvas>
            </div>
            <div class="grid grid-cols-1 gap-4">
                ${categoryHtml}
            </div>
        </div>

        <!-- Penggunaan Pakan Per Jenis & Tabel Harian -->
        <div class="mt-8 grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-white/5 border border-white/10 rounded-xl p-4 shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="font-semibold text-gray-200">Penggunaan Pakan Per Jenis</h4>
                        <p class="text-sm text-gray-400">Total 30 hari terakhir</p>
                    </div>
                </div>
                <div id="feedUsageChartContainer" class="w-full h-72">
                    <canvas id="feedUsageChart" class="w-full h-full"></canvas>
                </div>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-4 shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="font-semibold text-gray-200">Penggunaan Pakan Harian</h4>
                        <p class="text-sm text-gray-400">Catatan pemakaian terbaru</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-gray-200">
                        <thead class="bg-white/10">
                            <tr>
                                <th class="px-3 py-2 border-b border-white/10">Tanggal</th>
                                <th class="px-3 py-2 border-b border-white/10">Jenis Pakan</th>
                                <th class="px-3 py-2 border-b border-white/10">Kandang</th>
                                <th class="px-3 py-2 border-b border-white/10">Keluar (kg)</th>
                                <th class="px-3 py-2 border-b border-white/10">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${recentHtml}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;

    document.getElementById('requirements').innerHTML = html;

    // Inisialisasi grafik jika data tersedia
    if (usageByFeed.length) {
        initFeedUsageChart(usageByFeed);
    } else {
        const chartContainer = document.getElementById('feedUsageChartContainer');
        if (chartContainer) {
            chartContainer.innerHTML = '<div class="text-center text-gray-400 py-10">Data penggunaan pakan per jenis belum tersedia.</div>';
        }
    }

    if (penCategories.length) {
        initCategoryFeedChart(penCategories);
    }
}

function initCategoryFeedChart(penCategories) {
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
                legend: { labels: { color: '#e2e8f0' } }
            }
        }
    });
}

function initFeedUsageChart(usageByFeed) {
    const canvas = document.getElementById('feedUsageChart');
    if (!canvas) return;

    const labels = usageByFeed.map(item => item.feed_name);
    const data = usageByFeed.map(item => item.total_kg);

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Pemakaian (kg)',
                data: data,
                backgroundColor: '#3b82f6',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    ticks: { color: '#e2e8f0' },
                    grid: { color: 'rgba(255,255,255,0.05)' }
                },
                y: {
                    ticks: { color: '#e2e8f0' },
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { labels: { color: '#e2e8f0' } }
            }
        }
    });
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/feeds/requirements.blade.php ENDPATH**/ ?>