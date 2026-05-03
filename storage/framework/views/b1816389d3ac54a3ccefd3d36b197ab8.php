<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | TernakPark</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        body {
            background: radial-gradient(ellipse at 20% 30%, #0b3b2a, #031a0e) fixed;
            margin: 0;
            padding: 0;
        }
        .glass-card {
            background: rgba(10, 30, 20, 0.55);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(72, 187, 120, 0.35);
            border-radius: 2rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.2s ease, border-color 0.2s;
        }
        .glass-card:hover {
            border-color: rgba(72, 187, 120, 0.7);
        }
        .btn-premium {
            background: linear-gradient(105deg, #10b981 0%, #059669 100%);
            transition: all 0.25s ease;
        }
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px rgba(16, 185, 129, 0.5);
            filter: brightness(1.05);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-5">
    <div class="w-full max-w-lg">
        <!-- Kartu glassmorphism premium -->
        <div class="glass-card p-8 text-center">
            <!-- Logo -->
            <img src="<?php echo e(asset('images/logo TernakPark Wonosalam.png')); ?>" alt="TernakPark" class="h-16 mx-auto mb-6 brightness-110">

            <!-- Ikon ilustrasi -->
            <div class="mx-auto w-20 h-20 rounded-full bg-emerald-500/20 flex items-center justify-center mb-6">
                <i class="fas fa-map-signs text-4xl text-emerald-300"></i>
            </div>

            <!-- Angka 404 dengan gaya modern -->
            <h1 class="text-8xl md:text-9xl font-extrabold text-white tracking-tighter bg-gradient-to-r from-emerald-200 to-teal-300 bg-clip-text text-transparent">404</h1>

            <!-- Pesan utama -->
            <p class="text-2xl font-semibold text-white mt-4">Halaman Tidak Ditemukan</p>
            <p class="text-emerald-100/70 mt-2">Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>

            <!-- Tombol kembali dengan efek premium -->
            <div class="mt-8">
                <a href="<?php echo e(url('/')); ?>" class="btn-premium inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-semibold shadow-md transition-all">
                    <i class="fas fa-arrow-left text-sm"></i>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Garis dekoratif -->
            <div class="mt-8 pt-4 border-t border-emerald-500/30">
                <p class="text-emerald-200/50 text-xs">TernakPark · Manajemen Data Peternakan</p>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/errors/404.blade.php ENDPATH**/ ?>