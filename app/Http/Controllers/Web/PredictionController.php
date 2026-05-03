<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BackendApiService;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PredictionController extends Controller
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
     * Menampilkan halaman utama prediksi.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('predictions.index');
    }

    /**
     * Menampilkan halaman analisis korelasi.
     *
     * @return \Illuminate\View\View
     */
    public function correlation()
    {
        return view('predictions.correlation');
    }

    /**
     * Mengambil data prediksi untuk AJAX datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPredictionsData(Request $request)
    {
        try {
            $result = $this->api->getPredictions($request->all());
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching predictions data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data prediksi'
            ], 500);
        }
    }

    /**
     * Mengambil riwayat prediksi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPredictionHistory(Request $request)
    {
        try {
            $result = $this->api->getPredictionHistory($request->all());
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching prediction history: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat prediksi'
            ], 500);
        }
    }

    /**
     * Mengambil data korelasi.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCorrelationData()
    {
        try {
            $result = $this->api->getCorrelationData();
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching correlation data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data korelasi'
            ], 500);
        }
    }

    /**
     * Membuat prediksi baru.
     * Setelah prediksi berhasil dibuat, kirim notifikasi ke pengguna yang membuat prediksi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPrediction(Request $request)
    {
        try {
            $result = $this->api->createPrediction($request->all());
            $statusCode = $result['status'] ?? 200;

            // Jika prediksi berhasil, kirim notifikasi ke pengguna yang sedang login
            if (($result['success'] ?? false) && isset($result['data'])) {
                $predictionData = $result['data'];
                $livestockEarTag = $predictionData['livestock']['ear_tag'] ?? 'Unknown';
                $predictedGain = $predictionData['predicted_gain'] ?? 0;
                $userId = session('user')['id'] ?? null;

                if ($userId) {
                    NotificationHelper::sendToUser(
                        $userId,
                        '📊 Prediksi Selesai',
                        "Prediksi pertumbuhan untuk ternak ID {$livestockEarTag} telah selesai. Kenaikan bobot diprediksi {$predictedGain} kg.",
                        'success',
                        [
                            'livestock_id' => $predictionData['livestock']['id'] ?? null,
                            'predicted_gain' => $predictedGain
                        ]
                    );
                }
            }

            return response()->json($result, $statusCode);
        } catch (\Exception $exception) {
            Log::error('Error creating prediction: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat prediksi: ' . $exception->getMessage()
            ], 500);
        }
    }
}
