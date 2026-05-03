@extends('layouts.app')

@section('title', 'Notifikasi Harian')
@section('header-title', 'Notifikasi')

@section('content')
<div class="space-y-6">
    <!-- Tombol Kembali ke Dashboard -->
    <div class="flex justify-end">
        <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- Kartu Notifikasi Stok Pakan & Kesehatan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Stok Pakan Menipis -->
        <div class="glass-card p-5">
            <div class="flex items-center gap-3 border-b border-white/10 pb-3 mb-4">
                <div class="p-2 bg-amber-500/20 rounded-xl">
                    <i class="fas fa-exclamation-triangle text-amber-400 text-xl"></i>
                </div>
                <h3 class="font-bold text-white text-lg">Stok Pakan Menipis</h3>
            </div>
            <div id="low-stock-notif" class="text-gray-300">
                <div class="text-center py-4"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat...</div>
            </div>
        </div>

        <!-- Peringatan Kesehatan -->
        <div class="glass-card p-5">
            <div class="flex items-center gap-3 border-b border-white/10 pb-3 mb-4">
                <div class="p-2 bg-red-500/20 rounded-xl">
                    <i class="fas fa-heartbeat text-red-400 text-xl"></i>
                </div>
                <h3 class="font-bold text-white text-lg">Peringatan Kesehatan</h3>
            </div>
            <div id="health-notif" class="text-gray-300">
                <div class="text-center py-4"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat...</div>
            </div>
        </div>
    </div>

    {{-- Ringkasan HPP & Rekomendasi --}}
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-chart-line text-emerald-400 text-xl"></i>
            <h3 class="font-bold text-white text-lg">Ringkasan HPP & Rekomendasi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm text-white">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr class="text-gray-300 text-xs uppercase">
                        <th class="px-4 py-3 text-left">Tagging</th>
                        <th class="px-4 py-3 text-left">HPP Pembelian</th>
                        <th class="px-4 py-3 text-left">Pakan</th>
                        <th class="px-4 py-3 text-left">Operasional</th>
                        <th class="px-4 py-3 text-left">Total HPP</th>
                        <th class="px-4 py-3 text-left">Rekomendasi</th>
                    </tr>
                </thead>
                <tbody id="hpp-notif-table">
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400">Memuat data...
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Semua Notifikasi --}}
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center justify-between border-b border-white/10 p-5">
            <div class="flex items-center gap-2">
                <i class="fas fa-bell text-emerald-400 text-xl"></i>
                <h3 class="font-bold text-white text-lg">Semua Notifikasi</h3>
            </div>
            <button id="mark-all-read-btn" class="text-sm text-emerald-400 hover:text-emerald-300 transition">Tandai semua telah dibaca</button>
        </div>
        <div id="notifications-list" class="divide-y divide-white/10">
            <div class="p-8 text-center text-gray-400">Memuat...</div>
        </div>
        <div id="pagination" class="p-4 border-t border-white/10 flex justify-between items-center"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPage = 1;

document.addEventListener('DOMContentLoaded', function() {
    loadNotifikasiRingkasan();
    loadNotifications();
    const markAllButton = document.getElementById('mark-all-read-btn');
    if (markAllButton) {
        markAllButton.addEventListener('click', markAllAsRead);
    }
});

// ==================== RINGKASAN NOTIFIKASI (STOK, KESEHATAN, HPP) ====================
async function loadNotifikasiRingkasan() {
    try {
        // Panggil endpoint dashboard/statistics untuk mendapatkan data ringkasan
        const dashboardStats = await TernakPark.api.fetchData('/web-api/dashboard/statistics');
        if (dashboardStats.success) {
            // Data stok rendah dari feeds API
            const feedStock = await TernakPark.api.fetchData('/web-api/feeds/stock-levels');
            if (feedStock.success && feedStock.data.low_stock_alerts) {
                renderLowStockFeeds(feedStock.data.low_stock_alerts);
            } else {
                renderLowStockFeeds([]);
            }

            // Data kesehatan: ternak dengan health_status poor
            const livestocks = await TernakPark.api.fetchData('/web-api/livestocks/data?per_page=1000');
            if (livestocks.success) {
                const healthWarnings = livestocks.data.livestocks.filter(l => l.health_status === 'poor' || l.health_status === 'fair');
                renderHealthWarnings(healthWarnings);
            } else {
                renderHealthWarnings([]);
            }

            // HPP data
            const hppData = await TernakPark.api.fetchData('/web-api/hpp');
            if (hppData.success && hppData.data.detail) {
                renderHppTable(hppData.data.detail);
            } else {
                renderHppTable([]);
            }
        } else {
            throw new Error('Gagal memuat data dashboard');
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Gagal memuat ringkasan notifikasi: ' + error.message, 'error');
        document.getElementById('low-stock-notif').innerHTML = '<div class="text-red-400 text-center py-4">Gagal memuat data</div>';
        document.getElementById('health-notif').innerHTML = '<div class="text-red-400 text-center py-4">Gagal memuat data</div>';
        document.getElementById('hpp-notif-table').innerHTML = '<tr><td colspan="6" class="text-center py-8 text-red-400">Gagal memuat data HPP</td></tr>';
    }
}

function renderLowStockFeeds(feeds) {
    const container = document.getElementById('low-stock-notif');
    if (!feeds || feeds.length === 0) {
        container.innerHTML = '<div class="flex items-center gap-3 p-3 bg-emerald-500/10 rounded-xl border border-emerald-500/30"><i class="fas fa-check-circle text-emerald-400"></i><span>Tidak ada stok pakan menipis.</span></div>';
        return;
    }

    let html = '<div class="space-y-2">';
    for (const feed of feeds) {
        html += `
            <div class="flex justify-between items-center p-3 bg-amber-500/10 rounded-xl border border-amber-500/30">
                <div>
                    <p class="font-medium text-white">${escapeHtml(feed.name)}</p>
                    <p class="text-sm text-gray-400">Stok tersisa</p>
                </div>
                <div class="text-right">
                    <p class="text-xl font-bold text-amber-400">${feed.current_stock} kg</p>
                    <p class="text-xs text-gray-400">Segera restok</p>
                </div>
            </div>
        `;
    }
    html += '</div>';
    container.innerHTML = html;
}

function renderHealthWarnings(warnings) {
    const container = document.getElementById('health-notif');
    if (!warnings || warnings.length === 0) {
        container.innerHTML = '<div class="flex items-center gap-3 p-3 bg-emerald-500/10 rounded-xl border border-emerald-500/30"><i class="fas fa-check-circle text-emerald-400"></i><span>Tidak ada peringatan kesehatan.</span></div>';
        return;
    }

    let html = '<div class="space-y-2">';
    for (const warning of warnings) {
        html += `
            <div class="flex justify-between items-center p-3 bg-red-500/10 rounded-xl border border-red-500/30">
                <div>
                    <p class="font-medium text-white">${escapeHtml(warning.ear_tag)}</p>
                    <p class="text-sm text-gray-400">Status kesehatan: ${escapeHtml(warning.health_status)}</p>
                </div>
                <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
            </div>
        `;
    }
    html += '</div>';
    container.innerHTML = html;
}

function renderHppTable(hppDetail) {
    const tableBody = document.getElementById('hpp-notif-table');
    if (!hppDetail || hppDetail.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-8 text-gray-400">Tidak ada data HPP</td></tr>';
        return;
    }

    let html = '';
    for (const detail of hppDetail) {
        html += `
            <tr class="border-b border-white/10 hover:bg-white/5 transition">
                <td class="px-4 py-3 font-medium">${escapeHtml(detail.tagging)}</td>
                <td class="px-4 py-3">${formatRupiah(detail.hpp_pembelian)}</td>
                <td class="px-4 py-3">${formatRupiah(detail.pakan)}</td>
                <td class="px-4 py-3">${formatRupiah(detail.operasional)}</td>
                <td class="px-4 py-3 text-emerald-300 font-semibold">${formatRupiah(detail.total)}</td>
                <td class="px-4 py-3">${escapeHtml(detail.rekomendasi || '-')}</td>
            </tr>
        `;
    }
    tableBody.innerHTML = html;
}

function formatRupiah(angka) {
    if (angka === undefined || angka === null) return 'Rp 0';
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
}

// ==================== SEMUA NOTIFIKASI (PAGINATION, MARK AS READ) ====================
async function loadNotifications(pageNumber = 1) {
    currentPage = pageNumber;
    try {
        const response = await TernakPark.api.fetchData(`/web-api/notifikasi?page=${pageNumber}&per_page=15`);
        if (response.success) {
            renderAllNotifications(response.data);
            renderPaginationAll(response.pagination);
        } else {
            document.getElementById('notifications-list').innerHTML = '<div class="p-8 text-center text-red-400">Gagal memuat notifikasi</div>';
        }
    } catch (error) {
        console.error(error);
        document.getElementById('notifications-list').innerHTML = '<div class="p-8 text-center text-red-400">Koneksi error</div>';
    }
}

function renderAllNotifications(notifications) {
    const container = document.getElementById('notifications-list');
    if (!notifications || notifications.length === 0) {
        container.innerHTML = '<div class="p-8 text-center text-gray-400">Tidak ada notifikasi</div>';
        return;
    }

    let html = '';
    for (const notification of notifications) {
        const isUnread = notification.read_at === null;
        html += `
            <div class="p-4 hover:bg-white/5 transition cursor-pointer ${isUnread ? 'bg-emerald-900/20' : ''}" data-id="${notification.id}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white">${escapeHtml(notification.title)}</p>
                        <p class="text-xs text-gray-400 mt-1">${escapeHtml(notification.message)}</p>
                        <p class="text-xs text-gray-500 mt-2">${TernakPark.format.timeAgo(notification.created_at)}</p>
                    </div>
                    ${isUnread ? '<i class="fas fa-circle text-emerald-500 text-xs mt-1 ml-2"></i>' : ''}
                </div>
            </div>
        `;
    }
    container.innerHTML = html;

    // Attach click event for each notification
    const notificationElements = container.querySelectorAll('[data-id]');
    for (const element of notificationElements) {
        element.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-id');
            markSingleNotificationAsRead(notificationId);
        });
    }
}

function renderPaginationAll(paginationData) {
    const paginationContainer = document.getElementById('pagination');
    if (!paginationData || paginationData.total <= paginationData.per_page) {
        paginationContainer.innerHTML = '';
        return;
    }

    const startItem = (paginationData.current_page - 1) * paginationData.per_page + 1;
    const endItem = Math.min(paginationData.current_page * paginationData.per_page, paginationData.total);

    let paginationHtml = `<div class="text-sm text-gray-400">Menampilkan ${startItem} - ${endItem} dari ${paginationData.total}</div>`;
    paginationHtml += '<div class="flex space-x-2">';

    if (paginationData.current_page > 1) {
        paginationHtml += `<button onclick="loadNotifications(${paginationData.current_page - 1})" class="px-3 py-1 bg-white/10 rounded-xl hover:bg-white/20">Prev</button>`;
    }
    if (paginationData.current_page < paginationData.last_page) {
        paginationHtml += `<button onclick="loadNotifications(${paginationData.current_page + 1})" class="px-3 py-1 bg-white/10 rounded-xl hover:bg-white/20">Next</button>`;
    }

    paginationHtml += '</div>';
    paginationContainer.innerHTML = paginationHtml;
}

async function markSingleNotificationAsRead(notificationId) {
    try {
        const response = await fetch(`/web-api/notifikasi/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const result = await response.json();
        if (result.success) {
            loadNotifications(currentPage);
            updateUnreadBadge();
        }
    } catch (error) {
        console.error('Failed to mark notification as read:', error);
    }
}

async function markAllAsRead() {
    try {
        const response = await fetch('/web-api/notifikasi/mark-all-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const result = await response.json();
        if (result.success) {
            loadNotifications(currentPage);
            updateUnreadBadge();
            TernakPark.ui.showToast('Semua notifikasi telah ditandai dibaca', 'success');
        }
    } catch (error) {
        console.error('Failed to mark all as read:', error);
        TernakPark.ui.showToast('Gagal menandai semua notifikasi', 'error');
    }
}

async function updateUnreadBadge() {
    try {
        const response = await fetch('/web-api/notifikasi/unread-count');
        const data = await response.json();
        if (data.success && typeof window.updateNotificationBadge === 'function') {
            window.updateNotificationBadge(data.count);
        }
    } catch (error) {
        console.error('Failed to fetch unread count for badge:', error);
    }
}

function escapeHtml(rawString) {
    if (!rawString) return '';
    return String(rawString).replace(/[&<>]/g, function(match) {
        if (match === '&') return '&amp;';
        if (match === '<') return '&lt;';
        if (match === '>') return '&gt;';
        return match;
    });
}
</script>
@endpush
