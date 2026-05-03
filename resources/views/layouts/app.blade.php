<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - TernakPark</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <style>
        /* ========== GLOBAL STYLE PREMIUM HIJAU GELAP ========== */
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Sembunyikan elemen dengan x-cloak sebelum Alpine.js siap */
        [x-cloak] {
            display: none !important;
        }

        /* Background utama halaman */
        body {
            background: radial-gradient(ellipse at 20% 30%, #0b3b2a, #031a0e) fixed;
            margin: 0;
            padding: 0;
        }

        /* Sidebar premium dengan efek glassmorphism gelap */
        .sidebar-premium {
            background: rgba(10, 30, 20, 0.65);
            backdrop-filter: blur(14px);
            border-right: 1px solid rgba(72, 187, 120, 0.3);
            box-shadow: 4px 0 25px -8px rgba(0, 0, 0, 0.4);
        }

        /* Item sidebar */
        .sidebar-item {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            margin: 4px 12px;
            font-weight: 500;
            letter-spacing: 0.01em;
            color: #e2e8f0;
        }

        .sidebar-item:hover {
            background: rgba(72, 187, 120, 0.2);
            transform: translateX(4px);
            color: white;
        }

        .sidebar-item-active {
            background: rgba(72, 187, 120, 0.25);
            border-left: 3px solid #10b981;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .sidebar-item i {
            transition: transform 0.2s ease;
        }

        .sidebar-item:hover i {
            transform: scale(1.05);
        }

        /* Top bar (header) dengan blur dan latar transparan */
        .top-bar {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(72, 187, 120, 0.3);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
        }

        .top-bar h1 {
            color: #f1f5f9;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Loading Overlay premium */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 30, 20, 0.96);
            backdrop-filter: blur(12px);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transition: opacity 0.3s ease;
            opacity: 0;
            visibility: hidden;
        }

        #loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .loading-logo {
            width: 80px;
            height: auto;
            animation: bounce 0.8s infinite ease-in-out;
            margin-bottom: 1rem;
        }

        .loading-text {
            color: #a7f3d0;
            font-size: 1.1rem;
            margin-top: 1rem;
            letter-spacing: 1px;
            font-weight: 500;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Toast Notification - Gaya gelap premium */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            min-width: 320px;
            max-width: 420px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 10000;
            transform: translateX(120%);
            transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border: 1px solid rgba(72, 187, 120, 0.4);
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast-success {
            border-left: 4px solid #10b981;
        }

        .toast-error {
            border-left: 4px solid #ef4444;
        }

        .toast-warning {
            border-left: 4px solid #f59e0b;
        }

        .toast-info {
            border-left: 4px solid #3b82f6;
        }

        .toast-icon {
            font-size: 1.5rem;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 2px;
            color: #e2e8f0;
        }

        .toast-message {
            font-size: 0.8rem;
            color: #cbd5e1;
        }

        .toast-close {
            cursor: pointer;
            color: #94a3b8;
            font-size: 1rem;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: #f1f5f9;
        }

        /* Notifikasi dropdown */
        .notif-dropdown {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(72, 187, 120, 0.4);
            border-radius: 1rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.5);
        }

        /* Scrollbar kustom */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #1e2a2e;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #2c7a4d;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #10b981;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased">
    <!-- Loading Overlay dengan Logo -->
    <div id="loading-overlay">
        <img src="{{ asset('images/logo TernakPark Wonosalam.png') }}" alt="TernakPark" class="loading-logo">
        <div class="loading-text">Mohon Tunggu</div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container"></div>

    <div class="flex h-screen">
        <!-- Sidebar Premium -->
        <aside class="w-72 sidebar-premium text-white flex flex-col shadow-xl">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo TernakPark Wonosalam.png') }}" alt="TernakPark" class="h-10 w-auto object-contain">
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">TernakPark</h1>
                        <p class="text-xs text-emerald-200/80">Wonosalam · Jombang</p>
                    </div>
                </div>
            </div>
            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 {{ request()->routeIs('dashboard') ? 'sidebar-item-active' : '' }}">
                    <i class="fas fa-chart-line w-5 text-center text-emerald-300"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <!-- Prediksi -->
                <a href="{{ route('predictions.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 {{ request()->routeIs('predictions.*') ? 'sidebar-item-active' : '' }}">
                    <i class="fas fa-brain w-5 text-center text-emerald-300"></i>
                    <span class="text-sm font-medium">Prediksi</span>
                </a>

                <!-- Menu untuk semua role (General Manager & Administrator) -->
                <a href="{{ route('program.fattening') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 {{ request()->routeIs('program.fattening') ? 'sidebar-item-active' : '' }}">
                    <i class="fas fa-weight-hanging w-5 text-center text-emerald-300"></i>
                    <span class="text-sm font-medium">Fattening Domba</span>
                </a>
                <a href="{{ route('program.breeding') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 {{ request()->routeIs('program.breeding') ? 'sidebar-item-active' : '' }}">
                    <i class="fas fa-heart w-5 text-center text-emerald-300"></i>
                    <span class="text-sm font-medium">Breeding Domba</span>
                </a>

                <!-- Menu khusus Administrator -->
                @if(session('role') == 'administrator')
                    <a href="{{ route('livestocks.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 {{ request()->routeIs('livestocks.*') ? 'sidebar-item-active' : '' }}">
                        <i class="fas fa-paw w-5 text-center text-emerald-300"></i>
                        <span class="text-sm font-medium">Ternak</span>
                    </a>
                    <a href="{{ route('pens.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 {{ request()->routeIs('pens.*') ? 'sidebar-item-active' : '' }}">
                        <i class="fas fa-warehouse w-5 text-center text-emerald-300"></i>
                        <span class="text-sm font-medium">Kandang</span>
                    </a>
                    <a href="{{ route('feeds.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 {{ request()->routeIs('feeds.*') ? 'sidebar-item-active' : '' }}">
                        <i class="fas fa-seedling w-5 text-center text-emerald-300"></i>
                        <span class="text-sm font-medium">Pakan</span>
                    </a>
                    <a href="{{ route('reports.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 {{ request()->routeIs('reports.*') ? 'sidebar-item-active' : '' }}">
                        <i class="fas fa-file-alt w-5 text-center text-emerald-300"></i>
                        <span class="text-sm font-medium">Laporan</span>
                    </a>
                @endif
            </nav>
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-user text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold truncate text-white">{{ session('user')['name'] ?? 'Pengguna' }}</p>
                        <p class="text-xs text-emerald-200/80 capitalize">{{ session('role') ?? 'role' }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-emerald-200/80 hover:text-white transition flex items-center space-x-1 mt-1">
                                <i class="fas fa-sign-out-alt mr-1"></i> <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <header class="top-bar sticky top-0 z-20 px-8 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">@yield('header-title', 'Dashboard')</h1>
                <div class="flex items-center space-x-5">
                    <!-- Notifikasi dengan Alpine.js -->
                    <div class="relative" x-data="notificationComponent()" x-init="init()">
                        <button @click="toggleDropdown()" class="relative text-white/80 hover:text-white transition focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                            <template x-if="unreadCount > 0">
                                <span x-text="unreadCount > 9 ? '9+' : unreadCount" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1"></span>
                            </template>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-3 w-96 notif-dropdown z-50 max-h-[500px] overflow-y-auto rounded-xl">
                            <div class="sticky top-0 bg-black/80 backdrop-blur-md p-3 border-b border-white/10 flex justify-between items-center">
                                <span class="font-medium text-gray-200">Notifikasi</span>
                                <button @click="markAllAsRead()" class="text-xs text-emerald-400 hover:text-emerald-300 transition">Tandai semua dibaca</button>
                            </div>
                            <div class="divide-y divide-white/10">
                                <template x-for="notif in notifications" :key="notif.id">
                                    <div class="p-4 hover:bg-white/5 transition cursor-pointer" :class="{ 'bg-emerald-900/20': !notif.read_at }" @click="markAsRead(notif.id)">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-white" x-text="notif.title"></p>
                                                <p class="text-xs text-gray-400 mt-1" x-text="notif.message"></p>
                                                <p class="text-xs text-gray-500 mt-2" x-text="formatTime(notif.created_at)"></p>
                                            </div>
                                            <i x-show="!notif.read_at" class="fas fa-circle text-emerald-500 text-xs mt-1 ml-2"></i>
                                        </div>
                                    </div>
                                </template>
                                <div x-show="notifications.length === 0" class="p-6 text-center text-gray-400">
                                    <i class="fas fa-bell-slash text-3xl mb-2 block text-gray-600"></i>
                                    Tidak ada notifikasi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="liveClock" class="text-sm text-white/70 hidden md:block">-- : -- : --</span>
                </div>
            </header>
            <div class="px-8 pt-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-900/50 border-l-4 border-emerald-500 text-emerald-100 rounded-xl shadow-sm flex items-center backdrop-blur-sm">
                        <i class="fas fa-check-circle mr-3 text-emerald-400"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-900/50 border-l-4 border-red-500 text-red-100 rounded-xl shadow-sm flex items-center backdrop-blur-sm">
                        <i class="fas fa-exclamation-circle mr-3 text-red-400"></i> {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="px-8 py-6">
                @hasSection('page-header')
                    <div class="mb-6">
                        @yield('page-header')
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Toast Notification System
        class ToastManager {
            constructor() {
                this.container = document.getElementById('toast-container');
                if (!this.container) {
                    this.container = document.createElement('div');
                    this.container.id = 'toast-container';
                    document.body.appendChild(this.container);
                }
            }

            show(message, type = 'success', title = null) {
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;

                let icon = '';
                let defaultTitle = '';
                switch(type) {
                    case 'success':
                        icon = '<i class="fas fa-check-circle text-emerald-400 toast-icon"></i>';
                        defaultTitle = 'Berhasil';
                        break;
                    case 'error':
                        icon = '<i class="fas fa-exclamation-circle text-red-400 toast-icon"></i>';
                        defaultTitle = 'Gagal';
                        break;
                    case 'warning':
                        icon = '<i class="fas fa-exclamation-triangle text-amber-400 toast-icon"></i>';
                        defaultTitle = 'Peringatan';
                        break;
                    default:
                        icon = '<i class="fas fa-info-circle text-blue-400 toast-icon"></i>';
                        defaultTitle = 'Informasi';
                }

                toast.innerHTML = `
                    ${icon}
                    <div class="toast-content">
                        <div class="toast-title">${title || defaultTitle}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <i class="fas fa-times toast-close"></i>
                `;

                this.container.appendChild(toast);
                setTimeout(() => toast.classList.add('show'), 10);
                const closeButton = toast.querySelector('.toast-close');
                closeButton.addEventListener('click', () => this.hide(toast));
                setTimeout(() => this.hide(toast), 4000);
            }

            hide(toast) {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }
        }

        const toast = new ToastManager();

        window.TernakPark = {
            api: {
                fetchData: async (url, options = {}) => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const headers = {
                        'Accept': 'application/json',
                        ...options.headers
                    };
                    if (csrfToken) {
                        headers['X-CSRF-TOKEN'] = csrfToken;
                    }
                    try {
                        const response = await fetch(url, { ...options, headers });
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}`);
                        }
                        return await response.json();
                    } catch (error) {
                        toast.show(error.message, 'error', 'Koneksi Gagal');
                        throw error;
                    }
                }
            },
            format: {
                number: (number) => new Intl.NumberFormat('id-ID').format(number),
                currency: (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number),
                date: (dateString) => new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
                timeAgo: (dateString) => {
                    const difference = Date.now() - new Date(dateString);
                    const minutes = Math.floor(difference / 60000);
                    if (minutes < 60) {
                        return minutes + ' menit lalu';
                    }
                    const hours = Math.floor(minutes / 60);
                    if (hours < 24) {
                        return hours + ' jam lalu';
                    }
                    const days = Math.floor(hours / 24);
                    return days + ' hari lalu';
                }
            },
            ui: {
                showToast: (message, type = 'success') => {
                    toast.show(message, type);
                }
            }
        };

        function updateClock() {
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const formatted = now.toLocaleDateString('id-ID', options);
            const clockElement = document.getElementById('liveClock');
            if (clockElement) {
                clockElement.textContent = formatted;
            }
        }
        updateClock();
        setInterval(updateClock, 1000);

        const loadingOverlay = document.getElementById('loading-overlay');
        function showLoading() {
            if (loadingOverlay) {
                loadingOverlay.classList.add('show');
            }
        }
        function hideLoading() {
            if (loadingOverlay) {
                loadingOverlay.classList.remove('show');
            }
        }

        document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"])').forEach((link) => {
            link.addEventListener('click', (event) => {
                if (link.getAttribute('href') && link.getAttribute('href') !== '#') {
                    showLoading();
                }
            });
        });
        document.querySelectorAll('form').forEach((form) => {
            form.addEventListener('submit', () => showLoading());
        });
        window.addEventListener('load', hideLoading);
        window.addEventListener('pageshow', hideLoading);
    </script>

    <script>
        function notificationComponent() {
            return {
                open: false,
                unreadCount: 0,
                notifications: [],
                async init() {
                    await this.fetchUnreadCount();
                    setInterval(() => this.fetchUnreadCount(), 60000);
                },
                toggleDropdown() {
                    this.open = !this.open;
                    if (this.open) {
                        this.fetchNotifications();
                    }
                },
                async fetchUnreadCount() {
                    try {
                        const response = await fetch('/web-api/notifikasi/unread-count', {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.unreadCount = data.count;
                        }
                    } catch (error) {
                        console.error('Failed to fetch unread count:', error);
                    }
                },
                async fetchNotifications() {
                    try {
                        const response = await fetch('/web-api/notifikasi?per_page=20', {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.notifications = data.data;
                        }
                    } catch (error) {
                        console.error('Failed to fetch notifications:', error);
                        this.notifications = [];
                    }
                },
                async markAsRead(notificationId) {
                    try {
                        const response = await fetch(`/web-api/notifikasi/${notificationId}/mark-as-read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        const result = await response.json();
                        if (result.success) {
                            const index = this.notifications.findIndex(notification => notification.id === notificationId);
                            if (index !== -1 && !this.notifications[index].read_at) {
                                this.notifications[index].read_at = new Date().toISOString();
                                this.unreadCount = Math.max(0, this.unreadCount - 1);
                                TernakPark.ui.showToast('Notifikasi ditandai sudah dibaca', 'info');
                            }
                        }
                    } catch (error) {
                        console.error('Failed to mark as read:', error);
                    }
                },
                async markAllAsRead() {
                    try {
                        const response = await fetch('/web-api/notifikasi/mark-all-as-read', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        const result = await response.json();
                        if (result.success) {
                            this.notifications.forEach(notification => {
                                notification.read_at = new Date().toISOString();
                            });
                            this.unreadCount = 0;
                            TernakPark.ui.showToast('Semua notifikasi ditandai sudah dibaca', 'success');
                        }
                    } catch (error) {
                        console.error('Failed to mark all as read:', error);
                    }
                },
                formatTime(isoString) {
                    if (!isoString) {
                        return '';
                    }
                    return TernakPark.format.timeAgo(isoString);
                }
            };
        }
    </script>
    @stack('scripts')
</body>
</html>
