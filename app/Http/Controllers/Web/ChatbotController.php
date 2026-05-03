<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BackendApiService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected $api;

    public function __construct(BackendApiService $api)
    {
        $this->api = $api;
    }

    public function handle(Request $request)
    {
        $message = trim((string)$request->input('message', ''));

        if ($message === '') {
            return response()->json(['reply' => 'Silakan tulis pertanyaan atau perintah. Contoh: "prediksi 12", "formulasi pakan berat 35 target 0.2", atau "stok pakan hari ini".']);
        }

        $normalized = mb_strtolower($message, 'UTF-8');
        $reply = $this->generateReply($message, $normalized);

        return response()->json(['reply' => $reply]);
    }

    protected function generateReply(string $original, string $text): string
    {
        // Handle prediction requests with more flexible patterns
        if ($this->containsAny($text, ['prediksi', 'perkiraan', 'estimasi', 'growth', 'prediksi pertumbuhan', 'prediksi bobot'])) {
            return $this->handlePredictionRequest($text, $original);
        }

        // Handle feed planning and formulation requests
        if ($this->containsAny($text, ['formulasi pakan', 'kebutuhan pakan', 'rekomendasi pakan', 'hitung pakan', 'perencanaan pakan', 'rencana pakan', 'planning pakan'])) {
            return $this->handleFeedPlanningRequest($text, $original);
        }

        // Handle pen-based feed planning
        if ($this->containsAny($text, ['pakan kandang', 'pakan berdasarkan kandang', 'formulasi kandang'])) {
            return $this->handlePenBasedFeedRequest($text);
        }

        // Handle specific questions first
        if ($this->containsAny($text, ['total kandang', 'jumlah kandang', 'berapa kandang'])) {
            return $this->handlePenCountRequest();
        }

        if ($this->containsAny($text, ['total ternak', 'jumlah ternak', 'berapa ternak'])) {
            return $this->handleLivestockCountRequest();
        }

        if ($this->containsAny($text, ['tag ternak', 'ternak di kandang', 'kandang melahirkan', 'kandang pemeliharaan', 'kandang karantina'])) {
            return $this->handlePenLivestockRequest($text);
        }

        if ($this->containsAny($text, ['stok pakan', 'persediaan pakan', 'total ternak', 'jumlah ternak', 'kandang', 'riwayat prediksi', 'history prediksi'])) {
            return $this->handleSummaryRequest($text);
        }

        if ($this->containsAny($text, ['apa itu', 'informasi aplikasi', 'cara pakai', 'bagaimana cara', 'input', 'isian', 'kemudahan', 'mudah'])) {
            return $this->handleAppInfoRequest($text);
        }

        return $this->defaultResponse($text);
    }

    protected function containsAny(string $text, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (strpos($text, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    protected function handlePredictionRequest(string $text, string $original): string
    {
        $livestockId = $this->extractLivestockId($text);
        $predictionDays = $this->extractDays($text) ?? 30; // Default to 30 days

        // If no livestock ID found, try to provide helpful guidance
        if ($livestockId === null) {
            // Check if they want a general prediction guide
            if ($this->containsAny($text, ['cara', 'bagaimana', 'panduan', 'kemudahan', 'mudah'])) {
                return $this->handlePredictionGuide();
            }

            // Check if they want to see available livestock
            if ($this->containsAny($text, ['lihat ternak', 'daftar ternak', 'ternak apa saja'])) {
                return $this->handleAvailableLivestock();
            }

            return 'Untuk melakukan prediksi pertumbuhan bobot, saya memerlukan ID ternak. ' .
                   'Anda bisa: ' . "\n" .
                   '• Katakan "lihat ternak" untuk melihat daftar ternak yang tersedia' . "\n" .
                   '• Gunakan format: "prediksi T001" atau "prediksi ternak 12"' . "\n" .
                   '• Tambahkan hari: "prediksi T001 selama 30 hari"';
        }

        $payload = ['livestock_id' => $livestockId, 'prediction_days' => $predictionDays];
        $response = $this->api->createPrediction($payload);

        if (!is_array($response) || ($response['success'] ?? false) === false) {
            $message = $response['message'] ?? 'Server tidak merespons. Pastikan ID ternak dan hari prediksi sudah benar.';
            return "Maaf, saya tidak dapat membuat prediksi saat ini. {$message}

🔍 **Status Sistem Prediksi:**
• Frontend → Backend: " . ($this->checkBackendConnection() ? "✅ Terhubung" : "❌ Tidak terhubung") . "
• Backend → ML Service: " . ($this->checkMLServiceConnection() ? "✅ Terhubung" : "❌ Tidak terhubung") . "
• Pastikan semua service berjalan:
  - Frontend: http://localhost:8001
  - Backend: http://localhost:8000
  - ML Service: http://localhost:8002

💡 **Untuk memulai semua service sekaligus:**
   Jalankan file `setup-and-run.bat` di folder utama project.";
        }

        $data = $response['data'] ?? $response;
        $result = $data['prediction_result'] ?? $data;

        if (!is_array($result) || empty($result)) {
            return 'Prediksi berhasil, tetapi data hasil belum lengkap. Silakan coba lagi atau gunakan fitur prediksi langsung di halaman Prediksi.';
        }

        $lines = [];
        $lines[] = "✅ Prediksi bobot untuk ternak ID {$livestockId} dalam {$predictionDays} hari:";

        if (isset($result['current_weight'])) {
            $lines[] = "- Berat awal: {$this->formatNumber($result['current_weight'])} kg.";
        }

        if (isset($result['predicted_gain'])) {
            $lines[] = "- Estimasi kenaikan bobot: {$this->formatNumber($result['predicted_gain'])} kg.";
        }

        if (isset($result['predicted_weight'])) {
            $lines[] = "- Berat akhir diperkirakan: {$this->formatNumber($result['predicted_weight'])} kg.";
        }

        if (isset($result['target_weight'])) {
            $lines[] = "- Target berat: {$this->formatNumber($result['target_weight'])} kg.";
        }

        if (count($lines) === 1) {
            $lines[] = 'Prediksi berhasil, tetapi detail hasil belum tersedia. Silakan lihat halaman Prediksi untuk informasi lengkap.';
        }

        $lines[] = 'Tip profesional: pastikan data berat aktual, jenis pakan, dan kondisi kandang diisi dengan benar agar prediksi lebih akurat.';

        return implode("\n", $lines);
    }

    protected function handleFeedRequest(string $text, string $original): string
    {
        $weight = $this->extractWeight($text);
        $targetGrowth = $this->extractPbbh($text);

        if ($weight === null && $targetGrowth === null) {
            $template = "Silakan beri informasi berat dan target pertumbuhan. Contoh: \"formulasi pakan berat 35 target 0.2\" atau \"kebutuhan pakan untuk berat 40 kg dengan target 0.25\".";
            return $template;
        }

        $recommendation = $this->api->getFeedRequirements();
        if (is_array($recommendation) && ($recommendation['success'] ?? true) && !empty($recommendation['data'])) {
            $feedText = $this->formatFeedRequirements($recommendation['data']);
            if ($feedText !== null) {
                return $feedText;
            }
        }

        $dailyDryMatter = $this->calculateDryMatterIntake($weight);
        $dailyTotalFeed = $dailyDryMatter * 1.4;
        $lines = [
            '✅ Rekomendasi formulasi pakan (aproksimasi profesional):',
        ];

        if ($weight !== null) {
            $lines[] = "- Berat domba saat ini: {$this->formatNumber($weight)} kg.";
            $lines[] = "- Asupan pakan kasar yang direkomendasikan: sekitar {$this->formatNumber($dailyTotalFeed)} kg per hari (berdasarkan 2,5% berat badan).";
        }

        if ($targetGrowth !== null) {
            $lines[] = "- Target kenaikan bobot: {$this->formatNumber($targetGrowth)} kg/hari.";
        }

        $lines[] = 'Perkiraan komposisi pakan rekomendasi:';
        $lines[] = '- Hijauan: 55% dari total pakan.';
        $lines[] = '- Konsentrat/konsentrat campuran: 35% dari total pakan.';
        $lines[] = '- Mineral dan suplemen: 10% (jika tersedia).';
        $lines[] = 'Saran lanjutan: gunakan data stok pakan yang tersedia dan sesuaikan perbandingan dengan jenis pakan lokal yang ada.';

        return implode("\n", $lines);
    }

    protected function handleSummaryRequest(string $text): string
    {
        $overview = $this->api->getDashboardOverview();
        $feedStock = $this->api->getFeedStock();
        $history = $this->api->getPredictionHistory(['per_page' => 3]);

        $lines = ['📊 Ringkasan informasi aplikasi TernakPark:'];

        if (is_array($overview) && ($overview['success'] ?? true) && !empty($overview['data'])) {
            $data = $overview['data'];
            if (isset($data['livestock_count'])) {
                $lines[] = "- Total ternak: {$data['livestock_count']} ekor.";
            }
            if (isset($data['pen_count'])) {
                $lines[] = "- Total kandang: {$data['pen_count']} unit.";
            }
            if (isset($data['feed_stock_total'])) {
                $lines[] = "- Total stok pakan: {$data['feed_stock_total']} kg.";
            }
        }

        if (is_array($feedStock) && ($feedStock['success'] ?? true) && !empty($feedStock['data'])) {
            $feedSummary = $this->formatFeedStockSummary($feedStock['data']);
            if ($feedSummary !== 'Stok pakan saat ini tidak tersedia dalam format ringkas.') {
                $lines[] = $feedSummary;
            }
        }

        if (is_array($history) && ($history['success'] ?? true) && !empty($history['data']['predictions'])) {
            $lines[] = 'Riwayat 3 prediksi terbaru:';
            foreach ($history['data']['predictions'] as $prediction) {
                $label = $prediction['livestock_name'] ?? ($prediction['livestock_id'] ?? 'ID tidak tersedia');
                $gain = $prediction['predicted_gain'] ?? ($prediction['gain'] ?? 'n/a');
                $lines[] = "- {$label}: kenaikan sekitar {$this->formatNumber($gain)} kg.";
            }
        }

        if (count($lines) === 1) {
            return 'Saya tidak bisa mengambil data ringkasan saat ini. Pastikan backend TernakPark tersedia dan coba lagi.';
        }

        return implode("\n", $lines);
    }

    protected function handlePenCountRequest(): string
    {
        $overview = $this->api->getDashboardOverview();

        if (is_array($overview) && ($overview['success'] ?? true) && !empty($overview['data'])) {
            $data = $overview['data'];
            $penCount = $data['pen_count'] ?? null;

            if ($penCount !== null) {
                return "🏠 Total kandang saat ini: {$penCount} unit.";
            }
        }

        // Fallback: get pens data with active status filter (same as frontend)
        $pensResponse = $this->api->getPens(['status' => 'active']);
        if (is_array($pensResponse) && ($pensResponse['success'] ?? true)) {
            // If response has stats, use it
            if (isset($pensResponse['data']['stats']['total_pens'])) {
                $penCount = $pensResponse['data']['stats']['total_pens'];
                return "🏠 Total kandang saat ini: {$penCount} unit.";
            }
            // If response has pens array, count it
            elseif (isset($pensResponse['data']['pens']) && is_array($pensResponse['data']['pens'])) {
                $penCount = count($pensResponse['data']['pens']);
                return "🏠 Total kandang saat ini: {$penCount} unit.";
            }
            // If data is direct array, count it
            elseif (isset($pensResponse['data']) && is_array($pensResponse['data'])) {
                $penCount = count($pensResponse['data']);
                return "🏠 Total kandang saat ini: {$penCount} unit.";
            }
        }

        return 'Maaf, saya tidak dapat mengambil data jumlah kandang saat ini. Pastikan backend TernakPark tersedia.';
    }

    protected function handleLivestockCountRequest(): string
    {
        $overview = $this->api->getDashboardOverview();

        if (is_array($overview) && ($overview['success'] ?? true) && !empty($overview['data'])) {
            $data = $overview['data'];
            $livestockCount = $data['livestock_count'] ?? null;

            if ($livestockCount !== null) {
                return "🐑 Total ternak saat ini: {$livestockCount} ekor.";
            }
        }

        // Fallback: get livestocks data without status filter (same as frontend)
        $livestocksResponse = $this->api->getLivestocks();
        if (is_array($livestocksResponse) && ($livestocksResponse['success'] ?? true)) {
            // If response has stats, use it
            if (isset($livestocksResponse['data']['stats']['total_livestock'])) {
                $livestockCount = $livestocksResponse['data']['stats']['total_livestock'];
                return "🐑 Total ternak saat ini: {$livestockCount} ekor.";
            }
            // If response has livestocks array, count it
            elseif (isset($livestocksResponse['data']['livestocks']) && is_array($livestocksResponse['data']['livestocks'])) {
                $livestockCount = count($livestocksResponse['data']['livestocks']);
                return "🐑 Total ternak saat ini: {$livestockCount} ekor.";
            }
            // If data is direct array, count it
            elseif (isset($livestocksResponse['data']) && is_array($livestocksResponse['data'])) {
                $livestockCount = count($livestocksResponse['data']);
                return "🐑 Total ternak saat ini: {$livestockCount} ekor.";
            }
        }

        return 'Maaf, saya tidak dapat mengambil data jumlah ternak saat ini. Pastikan backend TernakPark tersedia.';
    }

    protected function handlePenLivestockRequest(string $text): string
    {
        // Extract pen type or name from text
        $penType = null;
        if (strpos($text, 'melahirkan') !== false) {
            $penType = 'melahirkan';
        } elseif (strpos($text, 'pemeliharaan') !== false) {
            $penType = 'pemeliharaan';
        } elseif (strpos($text, 'karantina') !== false) {
            $penType = 'karantina';
        }

        $pens = $this->api->getPens(['status' => 'active']);
        if (!is_array($pens) || ($pens['success'] ?? false) === false || empty($pens['data'])) {
            return 'Maaf, saya tidak dapat mengambil data kandang saat ini. Pastikan backend TernakPark tersedia.';
        }

        $matchingPens = [];
        $pensArray = isset($pens['data']['pens']) ? $pens['data']['pens'] : (is_array($pens['data']) ? $pens['data'] : []);
        foreach ($pensArray as $pen) {
            $penName = strtolower($pen['name'] ?? '');
            if ($penType && strpos($penName, $penType) !== false) {
                $matchingPens[] = $pen;
            }
        }

        if (empty($matchingPens)) {
            return "Tidak ditemukan kandang dengan jenis '{$penType}'. Kandang yang tersedia: " . implode(', ', array_map(function($p) { return $p['name'] ?? 'N/A'; }, array_slice($pens['data'], 0, 5)));
        }

        $lines = ["🏠 Ternak di kandang {$penType}:"];
        foreach ($matchingPens as $pen) {
            $penId = $pen['id'];
            $penName = $pen['name'] ?? 'N/A';

            // Get livestocks in this pen
            $livestocks = $this->api->getLivestocks(['pen_id' => $penId, 'status' => 'active']);
            if (is_array($livestocks) && ($livestocks['success'] ?? true)) {
                $livestockArray = isset($livestocks['data']['livestocks']) ? $livestocks['data']['livestocks'] : (is_array($livestocks['data']) ? $livestocks['data'] : []);
                $tags = array_map(function($l) { return $l['tag'] ?? $l['id']; }, $livestockArray);
                $lines[] = "- {$penName}: " . implode(', ', $tags);
            } else {
                $lines[] = "- {$penName}: Tidak ada ternak";
            }
        }

        return implode("\n", $lines);
    }

    protected function checkBackendConnection(): bool
    {
        try {
            $response = $this->api->request('get', '/health', []);
            return is_array($response) && ($response['success'] ?? false);
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function checkMLServiceConnection(): bool
    {
        try {
            // Try to call backend's ML service check
            $response = $this->api->request('get', '/test', []);
            return is_array($response) && ($response['success'] ?? false);
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function handlePredictionGuide(): string
    {
        $lines = [
            '🎯 Panduan Prediksi Pertumbuhan Bobot Domba (Mudah & Cepat):',
            '',
            '📋 Langkah-langkah:',
            '1. Pilih ternak yang ingin diprediksi',
            '2. Tentukan periode prediksi (default: 30 hari)',
            '3. Sistem akan menghitung pertumbuhan berdasarkan data historis',
            '',
            '💡 Contoh penggunaan:',
            '• "prediksi T001" - prediksi 30 hari untuk ternak T001',
            '• "prediksi ternak 12 selama 45 hari" - prediksi 45 hari',
            '• "lihat ternak" - lihat daftar ternak yang tersedia',
            '',
            '📊 Faktor yang mempengaruhi prediksi:',
            '• Berat badan saat ini',
            '• Usia dan jenis kelamin',
            '• Riwayat pertumbuhan sebelumnya',
            '• Kondisi kesehatan',
            '• Jenis pakan yang diberikan',
            '',
            '💡 Tips untuk hasil akurat:',
            '• Pastikan data berat badan selalu diupdate',
            '• Catat perubahan pakan secara konsisten',
            '• Lakukan pemeriksaan kesehatan rutin',
            '',
            '🚀 Coba sekarang: "lihat ternak" untuk memulai!'
        ];

        return implode("\n", $lines);
    }

    protected function handleAvailableLivestock(): string
    {
        $livestocksResponse = $this->api->getLivestocks();

        if (!is_array($livestocksResponse) || ($livestocksResponse['success'] ?? true) === false) {
            return 'Maaf, tidak dapat mengambil data ternak saat ini. Pastikan backend TernakPark tersedia.';
        }

        $livestocks = isset($livestocksResponse['data']['livestocks'])
            ? $livestocksResponse['data']['livestocks']
            : (is_array($livestocksResponse['data']) ? $livestocksResponse['data'] : []);

        if (empty($livestocks)) {
            return 'Tidak ada data ternak yang tersedia saat ini.';
        }

        $lines = ['🐑 Daftar Ternak yang Tersedia untuk Prediksi:'];
        $lines[] = '';

        foreach (array_slice($livestocks, 0, 10) as $livestock) {
            $id = $livestock['ear_tag'] ?? $livestock['id'] ?? 'N/A';
            $breed = $livestock['breed_type'] ?? 'N/A';
            $weight = $livestock['current_weight'] ?? 'N/A';
            $pen = $livestock['pen']['name'] ?? 'N/A';

            $lines[] = "• ID: {$id} | Ras: {$breed} | Berat: {$weight}kg | Kandang: {$pen}";
        }

        if (count($livestocks) > 10) {
            $lines[] = '';
            $lines[] = "📋 Menampilkan 10 dari " . count($livestocks) . " ternak total.";
        }

        $lines[] = '';
        $lines[] = '💡 Untuk prediksi: "prediksi [ID]" (contoh: "prediksi T001")';

        return implode("\n", $lines);
    }

    protected function handleFeedPlanningRequest(string $text, string $original): string
    {
        $weight = $this->extractWeight($text);
        $targetGrowth = $this->extractPbbh($text);
        $penType = $this->extractPenType($text);

        // If they want general feed planning guide
        if ($this->containsAny($text, ['cara', 'bagaimana', 'panduan', 'kemudahan', 'mudah'])) {
            return $this->handleFeedPlanningGuide();
        }

        // If they mention pen type, provide pen-based planning
        if ($penType) {
            return $this->handlePenBasedFeedRequest($text);
        }

        // If no specific parameters, provide general guidance
        if ($weight === null && $targetGrowth === null) {
            return $this->handleFeedPlanningGuide();
        }

        // Calculate feed requirements based on weight and target
        return $this->calculateDetailedFeedPlan($weight, $targetGrowth);
    }

    protected function handleFeedPlanningGuide(): string
    {
        $lines = [
            '🌾 Panduan Perencanaan Pakan Domba (Komprehensif):',
            '',
            '📋 Cara Mudah Merencanakan Pakan:',
            '',
            '1️⃣ Berdasarkan Berat & Target Pertumbuhan:',
            '• "formulasi pakan berat 35 target 0.2"',
            '• "kebutuhan pakan 40kg dengan target 0.25"',
            '',
            '2️⃣ Berdasarkan Jenis Kandang:',
            '• "pakan kandang melahirkan"',
            '• "formulasi kandang pemeliharaan"',
            '• "rencana pakan karantina"',
            '',
            '3️⃣ Berdasarkan Stok yang Tersedia:',
            '• "stok pakan" - lihat ketersediaan',
            '• "rekomendasi pakan" - saran umum',
            '',
            '📊 Komposisi Pakan Optimal:',
            '• Hijauan: 55-60% (rumput, legum)',
            '• Konsentrat: 30-35% (dedak, jagung)',
            '• Mineral/Suplemen: 5-10% (kapur, garam)',
            '• Vitamin: 2-5% (premix vitamin)',
            '',
            '⚖️ Perhitungan Kebutuhan Harian:',
            '• Pakan kasar: 2.5-3% dari berat badan',
            '• Protein: 12-16% untuk pertumbuhan',
            '• Energi: 2.5-3.0 Mkal/kg untuk maintenance',
            '',
            '💡 Tips Perencanaan:',
            '• Sesuaikan dengan musim dan ketersediaan lokal',
            '• Monitor konsumsi dan penyesuaian berat badan',
            '• Pastikan kualitas pakan tetap terjaga',
            '• Kombinasikan beberapa jenis pakan untuk nutrisi lengkap',
            '',
            '🚀 Coba sekarang: "formulasi pakan berat 35 target 0.2"'
        ];

        return implode("\n", $lines);
    }

    protected function handlePenBasedFeedRequest(string $text): string
    {
        $penType = $this->extractPenType($text);

        if (!$penType) {
            return 'Silakan sebutkan jenis kandang. Contoh: "pakan kandang melahirkan", "formulasi kandang pemeliharaan".';
        }

        // Get available feeds
        $feedsResponse = $this->api->getFeeds();
        $feedStock = $this->api->getFeedStock();

        $lines = ["🌾 Rekomendasi Pakan untuk Kandang {$penType}:"];
        $lines[] = '';

        // Pen-specific recommendations
        switch (strtolower($penType)) {
            case 'melahirkan':
                $lines[] = '👶 Kebutuhan khusus untuk induk hamil/menyusui:';
                $lines[] = '• Protein tinggi: 14-16% (untuk perkembangan janin)';
                $lines[] = '• Energi tinggi: 2.8-3.2 Mkal/kg';
                $lines[] = '• Kalsium/Fosfor: 0.8-1.0% (untuk tulang janin)';
                $lines[] = '• Vitamin A,D,E: Tinggi untuk reproduksi';
                $lines[] = '';
                $lines[] = '📋 Rekomendasi formulasi:';
                $lines[] = '• Legum (kacang-kacangan): 40%';
                $lines[] = '• Dedak halus: 25%';
                $lines[] = '• Jagung giling: 20%';
                $lines[] = '• Mineral premix: 10%';
                $lines[] = '• Molases: 5%';
                break;

            case 'pemeliharaan':
                $lines[] = '🐑 Kebutuhan untuk domba pemeliharaan normal:';
                $lines[] = '• Protein sedang: 12-14%';
                $lines[] = '• Energi maintenance: 2.5-2.8 Mkal/kg';
                $lines[] = '• Serat: 18-22% (untuk kesehatan pencernaan)';
                $lines[] = '';
                $lines[] = '📋 Rekomendasi formulasi:';
                $lines[] = '• Rumput kering: 50%';
                $lines[] = '• Jerami: 20%';
                $lines[] = '• Konsentrat campuran: 25%';
                $lines[] = '• Mineral blok: 5%';
                break;

            case 'karantina':
                $lines[] = '⚠️ Kebutuhan untuk domba karantina/pengobatan:';
                $lines[] = '• Pakan mudah dicerna, rendah serat';
                $lines[] = '• Protein tinggi untuk pemulihan: 14-15%';
                $lines[] = '• Vitamin C dan antioksidan tinggi';
                $lines[] = '• Antibiotik/Suplemen kesehatan jika diperlukan';
                $lines[] = '';
                $lines[] = '📋 Rekomendasi formulasi:';
                $lines[] = '• Dedak halus: 40%';
                $lines[] = '• Jagung giling: 30%';
                $lines[] = '• Tepung ikan/udang: 15%';
                $lines[] = '• Premix vitamin: 10%';
                $lines[] = '• Molases: 5%';
                break;

            default:
                $lines[] = 'Jenis kandang tidak dikenali. Pilih dari: melahirkan, pemeliharaan, karantina.';
                return implode("\n", $lines);
        }

        // Add available feed information
        if (is_array($feedStock) && ($feedStock['success'] ?? true) && !empty($feedStock['data'])) {
            $lines[] = '';
            $lines[] = '📦 Stok pakan yang tersedia:';
            $stockData = $feedStock['data'];

            if (isset($stockData['feeds']) && is_array($stockData['feeds'])) {
                foreach (array_slice($stockData['feeds'], 0, 5) as $feed) {
                    $name = $feed['name'] ?? 'N/A';
                    $stock = $feed['current_stock'] ?? 0;
                    $unit = $feed['unit'] ?? 'kg';
                    $lines[] = "• {$name}: {$stock} {$unit}";
                }
            }
        }

        $lines[] = '';
        $lines[] = '💡 Tips: Sesuaikan formulasi dengan stok yang tersedia dan kondisi ternak.';

        return implode("\n", $lines);
    }

    protected function calculateDetailedFeedPlan(?float $weight, ?float $targetGrowth): string
    {
        if ($weight === null) {
            return 'Silakan sebutkan berat domba. Contoh: "formulasi pakan berat 35kg target 0.2"';
        }

        $lines = ['🌾 Rencana Pakan Terperinci:'];
        $lines[] = '';

        // Daily requirements calculation
        $dailyDryMatter = $this->calculateDryMatterIntake($weight);
        $dailyTotalFeed = $dailyDryMatter * 1.4; // Convert to as-fed basis

        $lines[] = "⚖️ Berdasarkan berat: {$this->formatNumber($weight)} kg";
        if ($targetGrowth !== null) {
            $lines[] = "🎯 Target pertumbuhan: {$this->formatNumber($targetGrowth)} kg/hari";
        }
        $lines[] = '';

        $lines[] = '📊 Kebutuhan Harian:';
        $lines[] = "• Bahan kering (DM): {$this->formatNumber($dailyDryMatter)} kg";
        $lines[] = "• Total pakan: {$this->formatNumber($dailyTotalFeed)} kg (as-fed)";
        $lines[] = '';

        // Feed composition based on target
        $lines[] = '🥕 Komposisi Pakan yang Direkomendasikan:';

        if ($targetGrowth !== null && $targetGrowth > 0.15) {
            // High growth target - more concentrate
            $lines[] = '• Hijauan: 45%';
            $lines[] = '• Konsentrat: 40%';
            $lines[] = '• Mineral/Vitamin: 15%';
            $lines[] = '';
            $lines[] = '💡 Rekomendasi jenis pakan:';
            $lines[] = '• Hijauan: Legum (kacang tanah, kaliandra)';
            $lines[] = '• Konsentrat: Jagung giling, dedak, bungkil kedelai';
            $lines[] = '• Suplemen: Mineral premix, vitamin A,D,E';
        } else {
            // Maintenance or low growth
            $lines[] = '• Hijauan: 60%';
            $lines[] = '• Konsentrat: 30%';
            $lines[] = '• Mineral/Vitamin: 10%';
            $lines[] = '';
            $lines[] = '💡 Rekomendasi jenis pakan:';
            $lines[] = '• Hijauan: Rumput gajah, rumput raja';
            $lines[] = '• Konsentrat: Dedak, pollard';
            $lines[] = '• Suplemen: Garam mineral, kapur';
        }

        $lines[] = '';
        $lines[] = '📅 Perencanaan Mingguan:';
        $lines[] = "• Senin-Kamis: Fokus hijauan + konsentrat";
        $lines[] = "• Jumat-Minggu: Tambah mineral/vitamin";
        $lines[] = "• Monitor: Berat badan setiap 3-4 hari";

        return implode("\n", $lines);
    }

    protected function extractPenType(string $text): ?string
    {
        $penTypes = ['melahirkan', 'pemeliharaan', 'karantina', 'penggemukan'];

        foreach ($penTypes as $type) {
            if (strpos($text, $type) !== false) {
                return $type;
            }
        }

        return null;
    }

    protected function handleAppInfoRequest(string $text): string
    {
        if ($this->containsAny($text, ['kemudahan', 'mudah', 'panduan lengkap'])) {
            return '🎯 TernakPark AI Assistant - Panduan Lengkap:

📊 FITUR UTAMA:
• Prediksi pertumbuhan bobot 30 hari ke depan
• Perencanaan pakan berdasarkan jenis kandang
• Formulasi pakan dengan target PBBH spesifik
• Monitoring stok pakan real-time
• Analisis data ternak dan kandang

🚀 CARA MUDAH PREDIKSI:
1. "lihat ternak" → Pilih ID ternak
2. "prediksi [ID] selama 30 hari" → Dapatkan hasil
3. Sistem otomatis menghitung berdasarkan data historis

🌾 CARA MUDAH PERENCANAAN PAKAN:
1. "formulasi pakan berat 35 target 0.2" → Rencana harian
2. "pakan kandang melahirkan" → Rekomendasi khusus kandang
3. "stok pakan" → Cek ketersediaan

📋 CONTOH PENGGUNAAN:
• "prediksi T001" - Prediksi cepat
• "formulasi pakan berat 40kg target 0.25" - Perencanaan detail
• "pakan kandang pemeliharaan" - Berdasarkan jenis kandang
• "lihat ternak" - Eksplorasi data
• "stok pakan hari ini" - Monitoring persediaan

💡 TIPS PROFESIONAL:
• Update data berat badan secara berkala
• Sesuaikan pakan dengan musim dan ketersediaan
• Monitor respons ternak terhadap formulasi
• Kombinasikan data prediksi dengan kondisi aktual

🔧 INPUT PENTING UNTUK AKURASI:
• Berat badan aktual (kg)
• Target pertumbuhan harian (kg/hari)
• Jenis pakan yang digunakan
• Kondisi kesehatan ternak
• Jenis kandang (melahirkan/pemeliharaan/karantina)

Saya siap membantu Anda mengoptimalkan pengelolaan ternak dengan data-driven decisions! 🐑✨';
        }

        return 'TernakPark adalah aplikasi manajemen ternak dan pakan. Fitur utama meliputi: 1) pencatatan ternak dan berat, 2) manajemen kandang, 3) stok pakan, 4) prediksi pertumbuhan bobot, 5) rekomendasi formulasi pakan. Isian data penting: berat aktual, umur, jenis pakan, ID ternak, kondisi kandang, dan target PBBH. Semua informasi digunakan untuk menghasilkan prediksi dan rekomendasi yang lebih akurat.';
    }

    protected function defaultResponse(string $text): string
    {
        return 'Maaf, saya belum memahami pertanyaan ini secara lengkap. Saya bisa membantu dengan:

🎯 PREDIKSI PERTUMBUHAN:
• "lihat ternak" - Lihat daftar ternak tersedia
• "prediksi T001" - Prediksi 30 hari untuk ternak T001
• "prediksi T001 selama 45 hari" - Prediksi custom

🌾 PERENCANAAN PAKAN:
• "formulasi pakan berat 35 target 0.2" - Berdasarkan berat & target
• "pakan kandang melahirkan" - Rekomendasi khusus kandang
• "stok pakan" - Cek ketersediaan pakan

📊 INFORMASI APLIKASI:
• "kemudahan" - Panduan lengkap fitur
• "total ternak" - Jumlah ternak saat ini
• "total kandang" - Jumlah kandang aktif

💡 Contoh: "prediksi T001", "formulasi pakan berat 35 target 0.2", atau "pakan kandang pemeliharaan".';
    }

    protected function extractLivestockId(string $text): ?int
    {
        if (preg_match('/\b(?:t|ternak|id)\s*0*(\d{1,5})\b/i', $text, $matches)) {
            return (int)$matches[1];
        }

        $skipKeywords = ['kg', 'hari', 'days', 'target', 'pbbh', 'berat', 'pakan', 'formulasi'];
        foreach ($skipKeywords as $keyword) {
            if (strpos($text, $keyword) !== false) {
                return null;
            }
        }

        if (preg_match('/\b(\d{1,5})\b/', $text, $matches)) {
            return (int)$matches[1];
        }

        return null;
    }

    protected function extractDays(string $text): ?int
    {
        if (preg_match('/(\d{1,3})\s*(hari|days|h)/i', $text, $matches)) {
            return (int)$matches[1];
        }

        if (preg_match('/selama\s*(\d{1,3})\b/i', $text, $matches)) {
            return (int)$matches[1];
        }

        return null;
    }

    protected function extractWeight(string $text): ?float
    {
        if (preg_match('/berat\s*[=:\-]?\s*([0-9]+(?:\.[0-9]+)?)\s*kg?/i', $text, $matches)) {
            return (float)$matches[1];
        }

        if (preg_match('/([0-9]+(?:\.[0-9]+)?)\s*kg\b/i', $text, $matches)) {
            return (float)$matches[1];
        }

        return null;
    }

    protected function extractPbbh(string $text): ?float
    {
        if (preg_match('/target\s*[=:\-]?\s*([0-9]+(?:\.[0-9]+)?)\s*(kg\s*per\s*hari|kg\/hari|kg\/h|pbbh)?/i', $text, $matches)) {
            return (float)$matches[1];
        }

        if (preg_match('/pbbh\s*[=:\-]?\s*([0-9]+(?:\.[0-9]+)?)/i', $text, $matches)) {
            return (float)$matches[1];
        }

        return null;
    }

    protected function formatNumber($value): string
    {
        if ($value === null || $value === '') {
            return 'n/a';
        }

        return number_format((float)$value, 2, ',', '.');
    }

    protected function calculateDryMatterIntake(?float $weight): float
    {
        if ($weight === null || $weight <= 0) {
            return 1.0;
        }

        return round($weight * 0.03, 3);
    }

    protected function formatFeedRequirements(array $data): ?string
    {
        if (isset($data['recommendations']) && is_array($data['recommendations'])) {
            $lines = ['✅ Rekomendasi formulasi pakan berdasarkan data sistem:'];
            foreach ($data['recommendations'] as $item) {
                $name = $item['name'] ?? $item['feed_name'] ?? 'Pakan';
                $qty = $item['quantity'] ?? $item['amount'] ?? null;
                if ($qty !== null) {
                    $lines[] = "- {$name}: {$this->formatNumber($qty)} kg/hari";
                } else {
                    $lines[] = "- {$name}";
                }
            }
            return implode("\n", $lines);
        }

        return null;
    }

    protected function formatFeedStockSummary(array $data): string
    {
        if (isset($data['feeds']) && is_array($data['feeds'])) {
            $lines = ['Stok pakan saat ini:'];
            foreach (array_slice($data['feeds'], 0, 3) as $feed) {
                $name = $feed['name'] ?? $feed['feed_name'] ?? 'Pakan';
                $stock = $feed['stock'] ?? $feed['quantity'] ?? null;
                if ($stock !== null) {
                    $lines[] = "- {$name}: {$this->formatNumber($stock)} kg";
                }
            }
            return implode("\n", $lines);
        }

        if (isset($data['stock']) && is_array($data['stock'])) {
            $lines = ['Stok pakan saat ini:'];
            foreach (array_slice($data['stock'], 0, 3) as $feed) {
                $name = $feed['name'] ?? 'Pakan';
                $stock = $feed['quantity'] ?? null;
                if ($stock !== null) {
                    $lines[] = "- {$name}: {$this->formatNumber($stock)} kg";
                }
            }
            return implode("\n", $lines);
        }

        if (isset($data['total_stock'])) {
            return "Total stok pakan: {$this->formatNumber($data['total_stock'])} kg.";
        }

        return 'Stok pakan saat ini tidak tersedia dalam format ringkas.';
    }
}
