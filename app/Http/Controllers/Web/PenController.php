<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BackendApiService;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenController extends Controller
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
     * Menampilkan halaman utama manajemen kandang.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pens.index');
    }

    /**
     * Menampilkan detail satu kandang.
     *
     * @param  int|string  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->api->getPenDetail($id);
        if (!($response['success'] ?? false)) {
            abort(404);
        }
        return view('pens.show', ['pen' => $response['data']]);
    }

    /**
     * Menampilkan halaman analitik untuk satu kandang.
     *
     * @param  int|string  $id
     * @return \Illuminate\View\View
     */
    public function analytics($id)
    {
        $response = $this->api->getPenAnalytics($id);
        if (!($response['success'] ?? false)) {
            abort(404);
        }
        return view('pens.analytics', ['data' => $response['data']]);
    }

    /**
     * Mengambil data kandang untuk AJAX datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPensData(Request $request)
    {
        try {
            $result = $this->api->getPens($request->all());
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching pens data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kandang'
            ], 500);
        }
    }

    /**
     * Mengambil detail satu kandang (AJAX).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPenDetail($id)
    {
        try {
            $result = $this->api->getPenDetail($id);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching pen detail: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail kandang'
            ], 500);
        }
    }

    /**
     * Mengambil data analitik untuk satu kandang (AJAX).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPenAnalytics($id)
    {
        try {
            $result = $this->api->getPenAnalytics($id);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching pen analytics: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data analitik kandang'
            ], 500);
        }
    }

    /**
     * Menyimpan kandang baru.
     * Setelah berhasil, periksa apakah tingkat okupansi mencapai atau melebihi 90%,
     * jika iya, kirim notifikasi ke administrator.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePen(Request $request)
    {
        try {
            $result = $this->api->createPen($request->all());
            $statusCode = $result['status'] ?? 200;
            if (($result['success'] ?? false) && isset($result['data'])) {
                $penData = $result['data'];
                $capacity = $penData['capacity'] ?? 0;
                $currentOccupancy = $penData['current_occupancy'] ?? 0;
                if ($capacity > 0 && ($currentOccupancy / $capacity) >= 0.9) {
                    $occupancyPercentage = round(($currentOccupancy / $capacity) * 100, 2);
                    NotificationHelper::sendToAdmins(
                        '🏠 Kandang Hampir Penuh',
                        "Kandang {$penData['name']} telah terisi {$currentOccupancy} dari {$capacity} ekor (okupansi {$occupancyPercentage}%).",
                        'info',
                        ['pen_id' => $penData['id'], 'occupancy' => $currentOccupancy, 'capacity' => $capacity]
                    );
                }
            }
            return response()->json($result, $statusCode);
        } catch (\Exception $exception) {
            Log::error('Error storing pen: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan kandang: ' . $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Memperbarui data kandang yang sudah ada.
     * Setelah berhasil, periksa apakah tingkat okupansi mencapai atau melebihi 90%,
     * jika iya, kirim notifikasi ke administrator.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePen(Request $request, $id)
    {
        try {
            // Ambil data kandang lama sebelum update untuk perbandingan (opsional)
            $oldPenResponse = $this->api->getPenDetail($id);
            $oldPenData = $oldPenResponse['data'] ?? [];
            $oldCapacity = $oldPenData['capacity'] ?? 0;
            $oldOccupancy = $oldPenData['current_occupancy'] ?? 0;

            // Lakukan update menggunakan method yang tersedia di BackendApiService
            $result = $this->api->updatePen($id, $request->all());
            $statusCode = $result['status'] ?? 200;

            if (($result['success'] ?? false) && isset($result['data'])) {
                $penData = $result['data'];
                $newCapacity = $penData['capacity'] ?? $oldCapacity;
                $newOccupancy = $penData['current_occupancy'] ?? $oldOccupancy;
                if ($newCapacity > 0 && ($newOccupancy / $newCapacity) >= 0.9) {
                    $occupancyPercentage = round(($newOccupancy / $newCapacity) * 100, 2);
                    NotificationHelper::sendToAdmins(
                        '🏠 Kandang Hampir Penuh',
                        "Kandang {$penData['name']} telah terisi {$newOccupancy} dari {$newCapacity} ekor (okupansi {$occupancyPercentage}%).",
                        'info',
                        ['pen_id' => $penData['id'], 'occupancy' => $newOccupancy, 'capacity' => $newCapacity]
                    );
                }
            }
            return response()->json($result, $statusCode);
        } catch (\Exception $exception) {
            Log::error('Error updating pen: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kandang: ' . $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Mengimpor data kandang dari file Excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function importPens(Request $request)
    {
        try {
            $file = $request->file('file');
            if (!$file || !$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak valid atau tidak ditemukan'
                ], 400);
            }

            $result = $this->api->importPens($file);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error importing pens: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengimpor data kandang: ' . $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Menonaktifkan (soft delete) kandang.
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyPen($id)
    {
        try {
            // Pastikan method deletePen tersedia di BackendApiService
            $result = $this->api->deletePen($id);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error deleting pen: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menonaktifkan kandang'
            ], 500);
        }
    }

    /**
     * Mengambil ringkasan jumlah ternak dan total bobot per kandang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPenSummary(Request $request)
    {
        try {
            $result = $this->api->getPenSummary();
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching pen summary: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data ringkasan kandang: ' . $exception->getMessage()
            ], 500);
        }
    }
}
