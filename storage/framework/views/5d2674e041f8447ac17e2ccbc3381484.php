<?php $__env->startSection('title', 'Fattening Domba'); ?>
<?php $__env->startSection('header-title', 'Program Fattening Domba'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="flex flex-wrap gap-3 justify-end">
        <button id="btnDetailPerTernak" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-xl flex items-center gap-2 shadow-md transition transform hover:scale-105">
            <i class="fas fa-info-circle"></i> Detail per Ternak
        </button>
        <button id="btnDataTimbang" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-5 py-2.5 rounded-xl flex items-center gap-2 shadow-md transition transform hover:scale-105">
            <i class="fas fa-weight-scale"></i> Data Timbang
        </button>
        <button id="btnAdgFcr" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-5 py-2.5 rounded-xl flex items-center gap-2 shadow-md transition transform hover:scale-105">
            <i class="fas fa-chart-line"></i> ADG & FCR
        </button>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">QTY Ternak Fattening</p>
                    <p class="stat-value" id="total-fattening">-</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-weight-hanging text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Total BB Terbaru (kg)</p>
                    <p class="stat-value" id="total-weight">-</p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-2xl">
                    <i class="fas fa-weight-scale text-blue-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">AVG ADG Terbaru (kg/hari)</p>
                    <p class="stat-value" id="avg-adg">-</p>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-2xl">
                    <i class="fas fa-chart-line text-purple-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Qty Ternak Jantan</p>
                    <p class="stat-value" id="male-count">-</p>
                </div>
                <div class="bg-amber-500/20 p-3 rounded-2xl">
                    <i class="fas fa-mars text-amber-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">Qty Ternak Betina</p>
                    <p class="stat-value" id="female-count">-</p>
                </div>
                <div class="bg-pink-500/20 p-3 rounded-2xl">
                    <i class="fas fa-venus text-pink-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">ADG > 0.1</p>
                    <p class="stat-value text-emerald-300" id="adg-high">-</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-2xl">
                    <i class="fas fa-arrow-up text-emerald-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">ADG 0 - 0.1</p>
                    <p class="stat-value text-yellow-300" id="adg-medium">-</p>
                </div>
                <div class="bg-yellow-500/20 p-3 rounded-2xl">
                    <i class="fas fa-minus text-yellow-300 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="stat-card p-5">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-300 text-sm">ADG < 0</p>
                    <p class="stat-value text-red-300" id="adg-low">-</p>
                </div>
                <div class="bg-red-500/20 p-3 rounded-2xl">
                    <i class="fas fa-arrow-down text-red-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-mars text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Fattening Ternak Jantan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Jenis Domba</th>
                        <th class="px-3 py-2">Day On Farm</th>
                        <th class="px-3 py-2">Sub Kategori</th>
                        <th class="px-3 py-2">BB Terbaru (kg)</th>
                        <th class="px-3 py-2">ADG Terbaru (kg/hari)</th>
                    </tr>
                </thead>
                <tbody id="male-table-body">
                    <tr><td colspan="6" class="text-center py-6 text-gray-400">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-venus text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Fattening Ternak Betina</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Jenis Domba</th>
                        <th class="px-3 py-2">Day On Farm</th>
                        <th class="px-3 py-2">Sub Kategori</th>
                        <th class="px-3 py-2">BB Terbaru (kg)</th>
                        <th class="px-3 py-2">ADG Terbaru (kg/hari)</th>
                    </tr>
                </thead>
                <tbody id="female-table-body">
                    <tr><td colspan="6" class="text-center py-6 text-gray-400">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-arrow-down text-red-400"></i>
            <h3 class="font-bold text-white text-lg">Data Fattening ADG &lt; 0</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Day On Farm</th>
                        <th class="px-3 py-2">Kandang</th>
                        <th class="px-3 py-2">BB Terbaru (kg)</th>
                        <th class="px-3 py-2">ADG Terbaru (kg/hari)</th>
                    </tr>
                </thead>
                <tbody id="adg-negative-body">
                    <tr><td colspan="5" class="text-center py-6 text-gray-400">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-minus text-yellow-400"></i>
            <h3 class="font-bold text-white text-lg">Data Fattening ADG 0 - 0.1</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Umur (hari)</th>
                        <th class="px-3 py-2">Kandang</th>
                        <th class="px-3 py-2">BB Terbaru (kg)</th>
                        <th class="px-3 py-2">ADG Terbaru (kg/hari)</th>
                    </tr>
                </thead>
                <tbody id="adg-zero-to-point-one-body">
                    <tr><td colspan="5" class="text-center py-6 text-gray-400">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-arrow-up text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Data Fattening ADG &gt; 0.1</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-3 py-2">Tagging</th>
                        <th class="px-3 py-2">Umur (hari)</th>
                        <th class="px-3 py-2">Kandang</th>
                        <th class="px-3 py-2">BB Terbaru (kg)</th>
                        <th class="px-3 py-2">ADG Terbaru (kg/hari)</th>
                    </tr>
                </thead>
                <tbody id="adg-above-point-one-body">
                    <tr><td colspan="5" class="text-center py-6 text-gray-400">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="modalDetailTernak" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity"></div>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-black/40 backdrop-blur-md rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full border border-white/20">
            <div class="px-6 pt-6 pb-4 sm:px-8 sm:pt-8">
                <div class="flex justify-between items-center border-b border-white/10 pb-3 mb-4">
                    <h3 class="text-xl font-bold text-white">📋 Detail Per Ternak</h3>
                    <button class="close-modal text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-300 text-sm mb-1">Pilih Ear Tag</label>
                        <select id="tagSelectDetail" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white">
                            <option value="">-- Pilih Ternak --</option>
                        </select>
                    </div>
                    <div></div>
                </div>
                <div id="detailInfo" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3 text-sm bg-white/5 rounded-xl p-4 border border-white/10">
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
                            <thead class="bg-white/5">
                                <tr class="text-gray-300">
                                    <th class="px-3 py-2">Tagging</th>
                                    <th>BB IN (kg)</th>
                                    <th>BB 4 bln lalu</th>
                                    <th>BB 3 bln lalu</th>
                                    <th>BB 2 bln lalu</th>
                                    <th>BB Bulan Lalu</th>
                                    <th>BB Terbaru</th>
                                </tr>
                            </thead>
                            <tbody id="tabelTimbangDetail"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-white/5 sm:flex sm:flex-row-reverse sm:px-8">
                <button type="button" class="close-modal px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl">Tutup</button>
            </div>
        </div>
    </div>
</div>


<div id="modalDataTimbang" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-black/40 backdrop-blur-md rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full border border-white/20">
            <div class="px-6 pt-6 pb-4 sm:px-8 sm:pt-8">
                <div class="flex justify-between items-center border-b border-white/10 pb-3 mb-4">
                    <h3 class="text-xl font-bold text-white">⚖️ Data Timbang</h3>
                    <button class="close-modal text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div><label class="text-gray-300 text-sm">Tagging</label><select id="filterTagging" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"><option value="">Semua</option></select></div>
                    <div><label class="text-gray-300 text-sm">Jenis Domba</label><select id="filterJenis" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"><option value="">Semua</option></select></div>
                    <div><label class="text-gray-300 text-sm">Kategori Kandang</label><select id="filterKategori" class="w-full bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"><option value="">Semua</option></select></div>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white/5 rounded-xl p-4">
                        <p class="text-gray-300">🐏 Qty ternak dengan ADG minus 2x berturut-turut</p>
                        <p class="text-3xl font-bold text-red-300" id="qtyMinus2x">0</p>
                        <div class="mt-3 overflow-x-auto">
                            <table class="custom-table w-full text-xs">
                                <thead>
                                    <tr><th>Tagging</th><th>Kandang</th><th>Kategori</th><th>Jenis Domba</th><th>ADG Terbaru</th></tr>
                                </thead>
                                <tbody id="tabelMinus2x"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4">
                        <p class="text-gray-300">📈 Qty ternak upweight minus timbang terakhir</p>
                        <p class="text-3xl font-bold text-emerald-300" id="qtyUpweightMinus">0</p>
                        <div class="mt-3 overflow-x-auto">
                            <table class="custom-table w-full text-xs">
                                <thead>
                                    <tr><th>Tagging</th><th>Kandang</th><th>Kategori</th><th>Jenis Domba</th><th>ADG Terbaru</th></tr>
                                </thead>
                                <tbody id="tabelUpweightMinus"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <h4 class="font-semibold text-white">📋 Data Timbang Ternak Per Bulan</h4>
                    <div class="overflow-x-auto">
                        <table class="custom-table w-full text-sm">
                            <thead>
                                <tr><th>Tagging</th><th>BB IN</th><th>BB 4 bln lalu</th><th>BB 3 bln lalu</th><th>BB 2 bln lalu</th><th>BB Bulan Lalu</th><th>BB Terbaru</th></tr>
                            </thead>
                            <tbody id="tabelTimbangData"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-white/5 sm:flex sm:flex-row-reverse sm:px-8">
                <button class="close-modal px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl">Tutup</button>
            </div>
        </div>
    </div>
</div>


<div id="modalAdgFcr" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-black/40 backdrop-blur-md rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-7xl sm:w-full border border-white/20">
            <div class="px-6 pt-6 pb-4 sm:px-8 sm:pt-8">
                <div class="flex justify-between items-center border-b border-white/10 pb-3 mb-4">
                    <h3 class="text-xl font-bold text-white">📊 ADG & FCR Analysis</h3>
                    <button class="close-modal text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white/5 p-3 rounded-xl text-center"><p class="text-gray-400">ADG (kg/hari)</p><p class="text-2xl font-bold text-emerald-300" id="summaryAdg">-</p></div>
                    <div class="bg-white/5 p-3 rounded-xl text-center"><p class="text-gray-400">Upweight (kg)</p><p class="text-2xl font-bold text-emerald-300" id="summaryUpweight">-</p></div>
                    <div class="bg-white/5 p-3 rounded-xl text-center"><p class="text-gray-400">QTY ternak</p><p class="text-2xl font-bold text-emerald-300" id="summaryQty">-</p></div>
                    <div class="bg-white/5 p-3 rounded-xl text-center"><p class="text-gray-400">FCR</p><p class="text-2xl font-bold text-emerald-300" id="summaryFcr">-</p></div>
                </div>
                <div class="mb-6">
                    <h4 class="font-semibold text-white">📈 Average ADG per bulan</h4>
                    <canvas id="adgPerBulanChart" height="250"></canvas>
                </div>
                <div class="mb-6">
                    <div class="flex flex-wrap gap-4 items-end mb-3">
                        <div><label class="text-gray-300 text-sm">Tanggal Awal</label><input type="date" id="startDate" class="bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"></div>
                        <div><label class="text-gray-300 text-sm">Tanggal Akhir</label><input type="date" id="endDate" class="bg-white/10 border border-white/20 rounded-xl px-3 py-2 text-white"></div>
                        <button id="filterDateBtn" class="bg-emerald-600 px-4 py-2 rounded-xl">Filter</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="custom-table w-full text-sm">
                            <thead>
                                <tr><th>Bulan</th><th>TAGGING</th><th>BB</th><th>Upweight</th><th>ADG</th></tr>
                            </thead>
                            <tbody id="tabelDataTernak"></tbody>
                        </table>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white/5 p-4 rounded-xl">
                        <p class="text-gray-300">🌾 Qty pakan (kg)</p>
                        <p class="text-2xl font-bold" id="qtyPakan">-</p>
                        <p class="mt-2">📈 Total upweight (kg)</p>
                        <p class="text-2xl font-bold" id="totalUpweight">-</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-white">🥕 Jenis pakan yang digunakan</h4>
                        <canvas id="pieChartPakan" height="200"></canvas>
                    </div>
                </div>
                <div class="overflow-x-auto mb-6">
                    <table class="custom-table w-full text-sm">
                        <thead>
                            <tr><th>JENIS PAKAN</th><th>KELUAR (Kg)</th><th>Persentase</th></tr>
                        </thead>
                        <tbody id="tabelPakan"></tbody>
                    </table>
                </div>
                <div>
                    <h4 class="font-semibold text-white">📉 FCR per bulan</h4>
                    <canvas id="fcrPerBulanChart" height="250"></canvas>
                </div>
            </div>
            <div class="px-6 py-4 bg-white/5 sm:flex sm:flex-row-reverse sm:px-8">
                <button class="close-modal px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Variabel untuk instance chart
let upweightChart, adgPerBulanChart, pieChartPakan, fcrPerBulanChart;

document.addEventListener('DOMContentLoaded', function() {
    // Load data utama untuk tabel-tabel fattening
    loadFatteningDetailed();

    // Inisialisasi event listener tombol
    document.getElementById('btnDetailPerTernak').addEventListener('click', openDetailModal);
    document.getElementById('btnDataTimbang').addEventListener('click', openDataTimbangModal);
    document.getElementById('btnAdgFcr').addEventListener('click', openAdgFcrModal);

    // Tombol tutup modal
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('modalDetailTernak').classList.add('hidden');
            document.getElementById('modalDataTimbang').classList.add('hidden');
            document.getElementById('modalAdgFcr').classList.add('hidden');
        });
    });

    // Event untuk filter tanggal di modal ADG & FCR
    document.getElementById('filterDateBtn').addEventListener('click', applyDateFilter);
});

// ==================== FUNGSI LOAD DATA UTAMA ====================
async function loadFatteningDetailed() {
    try {
        const res = await TernakPark.api.fetchData('/web-api/program/fattening-detailed');
        if (res.success) {
            const d = res.data;
            // Statistik
            document.getElementById('total-fattening').innerText = d.total ?? 0;
            document.getElementById('total-weight').innerText = (d.total_weight ?? 0).toLocaleString('id-ID') + ' kg';
            document.getElementById('avg-adg').innerText = (d.avg_adg ?? 0).toFixed(3);
            document.getElementById('male-count').innerText = d.male_count ?? 0;
            document.getElementById('female-count').innerText = d.female_count ?? 0;
            document.getElementById('adg-high').innerText = d.adg_high ?? 0;
            document.getElementById('adg-medium').innerText = d.adg_medium ?? 0;
            document.getElementById('adg-low').innerText = d.adg_low ?? 0;

            // Render tabel
            renderTable('male-table-body', d.males, ['ear_tag', 'breed_type', 'day_on_farm', 'sub_kategori', 'current_weight', 'average_daily_gain']);
            renderTable('female-table-body', d.females, ['ear_tag', 'breed_type', 'day_on_farm', 'sub_kategori', 'current_weight', 'average_daily_gain']);
            renderTable('adg-negative-body', d.adg_negative, ['ear_tag', 'day_on_farm', 'pen_name', 'current_weight', 'average_daily_gain']);
            renderTable('adg-zero-to-point-one-body', d.adg_zero_to_point_one, ['ear_tag', 'age_days', 'pen_name', 'current_weight', 'average_daily_gain']);
            renderTable('adg-above-point-one-body', d.adg_above_point_one, ['ear_tag', 'age_days', 'pen_name', 'current_weight', 'average_daily_gain']);
        } else {
            TernakPark.ui.showToast(res.message || 'Gagal memuat data fattening', 'error');
        }
    } catch(e) {
        console.error(e);
        TernakPark.ui.showToast('Koneksi error saat memuat data fattening', 'error');
    }
}

function renderTable(tbodyId, data, fields) {
    const tbody = document.getElementById(tbodyId);
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="' + fields.length + '" class="text-center py-6 text-gray-400">Tidak ada data</td></tr>';
        return;
    }
    let html = '';
    for (let i = 0; i < data.length; i++) {
        const row = data[i];
        html += '<tr class="border-b border-white/10 hover:bg-white/5 transition">';
        for (let j = 0; j < fields.length; j++) {
            const field = fields[j];
            let value = row[field];
            if (value === undefined || value === null) value = '-';
            if (field === 'average_daily_gain') value = parseFloat(value).toFixed(3);
            if (field === 'current_weight') value = parseFloat(value).toFixed(2);
            html += '<td class="px-3 py-2">' + escapeHtml(String(value)) + '</td>';
        }
        html += '</tr>';
    }
    tbody.innerHTML = html;
}

// ==================== DETAIL PER TERNAK ====================
async function openDetailModal() {
    // Ambil daftar ear tag untuk dropdown
    try {
        const res = await TernakPark.api.fetchData('/web-api/livestocks/data?per_page=1000');
        if (res.success && res.data.livestocks) {
            const select = document.getElementById('tagSelectDetail');
            select.innerHTML = '<option value="">-- Pilih Ternak --</option>';
            res.data.livestocks.forEach(l => {
                select.innerHTML += `<option value="${l.id}">${escapeHtml(l.ear_tag)} - ${escapeHtml(l.breed_type)}</option>`;
            });
            select.addEventListener('change', function() { if(this.value) loadDetailTernak(this.value); });
        }
    } catch(e) { console.error(e); }
    document.getElementById('modalDetailTernak').classList.remove('hidden');
}

async function loadDetailTernak(livestockId) {
    if (!livestockId) return;
    try {
        const res = await TernakPark.api.fetchData(`/web-api/livestocks/${livestockId}/detail`);
        if (res.success) {
            const l = res.data;
            // Isi info detail
            const infoHtml = `
                <div><span class="text-gray-400">Tag Lama:</span> ${escapeHtml(l.ear_tag)}</div>
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

            // Grafik upweight 6 bulan (ambil dari data weight records)
            const weightRecords = l.weight_records || [];
            const last6Months = weightRecords.slice(-6);
            const labels = last6Months.map(w => new Date(w.record_date).toLocaleDateString('id-ID', { month:'short', year:'numeric' }));
            const dataUpweight = last6Months.map(w => w.weight_kg);
            if (upweightChart) upweightChart.destroy();
            const ctx = document.getElementById('upweightChart').getContext('2d');
            upweightChart = new Chart(ctx, {
                type: 'bar',
                data: { labels: labels.length ? labels : ['Data tidak cukup'], datasets: [{ label: 'Upweight (kg)', data: dataUpweight.length ? dataUpweight : [0], backgroundColor: '#10b981' }] }
            });

            // Tabel timbang per bulan (sama dengan riwayat berat)
            let timbangHtml = '';
            if (weightRecords.length > 0) {
                const bbList = [l.initial_weight, ...weightRecords.slice(-5).map(w => w.weight_kg)];
                while(bbList.length < 6) bbList.push('-');
                timbangHtml = '<tr><td class="px-3 py-2">' + escapeHtml(l.ear_tag) + '</td>' + bbList.map(v => '<td class="px-3 py-2">' + v + '</td>').join('') + '</tr>';
            } else {
                timbangHtml = '<tr><td colspan="6" class="text-center text-gray-400">Belum ada data timbang</td></tr>';
            }
            document.getElementById('tabelTimbangDetail').innerHTML = timbangHtml;
        } else {
            TernakPark.ui.showToast('Gagal memuat detail ternak', 'error');
        }
    } catch(e) {
        console.error(e);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
}

// ==================== DATA TIMBANG ====================
async function openDataTimbangModal() {
    // Isi dropdown filter dari API livestocks dan pens
    try {
        const [livestockRes, penRes] = await Promise.all([
            TernakPark.api.fetchData('/web-api/livestocks/data?per_page=1000'),
            TernakPark.api.fetchData('/web-api/pens/data')
        ]);
        if (livestockRes.success) {
            const taggingSelect = document.getElementById('filterTagging');
            taggingSelect.innerHTML = '<option value="">Semua</option>';
            livestockRes.data.livestocks.forEach(l => {
                taggingSelect.innerHTML += `<option value="${escapeHtml(l.ear_tag)}">${escapeHtml(l.ear_tag)}</option>`;
            });
            const jenisSelect = document.getElementById('filterJenis');
            const uniqueBreeds = [...new Set(livestockRes.data.livestocks.map(l => l.breed_type))];
            jenisSelect.innerHTML = '<option value="">Semua</option>';
            uniqueBreeds.forEach(b => jenisSelect.innerHTML += `<option value="${b}">${escapeHtml(b.replace(/_/g, ' '))}</option>`);
        }
        if (penRes.success) {
            const kategoriSelect = document.getElementById('filterKategori');
            const uniqueKategori = [...new Set(penRes.data.pens.map(p => p.category))];
            kategoriSelect.innerHTML = '<option value="">Semua</option>';
            uniqueKategori.forEach(k => kategoriSelect.innerHTML += `<option value="${k}">${escapeHtml(k)}</option>`);
        }
        // Panggil fungsi loadDataTimbang dengan filter awal
        await loadDataTimbang();
        // Pasang event listener untuk setiap filter
        document.getElementById('filterTagging').addEventListener('change', loadDataTimbang);
        document.getElementById('filterJenis').addEventListener('change', loadDataTimbang);
        document.getElementById('filterKategori').addEventListener('change', loadDataTimbang);
    } catch(e) { console.error(e); }
    document.getElementById('modalDataTimbang').classList.remove('hidden');
}

async function loadDataTimbang() {
    const tagging = document.getElementById('filterTagging').value;
    const jenis = document.getElementById('filterJenis').value;
    const kategori = document.getElementById('filterKategori').value;
    try {
        const res = await TernakPark.api.fetchData(`/web-api/program/fattening-timbang?tagging=${encodeURIComponent(tagging)}&jenis=${encodeURIComponent(jenis)}&kategori=${encodeURIComponent(kategori)}`);
        if (res.success) {
            const d = res.data;
            document.getElementById('qtyMinus2x').innerText = d.qty_minus_2x || 0;
            document.getElementById('qtyUpweightMinus').innerText = d.qty_upweight_minus || 0;
            renderSimpleTable('tabelMinus2x', d.minus_2x_list, ['ear_tag', 'pen_name', 'pen_category', 'breed_type', 'adg']);
            renderSimpleTable('tabelUpweightMinus', d.upweight_minus_list, ['ear_tag', 'pen_name', 'pen_category', 'breed_type', 'adg']);
            renderSimpleTable('tabelTimbangData', d.timbang_per_bulan, ['ear_tag', 'bb_in', 'bb_4', 'bb_3', 'bb_2', 'bb_1', 'bb_now']);
        } else {
            TernakPark.ui.showToast(res.message || 'Gagal memuat data timbang', 'error');
        }
    } catch(e) {
        console.error(e);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
}

function renderSimpleTable(tbodyId, data, fields) {
    const tbody = document.getElementById(tbodyId);
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="' + fields.length + '" class="text-center py-2 text-gray-400">Tidak ada data</td></tr>';
        return;
    }
    let html = '';
    data.forEach(row => {
        html += '<tr class="border-b border-white/10">';
        fields.forEach(f => {
            let val = row[f] !== undefined ? row[f] : '-';
            if (f === 'adg') val = parseFloat(val).toFixed(4);
            html += '<td class="px-2 py-1">' + escapeHtml(String(val)) + '</td>';
        });
        html += '</tr>';
    });
    tbody.innerHTML = html;
}

// ==================== ADG & FCR ====================
async function openAdgFcrModal() {
    await loadAdgFcrData();
    document.getElementById('modalAdgFcr').classList.remove('hidden');
}

async function loadAdgFcrData(startDate = '', endDate = '') {
    try {
        let url = '/web-api/program/fattening-adg-fcr';
        if (startDate && endDate) url += `?start_date=${startDate}&end_date=${endDate}`;
        const res = await TernakPark.api.fetchData(url);
        if (res.success) {
            const d = res.data;
            document.getElementById('summaryAdg').innerText = d.avg_adg?.toFixed(3) || '0';
            document.getElementById('summaryUpweight').innerText = d.total_upweight?.toFixed(2) || '0';
            document.getElementById('summaryQty').innerText = d.qty_ternak || '0';
            document.getElementById('summaryFcr').innerText = d.fcr?.toFixed(2) || '0';
            document.getElementById('qtyPakan').innerText = d.qty_pakan?.toLocaleString() || '0';
            document.getElementById('totalUpweight').innerText = d.total_upweight?.toLocaleString() || '0';

            // Grafik ADG per bulan
            if (adgPerBulanChart) adgPerBulanChart.destroy();
            adgPerBulanChart = new Chart(document.getElementById('adgPerBulanChart'), {
                type: 'bar',
                data: { labels: d.adg_bulan_labels || [], datasets: [{ label: 'ADG (kg/hari)', data: d.adg_bulan_values || [], backgroundColor: '#f59e0b' }] }
            });

            // Tabel data ternak
            renderSimpleTable('tabelDataTernak', d.data_ternak, ['bulan', 'ear_tag', 'bb', 'upweight', 'adg']);

            // Pie chart pakan
            if (pieChartPakan) pieChartPakan.destroy();
            pieChartPakan = new Chart(document.getElementById('pieChartPakan'), {
                type: 'pie',
                data: { labels: d.pakan_labels || [], datasets: [{ data: d.pakan_values || [], backgroundColor: ['#10b981','#3b82f6','#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6','#f97316','#6b7280','#a855f7'] }] }
            });

            // Tabel rincian pakan
            renderSimpleTable('tabelPakan', d.pakan_rincian, ['nama_pakan', 'keluar_kg', 'persentase']);

            // Grafik FCR per bulan
            if (fcrPerBulanChart) fcrPerBulanChart.destroy();
            fcrPerBulanChart = new Chart(document.getElementById('fcrPerBulanChart'), {
                type: 'bar',
                data: { labels: d.fcr_bulan_labels || [], datasets: [{ label: 'Nilai FCR', data: d.fcr_bulan_values || [], backgroundColor: '#ef4444' }] }
            });
        } else {
            TernakPark.ui.showToast(res.message || 'Gagal memuat data ADG & FCR', 'error');
        }
    } catch(e) {
        console.error(e);
        TernakPark.ui.showToast('Koneksi error', 'error');
    }
}

async function applyDateFilter() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    if (!startDate || !endDate) {
        TernakPark.ui.showToast('Pilih kedua tanggal', 'warning');
        return;
    }
    await loadAdgFcrData(startDate, endDate);
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/program/fattening.blade.php ENDPATH**/ ?>