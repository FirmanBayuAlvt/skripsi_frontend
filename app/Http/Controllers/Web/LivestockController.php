<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BackendApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LivestockController extends Controller
{
    /**
     * Instance dari BackendApiService untuk komunikasi dengan backend API.
     *
     * @var \App\Services\BackendApiService
     */
    protected BackendApiService $api;

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
     * Menampilkan halaman utama manajemen ternak.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }
        if (session('role') !== 'administrator') {
            abort(403, 'Akses ditolak.');
        }
        return view('livestocks.index');
    }

    /**
     * Menampilkan detail satu ternak.
     *
     * @param  int|string  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $response = $this->api->getLivestockDetail($id);
        if (!($response['success'] ?? false)) {
            abort(404);
        }
        return view('livestocks.show', ['livestock' => $response['data']]);
    }

    /**
     * Mengambil data ternak untuk datatable (AJAX).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLivestocksData(Request $request)
    {
        try {
            $result = $this->api->getLivestocks($request->all());
            return response()->json($result, $this->getHttpStatusCode($result));
        } catch (\Exception $exception) {
            Log::error('Error fetching livestocks data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data ternak.'
            ], 500);
        }
    }

    /**
     * Mengambil detail satu ternak (AJAX).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLivestockDetail($id)
    {
        try {
            $result = $this->api->getLivestockDetail($id);
            return response()->json($result, $this->getHttpStatusCode($result));
        } catch (\Exception $exception) {
            Log::error('Error fetching livestock detail: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail ternak.'
            ], 500);
        }
    }

    /**
     * Menyimpan data ternak baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeLivestock(Request $request)
    {
        try {
            $result = $this->api->createLivestock($request->all());
            return response()->json($result, $this->getHttpStatusCode($result));
        } catch (\Exception $exception) {
            Log::error('Error storing livestock: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan数据 ternak.'
            ], 500);
        }
    }

    /**
     * Memperbarui data ternak yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLivestock(Request $request, $id)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image');
            }

            $result = $this->api->updateLivestock($id, $data);
            return response()->json($result, $this->getHttpStatusCode($result));
        } catch (\Exception $exception) {
            Log::error('Error updating livestock: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data ternak.'
            ], 500);
        }
    }

    /**
     * Menonaktifkan (soft delete) ternak.
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyLivestock($id)
    {
        try {
            $result = $this->api->deleteLivestock($id);
            return response()->json($result, $this->getHttpStatusCode($result));
        } catch (\Exception $exception) {
            Log::error('Error deleting livestock: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menonaktifkan ternak.'
            ], 500);
        }
    }

    /**
     * Mencatat berat badan ternak.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function recordWeight(Request $request, $id)
    {
        try {
            $result = $this->api->recordWeight($id, $request->all());
            return response()->json($result, $this->getHttpStatusCode($result));
        } catch (\Exception $exception) {
            Log::error('Error recording weight: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencatat berat badan.'
            ], 500);
        }
    }

    /**
     * Mengimpor data ternak dari file Excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function importLivestocks(Request $request)
    {
        try {
            $file = $request->file('file');
            if (!$file || !$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak valid atau tidak ditemukan.'
                ], 400);
            }

            // Validasi ekstensi file
            $allowedMimes = ['xlsx', 'xls', 'csv'];
            $extension = $file->getClientOriginalExtension();
            if (!in_array(strtolower($extension), $allowedMimes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format file harus .xlsx, .xls, atau .csv.'
                ], 400);
            }

            $result = $this->api->importLivestocks($file);
            return response()->json($result, $this->getHttpStatusCode($result));
        } catch (\Exception $exception) {
            Log::error('Error importing livestocks: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengimpor data: ' . $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Mendapatkan status HTTP berdasarkan respons dari service.
     *
     * @param  array  $result
     * @return int
     */
    private function getHttpStatusCode(array $result): int
    {
        if (($result['success'] ?? false) === true) {
            return 200;
        }
        return $result['status'] ?? 400;
    }
}
