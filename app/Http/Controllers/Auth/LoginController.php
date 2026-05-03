<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses login dengan mengirim kredensial ke backend API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        try {
            // Bangun URL endpoint login backend
            $url = rtrim(config('services.backend.base_url'), '/') . '/login';
            Log::info('Login attempt', [
                'email' => $request->email,
                'url'   => $url
            ]);

            // Kirim request ke backend
            $response = Http::acceptJson()->timeout(30)->post($url, [
                'email'    => $request->email,
                'password' => $request->password,
            ]);

            Log::info('Login response', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            // Decode response JSON
            $data = $response->json();

            // Jika login sukses
            if ($response->successful() && isset($data['success']) && $data['success'] === true) {
                // Ambil token dan data user dari respons
                $token = $data['data']['token'] ?? null;
                $user  = $data['data']['user'] ?? null;

                // Pastikan token tidak kosong
                if (empty($token)) {
                    Log::error('Login success but token is missing from backend response');
                    return back()->withErrors([
                        'email' => 'Terjadi kesalahan: token tidak ditemukan dari server.'
                    ])->withInput();
                }

                // Simpan data ke session
                session([
                    'user'  => $user,
                    'token' => $token,
                    'role'  => $user['role'] ?? 'general_manager',
                ]);

                // Simpan session secara eksplisit (opsional, karena Laravel otomatis menyimpan di akhir request,
                // namun ini memastikan jika ada redirect cepat)
                session()->save();

                // Regenerasi session ID untuk mencegah session fixation
                $request->session()->regenerate();

                Log::info('Login success', [
                    'user_id'    => $user['id'] ?? null,
                    'email'      => $user['email'] ?? null,
                    'role'       => session('role'),
                    'token_pref' => substr($token, 0, 10) . '...',
                ]);

                // Redirect ke dashboard atau halaman yang dimaksud sebelumnya
                return redirect()->intended(route('dashboard'));
            }

            // Login gagal (password salah, email tidak terdaftar, dll)
            $message = $data['message'] ?? 'Login gagal. Periksa email dan password Anda.';
            Log::error('Login failed', [
                'email'   => $request->email,
                'message' => $message,
                'status'  => $response->status(),
            ]);

            return back()->withErrors(['email' => $message])->withInput();
        } catch (\Exception $exception) {
            // Exception koneksi atau lainnya
            Log::error('Login exception: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);

            return back()->withErrors([
                'email' => 'Koneksi ke server gagal: ' . $exception->getMessage()
            ])->withInput();
        }
    }

    /**
     * Memproses logout: hapus session, invalidate token, dan regenerasi CSRF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $token = session('token');

        // 1. Panggil API logout backend untuk mencabut token Sanctum (jika ada)
        if ($token) {
            try {
                $backendUrl = rtrim(config('services.backend.base_url'), '/') . '/logout';
                $response = Http::withToken($token)
                    ->timeout(5)
                    ->post($backendUrl);

                if ($response->successful()) {
                    Log::info('Backend logout success');
                } else {
                    Log::warning('Backend logout failed', [
                        'status' => $response->status(),
                        'body'   => $response->body(),
                    ]);
                }
            } catch (\Exception $exception) {
                Log::error('Backend logout exception: ' . $exception->getMessage());
                // Abaikan error, tetap lanjutkan logout di frontend
            }
        }

        // 2. Hapus semua data session frontend
        session()->flush();

        // 3. Invalidate session dan regenerasi token CSRF untuk mencegah session fixation
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('User logged out, session flushed and invalidated');

        // 4. Redirect ke halaman login
        return redirect('/login');
    }
}
