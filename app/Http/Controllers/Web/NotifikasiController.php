<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BackendApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotifikasiController extends Controller
{
    /**
     * Instance dari BackendApiService untuk komunikasi dengan backend API.
     *
     * @var \App\Services\BackendApiService
     */
    protected $api;

    /**
     * Constructor untuk menginisialisasi service API.
     *
     * @param \App\Services\BackendApiService $api
     */
    public function __construct(BackendApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Menampilkan halaman notifikasi.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('notifikasi.index');
    }

    /**
     * Mengambil data notifikasi untuk AJAX (daftar notifikasi dengan paginasi).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications(Request $request)
    {
        try {
            $params = [
                'page'     => $request->input('page', 1),
                'per_page' => $request->input('per_page', 15),
            ];

            $result = $this->api->getNotifications($params);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching notifications: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data notifikasi: ' . $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Mendapatkan jumlah notifikasi yang belum dibaca.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadCount()
    {
        try {
            $result = $this->api->getUnreadCount();
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching unread count: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'count' => 0,
                'message' => 'Gagal mengambil jumlah notifikasi belum dibaca: ' . $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Menandai notifikasi sebagai sudah dibaca berdasarkan ID.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($id)
    {
        try {
            $result = $this->api->markNotificationAsRead($id);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error marking notification as read: ' . $exception->getMessage(), [
                'trace'     => $exception->getTraceAsString(),
                'notif_id'  => $id,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai notifikasi sebagai dibaca: ' . $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Menandai semua notifikasi sebagai sudah dibaca.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead()
    {
        try {
            $result = $this->api->markAllNotificationsAsRead();
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error marking all notifications as read: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai semua notifikasi sebagai dibaca: ' . $exception->getMessage(),
            ], 500);
        }
    }
}
