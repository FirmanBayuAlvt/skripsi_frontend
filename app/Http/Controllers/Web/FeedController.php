<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BackendApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedController extends Controller
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
     * Menampilkan halaman utama manajemen pakan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('feeds.index');
    }

    /**
     * Menampilkan halaman stok pakan.
     *
     * @return \Illuminate\View\View
     */
    public function stock()
    {
        return view('feeds.stock');
    }

    /**
     * Menampilkan halaman kebutuhan pakan.
     *
     * @return \Illuminate\View\View
     */
    public function requirements()
    {
        return view('feeds.requirements');
    }

    /**
     * Menampilkan halaman penggunaan pakan.
     *
     * @return \Illuminate\View\View
     */
    public function usage()
    {
        return view('feeds.usage');
    }

    /**
     * Menampilkan halaman pengadaan pakan.
     *
     * @return \Illuminate\View\View
     */
    public function procurement()
    {
        return view('feeds.procurement');
    }

    /**
     * Menampilkan halaman analitik pakan.
     *
     * @return \Illuminate\View\View
     */
    public function analytics()
    {
        return view('feeds.analytics');
    }

    /**
     * Mengambil data pakan untuk AJAX datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFeedsData(Request $request)
    {
        try {
            $result = $this->api->getFeeds($request->all());
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching feeds data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pakan'
            ], 500);
        }
    }

    /**
     * Mengambil tingkat stok pakan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStockLevels()
    {
        try {
            $result = $this->api->getFeedStock();
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching stock levels: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data stok pakan'
            ], 500);
        }
    }

    /**
     * Mengambil data kebutuhan pakan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFeedRequirements()
    {
        try {
            $result = $this->api->getFeedRequirements();
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching feed requirements: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kebutuhan pakan'
            ], 500);
        }
    }

    /**
     * Mencatat pemberian pakan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recordFeeding(Request $request)
    {
        try {
            $result = $this->api->recordFeeding($request->all());
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error recording feeding: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencatat pemberian pakan'
            ], 500);
        }
    }

    /**
     * Memperbarui stok pakan (menambah stok).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStock(Request $request)
    {
        try {
            $result = $this->api->updateFeedStock($request->all());
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error updating stock: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui stok pakan'
            ], 500);
        }
    }

    /**
     * Menyimpan jenis pakan baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeFeed(Request $request)
    {
        try {
            $result = $this->api->createFeed($request->all());
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error storing feed: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pakan'
            ], 500);
        }
    }

    /**
     * Mengimpor data pakan dari file Excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function importFeeds(Request $request)
    {
        try {
            $file = $request->file('file');
            if (!$file || !$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak valid atau tidak ditemukan'
                ], 400);
            }

            $result = $this->api->importFeeds($file);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error importing feeds: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengimpor data pakan: ' . $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil data analitik pakan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnalytics()
    {
        try {
            $result = $this->api->getFeedAnalytics();
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching feed analytics: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data analitik pakan'
            ], 500);
        }
    }

    /**
     * Mengambil data penggunaan pakan untuk grafik dan tabel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsageData(Request $request)
    {
        try {
            $params = $request->only(['start_date', 'end_date', 'feed_name', 'page']);
            $result = $this->api->getUsageData($params);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching usage data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data penggunaan pakan'
            ], 500);
        }
    }

    /**
     * Mengambil data pengadaan pakan untuk grafik dan tabel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProcurementData(Request $request)
    {
        try {
            $params = $request->only(['start_date', 'end_date', 'feed_name']);
            $result = $this->api->getProcurementData($params);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching procurement data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pengadaan pakan'
            ], 500);
        }
    }
}
