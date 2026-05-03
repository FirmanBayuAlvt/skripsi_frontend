<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BackendApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
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
     * Menampilkan halaman utama Fattening Domba.
     *
     * @return \Illuminate\View\View
     */
    public function fattening()
    {
        return view('program.fattening');
    }

    /**
     * Menampilkan halaman detail per ternak untuk modul Fattening.
     *
     * @return \Illuminate\View\View
     */
    public function fatteningDetail()
    {
        return view('program.fattening-detail');
    }

    /**
     * Menampilkan halaman data timbang untuk modul Fattening.
     *
     * @return \Illuminate\View\View
     */
    public function fatteningTimbang()
    {
        return view('program.fattening-timbang');
    }

    /**
     * Menampilkan halaman analisis ADG & FCR untuk modul Fattening.
     *
     * @return \Illuminate\View\View
     */
    public function fatteningAdgFcr()
    {
        return view('program.fattening-adg-fcr');
    }

    /**
     * Menampilkan halaman utama Breeding Domba.
     *
     * @return \Illuminate\View\View
     */
    public function breeding()
    {
        return view('program.breeding');
    }

    /**
     * Menampilkan halaman data Indukan untuk modul Breeding.
     *
     * @return \Illuminate\View\View
     */
    public function breedingIndukan()
    {
        return view('program.breeding-indukan');
    }

    /**
     * Menampilkan halaman data Pejantan untuk modul Breeding.
     *
     * @return \Illuminate\View\View
     */
    public function breedingPejantan()
    {
        return view('program.breeding-pejantan');
    }

    /**
     * Menampilkan halaman data Anakan untuk modul Breeding.
     *
     * @return \Illuminate\View\View
     */
    public function breedingAnakan()
    {
        return view('program.breeding-anakan');
    }

    /**
     * Menampilkan halaman Data Kawin & IB untuk modul Breeding.
     *
     * @return \Illuminate\View\View
     */
    public function breedingKawinIb()
    {
        return view('program.breeding-kawin-ib');
    }

    /**
     * Mengambil data ringkasan fattening dari backend.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFatteningData()
    {
        try {
            $result = $this->api->getFatteningData();
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching fattening data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data fattening'
            ], 500);
        }
    }

    /**
     * Mengambil data fattening lengkap (detail tabel dan statistik) dari backend.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFatteningDetailedData()
    {
        try {
            $result = $this->api->getFatteningDetailed();
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching fattening detailed data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data fattening lengkap'
            ], 500);
        }
    }

    /**
     * Mengambil data timbang fattening dengan filter tagging, jenis, dan kategori kandang.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFatteningTimbangData(Request $request)
    {
        try {
            $parameters = [
                'tagging'  => $request->query('tagging', ''),
                'jenis'    => $request->query('jenis', ''),
                'kategori' => $request->query('kategori', '')
            ];
            $result = $this->api->getFatteningTimbangData($parameters);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching fattening timbang data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data timbang fattening'
            ], 500);
        }
    }

    /**
     * Mengambil data ADG & FCR fattening dengan filter tanggal awal dan akhir.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFatteningAdgFcrData(Request $request)
    {
        try {
            $parameters = [
                'start_date' => $request->query('start_date', ''),
                'end_date'   => $request->query('end_date', '')
            ];
            $result = $this->api->getFatteningAdgFcrData($parameters);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching fattening ADG & FCR data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data ADG & FCR fattening'
            ], 500);
        }
    }

    /**
     * Mengambil data breeding dari backend.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBreedingData()
    {
        try {
            $result = $this->api->getBreedingData();

            // Jika backend mengembalikan redirect (401), kirim response 401
            if (isset($result['redirect']) && $result['redirect'] === true) {
                return response()->json($result, 401);
            }

            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching breeding data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data breeding: ' . $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil data keluarga ternak berdasarkan ear tag.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFamily(Request $request)
    {
        try {
            $earTag = $request->query('ear_tag');
            $result = $this->api->getFamily($earTag);
            return response()->json($result);
        } catch (\Exception $exception) {
            Log::error('Error fetching family data: ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data keluarga'
            ], 500);
        }
    }

    /**
     * Mengambil data induk betina (untuk tabel induk di halaman breeding)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBreedingIndukData(Request $request)
    {
        try {
            $result = $this->api->getBreedingIndukData($request->all());
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Error fetching breeding induk data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Mengambil data pejantan (untuk tabel jantan di halaman breeding)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBreedingJantanData(Request $request)
    {
        try {
            $result = $this->api->getBreedingJantanData($request->all());
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Error fetching breeding jantan data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Mengambil data anakan (untuk tabel anakan di halaman breeding)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBreedingAnakanData(Request $request)
    {
        try {
            $result = $this->api->getBreedingAnakanData($request->all());
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Error fetching breeding anakan data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Mengambil data indukan (alternatif, jika ada panggilan ke /breeding/indukan)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBreedingIndukanData(Request $request)
    {
        return $this->getBreedingIndukData($request);
    }

    /**
     * Mengambil data pejantan (alternatif)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBreedingPejantanData(Request $request)
    {
        return $this->getBreedingJantanData($request);
    }

    /**
     * Mengambil data kawin & IB
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBreedingKawinIbData(Request $request)
    {
        try {
            $result = $this->api->getBreedingKawinIbData($request->all());
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Error fetching breeding kawin-ib data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
