<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BackendApiService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $api;

    public function __construct(BackendApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        return view('dashboard');
    }

    public function getOverviewData()
    {
        return response()->json($this->api->getDashboardOverview());
    }

    public function getPenAnalytics()
    {
        return response()->json($this->api->getDashboardPenAnalytics());
    }

    public function getPredictionHistory()
    {
        return response()->json($this->api->getPredictionHistory(['per_page' => 5]));
    }

    public function getStatistics()
    {
        // Panggil API backend untuk data statistik lengkap dashboard
        // Pastikan method getDashboardStatistics() sudah ada di BackendApiService
        return response()->json($this->api->getDashboardStatistics());
    }
}
