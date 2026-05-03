<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BackendApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogbookController extends Controller
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
     * Menampilkan halaman utama logbook.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('logbook.index');
    }

    /**
     * Mengambil data logbook untuk AJAX datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLogbookData(Request $request)
    {
        try {
            $params = $request->only(['tagging', 'start_date', 'end_date', 'kejadian', 'page', 'per_page']);
            $result = $this->api->getLogbookData($params);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching logbook data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data logbook: ' . $exception->getMessage()
            ], 500);
        }
    }
}
