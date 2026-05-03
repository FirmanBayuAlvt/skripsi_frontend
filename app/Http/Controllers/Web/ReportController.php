<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BackendApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
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
     * Menampilkan halaman ringkasan laporan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $response = $this->api->getReportSummary();
            $data = $response['data'] ?? [];
        } catch (\Exception $e) {
            Log::error('Error loading report summary page: ' . $e->getMessage());
            $data = [];
        }
        return view('reports.index', $data);
    }

    /**
     * Menampilkan halaman laporan performa.
     *
     * @return \Illuminate\View\View
     */
    public function performance()
    {
        try {
            $response = $this->api->getReportPerformance();
            $data = $response['data'] ?? [];
        } catch (\Exception $e) {
            Log::error('Error loading report performance page: ' . $e->getMessage());
            $data = [];
        }
        return view('reports.performance', $data);
    }

    /**
     * Menampilkan halaman laporan pertumbuhan.
     *
     * @return \Illuminate\View\View
     */
    public function growth()
    {
        try {
            $response = $this->api->getReportGrowth();
            $data = $response['data'] ?? [];
        } catch (\Exception $e) {
            Log::error('Error loading report growth page: ' . $e->getMessage());
            $data = [];
        }
        return view('reports.growth', $data);
    }

    /**
     * Menampilkan halaman laporan keuangan.
     *
     * @return \Illuminate\View\View
     */
    public function financial()
    {
        try {
            $response = $this->api->getReportFinancial();
            $data = $response['data'] ?? [];
        } catch (\Exception $e) {
            Log::error('Error loading report financial page: ' . $e->getMessage());
            $data = [];
        }
        return view('reports.financial', $data);
    }

    /**
     * Mengambil data laporan dalam format JSON untuk AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportsData(Request $request)
    {
        try {
            $type = $request->get('type', 'summary');
            $method = 'getReport' . ucfirst($type);

            if (method_exists($this->api, $method)) {
                $response = $this->api->$method();
                return response()->json($response);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid report type: ' . $type
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error fetching report data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data laporan: ' . $e->getMessage()
            ], 500);
        }
    }
}
