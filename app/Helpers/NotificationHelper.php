<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationHelper
{
    /**
     * Mengirim notifikasi ke semua administrator melalui backend API.
     *
     * @param string $title
     * @param string $message
     * @param string $type
     * @param array $additionalData
     * @return void
     */
    public static function sendToAdmins($title, $message, $type = 'info', $additionalData = [])
    {
        $backendUrl = rtrim(config('services.backend.base_url'), '/');
        $token = session('token');

        if (empty($token)) {
            Log::warning('NotificationHelper: Tidak ada token session, notifikasi tidak dikirim.', [
                'title' => $title,
                'message' => $message
            ]);
            return;
        }

        try {
            $response = Http::withToken($token)
                ->timeout(5)
                ->post($backendUrl . '/notifications/admin-broadcast', [
                    'title'   => $title,
                    'message' => $message,
                    'type'    => $type,
                    'data'    => $additionalData,
                ]);

            if ($response->successful()) {
                Log::info('Notifikasi ke admin berhasil dikirim.', [
                    'title' => $title,
                    'response' => $response->json()
                ]);
            } else {
                Log::error('Gagal mengirim notifikasi ke admin.', [
                    'title' => $title,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception saat mengirim notifikasi ke admin: ' . $e->getMessage(), [
                'title' => $title,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Mengirim notifikasi ke satu user tertentu melalui backend API.
     *
     * @param int|string $userId
     * @param string $title
     * @param string $message
     * @param string $type
     * @param array $additionalData
     * @return void
     */
    public static function sendToUser($userId, $title, $message, $type = 'info', $additionalData = [])
    {
        $backendUrl = rtrim(config('services.backend.base_url'), '/');
        $token = session('token');

        if (empty($token)) {
            Log::warning('NotificationHelper: Tidak ada token session, notifikasi tidak dikirim.');
            return;
        }

        try {
            $response = Http::withToken($token)
                ->timeout(5)
                ->post($backendUrl . '/notifications/user-broadcast', [
                    'user_id' => $userId,
                    'title'   => $title,
                    'message' => $message,
                    'type'    => $type,
                    'data'    => $additionalData,
                ]);

            if ($response->successful()) {
                Log::info("Notifikasi ke user {$userId} berhasil dikirim.", ['title' => $title]);
            } else {
                Log::error("Gagal mengirim notifikasi ke user {$userId}.", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Exception saat mengirim notifikasi ke user {$userId}: " . $e->getMessage());
        }
    }

    /**
     * Mengirim notifikasi ke semua user (broadcast) melalui backend API.
     *
     * @param string $title
     * @param string $message
     * @param string $type
     * @param array $additionalData
     * @return void
     */
    public static function broadcastToAll($title, $message, $type = 'info', $additionalData = [])
    {
        $backendUrl = rtrim(config('services.backend.base_url'), '/');
        $token = session('token');

        if (empty($token)) {
            Log::warning('NotificationHelper: Tidak ada token session, broadcast notifikasi dibatalkan.');
            return;
        }

        try {
            $response = Http::withToken($token)
                ->timeout(5)
                ->post($backendUrl . '/notifications/broadcast', [
                    'title'   => $title,
                    'message' => $message,
                    'type'    => $type,
                    'data'    => $additionalData,
                ]);

            if ($response->successful()) {
                Log::info('Broadcast notifikasi berhasil.', ['title' => $title]);
            } else {
                Log::error('Gagal melakukan broadcast notifikasi.', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception saat broadcast notifikasi: ' . $e->getMessage());
        }
    }
}
