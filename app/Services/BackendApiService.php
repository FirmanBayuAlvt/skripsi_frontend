<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class BackendApiService
{
    /**
     * Base URL dari backend API.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Timeout request dalam detik.
     *
     * @var int
     */
    protected $timeout = 60;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->baseUrl = config('services.backend.base_url');
        Log::info('BackendApiService initialized', ['base_url' => $this->baseUrl]);
    }

    /**
     * Melakukan request HTTP ke backend API.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @return array
     */
    protected function request(string $method, string $endpoint, array $data = []): array
    {
        try {
            // Daftar endpoint yang boleh diakses tanpa token (tanpa slash di awal)
            $publicEndpoints = [
                'program/breeding/kawin',
                'program/breeding/kawin-ib',
            ];

            // Normalisasi endpoint: hilangkan slash di awal
            $normalizedEndpoint = ltrim($endpoint, '/');
            $isPublic = false;
            foreach ($publicEndpoints as $public) {
                if (strpos($normalizedEndpoint, $public) === 0) {
                    $isPublic = true;
                    break;
                }
            }

            $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
            $http = Http::timeout($this->timeout)->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            if (!$isPublic) {
                $token = session('token');
                if (empty($token)) {
                    Log::error('BackendApiService: No token for private endpoint: ' . $endpoint);
                    return [
                        'success'  => false,
                        'message'  => 'Token tidak ditemukan. Silakan login kembali.',
                        'redirect' => true,
                    ];
                }
                $http = $http->withToken($token);
                Log::info('BackendApiService request (private)', [
                    'method' => $method,
                    'url'    => $url,
                ]);
            } else {
                Log::info('BackendApiService request (public)', [
                    'method' => $method,
                    'url'    => $url,
                ]);
            }

            $response = $http->$method($url, $data);

            // Jika status 401 dan bukan public, flush session
            if ($response->status() === 401 && !$isPublic) {
                session()->flush();
                Log::error('Backend API 401 Unauthorized - session flushed');
                return [
                    'success'  => false,
                    'message'  => 'Sesi login habis. Silakan refresh halaman dan login kembali.',
                    'redirect' => true,
                ];
            }

            // Validasi response JSON
            $contentType = $response->header('Content-Type');
            if (!str_contains($contentType, 'application/json')) {
                $bodyPreview = substr($response->body(), 0, 500);
                Log::error('Backend API response not JSON', [
                    'url'          => $url,
                    'status'       => $response->status(),
                    'content_type' => $contentType,
                    'body_preview' => $bodyPreview,
                ]);

                if (in_array($response->status(), [419, 500])) {
                    session()->flush();
                }

                return [
                    'success' => false,
                    'message' => 'Server backend mengembalikan format tidak dikenal (bukan JSON). Detail: ' . $bodyPreview,
                    'status'  => $response->status(),
                ];
            }

            $responseData = $response->json();

            if ($response->successful()) {
                return $responseData;
            }

            $errorMessage = 'Backend API error: ' . $response->status();
            if (isset($responseData['message'])) {
                $errorMessage = $responseData['message'];
            } elseif (isset($responseData['errors'])) {
                $errorMessage = implode(', ', (array) $responseData['errors']);
            }

            Log::error('Backend API error', [
                'method' => $method,
                'url'    => $url,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => $errorMessage,
                'status'  => $response->status(),
            ];
        } catch (\Exception $exception) {
            Log::error('Backend API exception', [
                'message' => $exception->getMessage(),
                'trace'   => $exception->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'message' => 'Tidak dapat terhubung ke server backend: ' . $exception->getMessage(),
            ];
        }
    }

    /**
     * Mengirim request upload file (multipart/form-data).
     *
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @param string $fileKey
     * @param array $extraFields
     * @return array
     */
    protected function uploadFileRequest(string $method, string $endpoint, array $data, string $fileKey, array $extraFields = []): array
    {
        try {
            $token = session('token');
            if (empty($token)) {
                Log::warning('Upload request tanpa token');
                return [
                    'success'  => false,
                    'message'  => 'Token tidak ditemukan. Silakan login kembali.',
                    'redirect' => true,
                ];
            }

            $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
            $http = Http::timeout($this->timeout)
                ->withToken($token)
                ->withHeaders(['Accept' => 'application/json']);

            $file = $data[$fileKey] ?? null;
            unset($data[$fileKey]);

            foreach ($extraFields as $key => $value) {
                $data[$key] = $value;
            }

            $response = $http->attach(
                $fileKey,
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post($url, $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Backend API upload error', [
                'url'    => $url,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'Upload gagal: ' . $response->status(),
            ];
        } catch (\Exception $exception) {
            Log::error('Backend API upload exception', ['message' => $exception->getMessage()]);
            return [
                'success' => false,
                'message' => 'Koneksi error: ' . $exception->getMessage(),
            ];
        }
    }

    // ==================== LIVESTOCKS ====================

    /**
     * @param array $params
     * @return array
     */
    public function getLivestocks(array $params = []): array
    {
        return $this->request('get', '/livestocks', $params);
    }

    /**
     * @param int|string $id
     * @return array
     */
    public function getLivestockDetail($id): array
    {
        return $this->request('get', "/livestocks/{$id}");
    }

    /**
     * @param array $data
     * @return array
     */
    public function createLivestock(array $data): array
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            return $this->uploadFileRequest('post', '/livestocks', $data, 'image');
        }
        return $this->request('post', '/livestocks', $data);
    }

    /**
     * @param int|string $id
     * @param array $data
     * @return array
     */
    public function updateLivestock($id, array $data): array
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            return $this->uploadFileRequest('post', "/livestocks/{$id}", $data, 'image', ['_method' => 'PUT']);
        }
        return $this->request('put', "/livestocks/{$id}", $data);
    }

    /**
     * @param int|string $id
     * @return array
     */
    public function deleteLivestock($id): array
    {
        return $this->request('delete', "/livestocks/{$id}");
    }

    /**
     * @param int|string $id
     * @param array $data
     * @return array
     */
    public function recordWeight($id, array $data): array
    {
        return $this->request('post', "/livestocks/{$id}/record-weight", $data);
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     */
    public function importLivestocks(UploadedFile $file): array
    {
        return $this->uploadFileRequest('post', '/livestocks/import', ['file' => $file], 'file');
    }

    // ==================== PENS ====================

    /**
     * @param array $params
     * @return array
     */
    public function getPens(array $params = []): array
    {
        return $this->request('get', '/pens', $params);
    }

    /**
     * @param int|string $id
     * @return array
     */
    public function getPenDetail($id): array
    {
        return $this->request('get', "/pens/{$id}");
    }

    /**
     * @param int|string $id
     * @return array
     */
    public function getPenAnalytics($id): array
    {
        return $this->request('get', "/pens/{$id}/analytics");
    }

    /**
     * @param array $data
     * @return array
     */
    public function createPen(array $data): array
    {
        return $this->request('post', '/pens', $data);
    }

    /**
     * @param int|string $id
     * @param array $data
     * @return array
     */
    public function updatePen($id, array $data): array
    {
        return $this->request('put', "/pens/{$id}", $data);
    }

    /**
     * @param int|string $id
     * @return array
     */
    public function deletePen($id): array
    {
        return $this->request('delete', "/pens/{$id}");
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     */
    public function importPens(UploadedFile $file): array
    {
        return $this->uploadFileRequest('post', '/pens/import', ['file' => $file], 'file');
    }

    /**
     * @return array
     */
    public function getPenSummary(): array
    {
        return $this->request('get', '/pens/livestock');
    }

    // ==================== FEEDS ====================

    /**
     * @param array $params
     * @return array
     */
    public function getFeeds(array $params = []): array
    {
        return $this->request('get', '/feeds', $params);
    }

    /**
     * @return array
     */
    public function getFeedStock(): array
    {
        return $this->request('get', '/feeds/stock/summary');
    }

    /**
     * @return array
     */
    public function getFeedRequirements(): array
    {
        return $this->request('get', '/feeds/requirements');
    }

    /**
     * @param array $data
     * @return array
     */
    public function recordFeeding(array $data): array
    {
        return $this->request('post', '/feeds/record-feeding', $data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function updateFeedStock(array $data): array
    {
        return $this->request('post', '/feeds/update-stock', $data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function createFeed(array $data): array
    {
        return $this->request('post', '/feeds', $data);
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     */
    public function importFeeds(UploadedFile $file): array
    {
        return $this->uploadFileRequest('post', '/feeds/import', ['file' => $file], 'file');
    }

    /**
     * @return array
     */
    public function getFeedAnalytics(): array
    {
        return $this->request('get', '/feeds/analytics');
    }

    /**
     * @param array $params
     * @return array
     */
    public function getUsageData(array $params = []): array
    {
        return $this->request('get', '/feeds/usage-data', $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getProcurementData(array $params = []): array
    {
        return $this->request('get', '/feeds/procurement-data', $params);
    }

    // ==================== PREDICTIONS ====================

    /**
     * @param array $params
     * @return array
     */
    public function getPredictions(array $params = []): array
    {
        return $this->request('get', '/predictions', $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getPredictionHistory(array $params = []): array
    {
        return $this->request('get', '/predictions/history', $params);
    }

    /**
     * @return array
     */
    public function getCorrelationData(): array
    {
        return $this->request('get', '/predictions/correlation');
    }

    /**
     * @param array $data
     * @return array
     */
    public function createPrediction(array $data): array
    {
        return $this->request('post', '/predictions', $data);
    }

    // ==================== DASHBOARD ====================

    /**
     * @return array
     */
    public function getDashboardOverview(): array
    {
        return $this->request('get', '/dashboard/overview');
    }

    /**
     * @return array
     */
    public function getDashboardPenAnalytics(): array
    {
        return $this->request('get', '/dashboard/pen-analytics');
    }

    /**
     * @return array
     */
    public function getDashboardStatistics(): array
    {
        return $this->request('get', '/dashboard/statistics');
    }

    // ==================== REPORTS ====================

    /**
     * @return array
     */
    public function getReportSummary(): array
    {
        return $this->request('get', '/reports/summary');
    }

    /**
     * @return array
     */
    public function getReportPerformance(): array
    {
        return $this->request('get', '/reports/performance');
    }

    /**
     * @return array
     */
    public function getReportGrowth(): array
    {
        return $this->request('get', '/reports/growth');
    }

    /**
     * @return array
     */
    public function getReportFinancial(): array
    {
        return $this->request('get', '/reports/financial');
    }

    // ==================== PROGRAM ====================

    /**
     * @return array
     */
    public function getFatteningData(): array
    {
        return $this->request('get', '/program/fattening');
    }

    /**
     * @return array
     */
    public function getFatteningDetailed(): array
    {
        return $this->request('get', '/program/fattening-detailed');
    }

    /**
     * @param array $params
     * @return array
     */
    public function getFatteningTimbangData(array $params = []): array
    {
        return $this->request('get', '/program/fattening-timbang', $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getFatteningAdgFcrData(array $params = []): array
    {
        return $this->request('get', '/program/fattening-adg-fcr', $params);
    }

    /**
     * @return array
     */
    public function getBreedingData(): array
    {
        return $this->request('get', '/program/breeding');
    }

    /**
     * @param string $earTag
     * @return array
     */
    public function getFamily(string $earTag): array
    {
        return $this->request('get', '/program/family', ['ear_tag' => $earTag]);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getBreedingIndukData(array $params = []): array
    {
        return $this->request('get', '/program/breeding/indukan', $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getBreedingJantanData(array $params = []): array
    {
        return $this->request('get', '/program/breeding/pejantan', $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getBreedingAnakanData(array $params = []): array
    {
        return $this->request('get', '/program/breeding/anakan', $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getBreedingKawinIbData(array $params = []): array
    {
        return $this->request('get', '/program/breeding/kawin-ib', $params);
    }

    // ==================== LOGBOOK ====================

    /**
     * @param array $params
     * @return array
     */
    public function getLogbookData(array $params = []): array
    {
        return $this->request('get', '/logbook', $params);
    }

    // ==================== HPP ====================

    /**
     * @return array
     */
    public function getHppData(): array
    {
        return $this->request('get', '/hpp');
    }

    // ==================== NOTIFIKASI ====================

    /**
     * @return array
     */
    public function getNotifikasiData(): array
    {
        return $this->request('get', '/notifikasi');
    }

    // ==================== NOTIFICATIONS ====================

    /**
     * @param array $params
     * @return array
     */
    public function getNotifications(array $params = []): array
    {
        return $this->request('get', '/notifications', $params);
    }

    /**
     * @return array
     */
    public function getUnreadCount(): array
    {
        return $this->request('get', '/notifications/unread-count');
    }

    /**
     * @param string $notificationId
     * @return array
     */
    public function markNotificationAsRead(string $notificationId): array
    {
        return $this->request('post', "/notifications/{$notificationId}/mark-as-read");
    }

    /**
     * @return array
     */
    public function markAllNotificationsAsRead(): array
    {
        return $this->request('post', '/notifications/mark-all-as-read');
    }
}
