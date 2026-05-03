<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TernakPark</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            backdrop-filter: blur(14px);
            border: 1px solid rgba(72, 187, 120, 0.35);
            border-radius: 2rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.2s ease, border-color 0.2s;
        }
        .glass-card:hover {
            border-color: rgba(72, 187, 120, 0.8);
        }
        .input-field {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1rem;
            transition: all 0.2s ease;
            color: white;
        }
        .input-field:focus {
            outline: none;
            border-color: #10b981;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .btn-login {
            background: linear-gradient(105deg, #10b981 0%, #059669 100%);
            border: none;
            transition: all 0.25s ease;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px rgba(16, 185, 129, 0.5);
            filter: brightness(1.05);
        }
        .login-card {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(72, 187, 120, 0.3);
            border-radius: 2rem;
            transition: all 0.3s;
        }
        .login-card:hover {
            border-color: rgba(72, 187, 120, 0.7);
            box-shadow: 0 25px 40px -15px rgba(0, 0, 0, 0.6);
        }
        .logo-circle {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(4px);
            border-radius: 1.5rem;
            padding: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .brand-text {
            text-align: left;
            padding-right: 0.5rem;
        }
        .brand-text p {
            line-height: 1.6;
            text-align: justify;
            margin-bottom: 0.75rem;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #a7f3d0;
            letter-spacing: -0.3px;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-5">
    <div class="w-full max-w-6xl">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Left: Branding dengan logo dan definisi ringkas -->
            <div class="glass-card rounded-3xl p-8 flex flex-col justify-center backdrop-blur-md">
                <div class="text-center md:text-left">
                    <!-- Logo diperbesar -->
                    <div class="flex justify-center md:justify-start mb-6">
                        <img src="{{ asset('images/logo TernakPark Wonosalam.png') }}"
                             alt="TernakPark"
                             class="h-20 w-auto object-contain brightness-110">
                    </div>
                    <div class="brand-text">
                        <div class="section-title">Manajemen Data Peternakan</div>
                        <p class="text-white/90 text-base">
                            Pengelolaan informasi ternak, pakan, kesehatan, dan produksi secara terintegrasi untuk pengambilan keputusan yang lebih baik.
                        </p>
                        <p class="text-white/90 text-base">
                            Dengan data terstruktur, peternak dapat memantau performa individu, mengoptimalkan stok pakan, serta menganalisis tren produksi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right: Form Login dengan logo TernakPark sebagai icon -->
            <div class="login-card p-8 md:p-10">
                <div class="text-center mb-8">
                    <div class="mx-auto w-20 h-20 logo-circle flex items-center justify-center mb-4 shadow-lg">
                        <img src="{{ asset('images/logo TernakPark Wonosalam.png') }}"
                             alt="TernakPark Logo"
                             class="h-12 w-auto object-contain">
                    </div>
                    <h2 class="text-2xl font-bold text-white">Selamat Datang Kembali</h2>
                    <p class="text-emerald-200/70 text-sm mt-1">Masuk ke akun TernakPark Anda</p>
                </div>

                <form method="POST" action="/login" id="loginForm">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-emerald-200 mb-1">Email</label>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                   class="input-field w-full px-4 py-3 rounded-xl text-white placeholder:text-gray-400"
                                   placeholder="admin@ternakpark.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-emerald-200 mb-1">Password</label>
                            <input type="password" name="password" required
                                   class="input-field w-full px-4 py-3 rounded-xl text-white placeholder:text-gray-400"
                                   placeholder="••••••••">
                        </div>
                        <button type="submit" id="loginBtn"
                                class="btn-login w-full py-3 rounded-xl text-white font-semibold shadow-md transition-all">
                            Masuk Sekarang
                        </button>
                    </div>
                </form>

                @if($errors->any())
                    <div class="mt-6 bg-red-900/40 border border-red-500/40 text-red-200 rounded-xl p-4 text-sm backdrop-blur-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mt-8 text-center text-xs text-emerald-300/60 border-t border-emerald-500/20 pt-6">
                    &copy; {{ date('Y') }} TernakPark. All rights reserved.
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm')?.addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            if(btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sedang masuk...';
            }
        });
    </script>
</body>
</html>
