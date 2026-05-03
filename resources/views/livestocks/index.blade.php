@extends('layouts.app')

@section('title', 'Manajemen Ternak')
@section('header-title', 'Manajemen Ternak')

@section('page-header')
<div class="flex flex-wrap justify-between items-center gap-3">
    <div class="flex items-center gap-2">
        <div class="h-8 w-1 bg-gradient-to-b from-emerald-300 to-teal-500 rounded-full"></div>
        <p class="text-emerald-200 font-medium tracking-wide">DATA TERNAK</p>
    </div>
    <div class="flex gap-2">
        <button onclick="openAddModal()" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl flex items-center shadow-md transition-all transform hover:scale-[1.02]">
            <i class="fas fa-plus mr-2"></i> Tambah Ternak
        </button>
        <button onclick="openImportModal()" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-xl flex items-center shadow-md transition-all transform hover:scale-[1.02]">
            <i class="fas fa-file-excel mr-2"></i> Impor Excel
        </button>
        <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filter Section dengan Glassmorphism -->
    <div class="glass-card p-5">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-filter text-emerald-400"></i>
            <h3 class="font-bold text-white">Filter Data</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Kandang</label>
                <select id="pen-filter" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Memuat kandang...</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Status</label>
                <select id="status-filter" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Semua</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-300 text-sm font-medium mb-1">Jenis Ternak</label>
                <select id="breed-filter" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Semua</option>
                    <option value="domba_lokal">Domba Lokal</option>
                    <option value="domba_ekor_gemuk">Domba Ekor Gemuk</option>
                    <option value="domba_garut">Domba Garut</option>
                    <option value="domba_priangan">Domba Priangan</option>
                    <option value="domba_merino">Domba Merino</option>
                    <option value="domba_dorper">Domba Dorper</option>
                    <option value="domba_ekor_tipis">Domba Ekor Tipis</option>
                    <option value="batur">Batur</option>
                    <option value="crossbreed">Crossbreed</option>
                    <option value="crossbreed_deg_komposit">Crossbreed (DEG Komposit)</option>
                    <option value="kambing_jawa_randu">Kambing Jawa Randu</option>
                    <option value="silangan_deg_dorper">Silangan DEG-Dorper</option>
                    <option value="silangan_deg_garut">Silangan DEG-Garut</option>
                    <option value="silangan_deg_batur">Silangan DEG-Batur</option>
                    <option value="silangan_det_dorper">Silangan DET-Dorper</option>
                    <option value="silangan_det_garut">Silangan DET-Garut</option>
                    <option value="domba_dorper_f1">Domba Dorper F1</option>
                    <option value="domba_dorper_f2">Domba Dorper F2</option>
                </select>
            </div>
            <div class="flex items-end">
                <button onclick="applyFilters()" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl shadow-md transition">
                    <i class="fas fa-search mr-2"></i> Terapkan
                </button>
            </div>
        </div>
    </div>

    <!-- Tabel Utama dengan Glassmorphism -->
    <div class="glass-card p-0 overflow-hidden">
        <div class="flex items-center gap-2 border-b border-white/10 p-5">
            <i class="fas fa-table-list text-emerald-400 text-xl"></i>
            <h3 class="font-bold text-white text-lg">Daftar Ternak</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="custom-table w-full text-sm text-white">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Ear Tag</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Jenis</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kelamin</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kandang</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">BB (kg)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Umur (hari)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Kondisi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-300 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody id="livestock-table-body">
                    <tr>
                        <td colspan="10" class="text-center py-8 text-gray-400">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="pagination" class="p-5 border-t border-white/10 flex justify-between items-center"></div>
    </div>
</div>

<!-- ========== MODAL TAMBAH/EDIT TERNAK ========== -->
<div id="livestock-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="bg-black/40 backdrop-blur-md rounded-2xl p-6 max-w-4xl w-full z-10 max-h-[90vh] overflow-y-auto border border-white/20 shadow-2xl">
            <h3 id="modal-title" class="text-white text-xl font-bold mb-5">Tambah Ternak</h3>
            <form id="livestock-form" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit-id" name="id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Ear Tag *</label>
                        <input type="text" name="ear_tag" id="ear_tag" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Kandang *</label>
                        <select name="pen_id" id="pen_id" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent" onchange="onPenChange(this)">
                            <option value="">Pilih Kandang</option>
                        </select>
                    </div>
                </div>
                <div id="feed-info" class="hidden bg-emerald-900/40 border border-emerald-500/30 rounded-xl p-4">
                    <h4 class="font-medium text-emerald-200">Pakan yang Direkomendasikan untuk Kandang Ini</h4>
                    <div id="feed-list" class="mt-2 flex flex-wrap gap-2"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Jenis Ternak *</label>
                        <select name="breed_type" id="breed_type" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="domba_lokal">Domba Lokal</option>
                            <option value="domba_ekor_gemuk">Domba Ekor Gemuk</option>
                            <option value="domba_garut">Domba Garut</option>
                            <option value="domba_priangan">Domba Priangan</option>
                            <option value="domba_merino">Domba Merino</option>
                            <option value="domba_dorper">Domba Dorper</option>
                            <option value="domba_ekor_tipis">Domba Ekor Tipis</option>
                            <option value="batur">Batur</option>
                            <option value="crossbreed">Crossbreed</option>
                            <option value="crossbreed_deg_komposit">Crossbreed (DEG Komposit)</option>
                            <option value="kambing_jawa_randu">Kambing Jawa Randu</option>
                            <option value="silangan_deg_dorper">Silangan DEG-Dorper</option>
                            <option value="silangan_deg_garut">Silangan DEG-Garut</option>
                            <option value="silangan_deg_batur">Silangan DEG-Batur</option>
                            <option value="silangan_det_dorper">Silangan DET-Dorper</option>
                            <option value="silangan_det_garut">Silangan DET-Garut</option>
                            <option value="domba_dorper_f1">Domba Dorper F1</option>
                            <option value="domba_dorper_f2">Domba Dorper F2</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Jenis Kelamin *</label>
                        <select name="gender" id="gender" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="male">Jantan</option>
                            <option value="female">Betina</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Tanggal Lahir *</label>
                        <input type="date" name="birth_date" id="birth_date" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Berat Awal (kg) *</label>
                        <input type="number" step="0.1" name="initial_weight" id="initial_weight" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Tanggal Masuk (Date In)</label>
                        <input type="date" name="date_in" id="date_in" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Kondisi</label>
                        <input type="text" name="condition" id="condition" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Contoh: Menyusui, Bakalan, Cacat, dll">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Induk Jantan (Ear Tag)</label>
                        <input type="text" name="father_ear_tag" id="father_ear_tag" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Induk Betina (Ear Tag)</label>
                        <input type="text" name="mother_ear_tag" id="mother_ear_tag" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Status Kesehatan</label>
                        <select name="health_status" id="health_status" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="excellent">Sangat Baik</option>
                            <option value="good">Baik</option>
                            <option value="fair">Cukup</option>
                            <option value="poor">Kurang</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Status Ternak</label>
                        <select name="status" id="status" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-200 text-sm font-medium mb-1">Kejadian (Logbook)</label>
                        <select name="logbook_event" id="logbook_event" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="">-- Tidak ada kejadian --</option>
                            <option value="Vaksin">Vaksin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Pindah Kandang">Pindah Kandang</option>
                            <option value="Melahirkan">Melahirkan</option>
                            <option value="Kawin">Kawin</option>
                            <option value="Disembelih">Disembelih</option>
                            <option value="Terjual">Terjual</option>
                            <option value="Mati">Mati</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Foto Ternak</label>
                    <input type="file" name="image" id="image" accept="image/*" class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30">
                    <div id="image-preview" class="mt-2 hidden">
                        <img src="" alt="Preview" class="h-20 w-auto rounded border border-white/20">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Catatan</label>
                    <textarea name="notes" id="notes" rows="2" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent"></textarea>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white rounded-xl shadow-md transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== MODAL CATAT BERAT ========== -->
<div id="weight-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="bg-black/40 backdrop-blur-md rounded-2xl p-6 max-w-md w-full z-10 border border-white/20 shadow-2xl">
            <h3 id="weight-modal-title" class="text-white text-xl font-bold mb-5">Catat Berat Badan</h3>
            <form id="record-weight-form" class="space-y-4">
                @csrf
                <input type="hidden" id="weight-livestock-id" name="livestock_id">
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Berat (kg)</label>
                    <input type="number" step="0.1" name="weight_kg" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Tanggal Pencatatan</label>
                    <input type="date" name="record_date" value="{{ date('Y-m-d') }}" required class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-1">Catatan</label>
                    <textarea name="notes" rows="2" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeWeightModal()" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl transition">Batal</button>
                    <button type="button" onclick="submitWeightForm()" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white rounded-xl shadow-md transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== MODAL IMPOR EXCEL ========== -->
<div id="import-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="bg-black/40 backdrop-blur-md rounded-2xl p-6 max-w-lg w-full z-10 border border-white/20 shadow-2xl">
            <h3 class="text-white text-xl font-bold mb-5">Impor Data Ternak dari Excel</h3>
            <form id="import-form" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-200 text-sm font-medium mb-2">Pilih file Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="block w-full bg-white/10 border border-white/20 rounded-xl p-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-400">Format kolom: ear_tag, breed_type, gender, birth_date, initial_weight, health_status, notes, pen_id, condition, date_in, father_ear_tag, mother_ear_tag</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white rounded-xl shadow-md transition">Impor</button>
                </div>
            </form>
            <div id="import-progress" class="hidden mt-4 text-center">
                <div class="loading-spinner mx-auto"></div>
                <p class="text-gray-400 text-sm mt-2">Memproses...</p>
            </div>
        </div>
    </div>
</div>

<!-- ========== MODAL KONFIRMASI HAPUS (PREMIUM) ========== -->
<div id="delete-confirm-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-black/40 backdrop-blur-md rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-white/20">
            <div class="px-6 pt-6 pb-4 sm:px-8 sm:pt-8">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-500/20 rounded-full">
                    <i class="fas fa-trash-alt text-red-400 text-2xl"></i>
                </div>
                <div class="mt-4 text-center">
                    <h3 class="text-xl font-semibold text-white">Konfirmasi Hapus</h3>
                    <div class="mt-3">
                        <p class="text-sm text-gray-300" id="delete-modal-message">Apakah Anda yakin ingin menonaktifkan ternak ini? Data akan tetap tersimpan tetapi status menjadi tidak aktif.</p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-white/5 sm:flex sm:flex-row-reverse sm:px-8">
                <button type="button" id="delete-confirm-btn" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-xl shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Hapus</button>
                <button type="button" onclick="closeDeleteModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-300 bg-white/10 border border-white/20 rounded-xl shadow-sm hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-gray-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Animasi untuk modal delete */
    #delete-confirm-modal {
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }
    #delete-confirm-modal .inline-block {
        transform: scale(0.95);
        transition: transform 0.2s ease;
    }
    #delete-confirm-modal.show {
        opacity: 1;
        visibility: visible;
    }
    #delete-confirm-modal.show .inline-block {
        transform: scale(1);
    }
    /* Custom scrollbar untuk modal */
    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }
    .overflow-y-auto::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
    }
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: rgba(16,185,129,0.5);
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
// ==================== VARIABLES ====================
let currentPage = 1;
let filters = {};
let deleteLivestockId = null;

// ==================== DOCUMENT READY ====================
document.addEventListener('DOMContentLoaded', function() {
    loadLivestocks();
    loadPensForFilter();
    loadPensForModal();

    // Preview gambar
    const imageInput = document.querySelector('#livestock-form input[name="image"]');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            if (e.target.files && e.target.files[0]) {
                if (e.target.files[0].size > 2 * 1024 * 1024) {
                    TernakPark.ui.showToast('Ukuran foto maksimal 2MB', 'error');
                    this.value = '';
                    preview.classList.add('hidden');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(ev) {
                    preview.querySelector('img').src = ev.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(e.target.files[0]);
            } else {
                preview.classList.add('hidden');
            }
        });
    }

    // Submit form tambah/edit
    document.getElementById('livestock-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const id = document.getElementById('edit-id').value;
        let url = '/web-api/livestocks/store';
        if (id) {
            url = `/web-api/livestocks/${id}/update`;
            formData.append('_method', 'PUT');
        }
        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            });
            const responseText = await response.text();
            let json;
            try {
                json = JSON.parse(responseText);
            } catch (parseError) {
                console.error('Response not JSON:', responseText.substring(0, 500));
                throw new Error('Server error (response bukan JSON). Lihat log backend.');
            }
            if (response.ok && json.success) {
                closeModal();
                loadLivestocks();
                TernakPark.ui.showToast(id ? 'Ternak diperbarui' : 'Ternak ditambahkan', 'success');
            } else {
                let errorMsg = json.message || 'Gagal menyimpan';
                if (json.errors) errorMsg = Object.values(json.errors).flat().join(', ');
                TernakPark.ui.showToast(errorMsg, 'error');
            }
        } catch (error) {
            console.error(error);
            TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });

    // Tombol konfirmasi hapus
    document.getElementById('delete-confirm-btn').addEventListener('click', executeDelete);
});

// ==================== LOAD DATA TERNAK ====================
async function loadLivestocks(page = 1) {
    currentPage = page;
    const params = new URLSearchParams({ page, ...filters });
    try {
        const res = await TernakPark.api.fetchData(`/web-api/livestocks/data?${params}`);
        if (res.success) {
            renderTable(res.data.livestocks);
            renderPagination(res.data.pagination);
        } else {
            document.getElementById('livestock-table-body').innerHTML = `<tr><td colspan="10" class="text-center py-8 text-red-400">Gagal memuat data: ${escapeHtml(res.message || 'unknown')}</td></tr>`;
        }
    } catch (error) {
        console.error(error);
        document.getElementById('livestock-table-body').innerHTML = `<tr><td colspan="10" class="text-center py-8 text-red-400">Koneksi error: ${escapeHtml(error.message)}</td></tr>`;
    }
}

function renderTable(livestocks) {
    const tbody = document.getElementById('livestock-table-body');
    if (!livestocks || livestocks.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>';
        return;
    }
    let html = '';
    for (const l of livestocks) {
        html += `
            <tr class="border-b border-white/10 hover:bg-white/5 transition">
                <td class="px-4 py-3 whitespace-nowrap"><img src="${escapeHtml(l.image_url || 'https://via.placeholder.com/40?text=No+Img')}" class="h-10 w-10 rounded-full object-cover" onerror="this.src='https://via.placeholder.com/40?text=No+Img'"></td>
                <td class="px-4 py-3 whitespace-nowrap font-medium">${escapeHtml(l.ear_tag)}</td>
                <td class="px-4 py-3 whitespace-nowrap">${escapeHtml((l.breed_type || '').replace(/_/g, ' ') || '-')}</td>
                <td class="px-4 py-3 whitespace-nowrap">${l.gender === 'male' ? 'Jantan' : 'Betina'}</td>
                <td class="px-4 py-3 whitespace-nowrap">${escapeHtml(l.pen?.name || '-')}</td>
                <td class="px-4 py-3 whitespace-nowrap">${l.current_weight ?? '-'}</td>
                <td class="px-4 py-3 whitespace-nowrap">${l.age_days ?? '-'}</td>
                <td class="px-4 py-3 whitespace-nowrap">${escapeHtml(l.condition || '-')}</td>
                <td class="px-4 py-3 whitespace-nowrap"><span class="px-2 py-1 rounded-full text-xs ${l.status ? 'bg-emerald-500/20 text-emerald-200' : 'bg-red-500/20 text-red-200'}">${l.status ? 'Aktif' : 'Tidak Aktif'}</span></td>
                <td class="px-4 py-3 whitespace-nowrap text-right">
                    <button onclick="openEditModal(${l.id})" class="text-amber-400 hover:text-amber-300 mr-2 transition" title="Edit"><i class="fas fa-edit"></i></button>
                    <button onclick="openWeightModal(${l.id}, '${escapeHtml(l.ear_tag)}')" class="text-blue-400 hover:text-blue-300 mr-2 transition" title="Catat Berat"><i class="fas fa-weight"></i></button>
                    <button onclick="confirmDeleteLivestock(${l.id}, '${escapeHtml(l.ear_tag)}')" class="text-red-400 hover:text-red-300 mr-2 transition" title="Hapus"><i class="fas fa-trash"></i></button>
                    <a href="/livestocks/${l.id}" class="text-emerald-400 hover:text-emerald-300 transition" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </table>
        `;
    }
    tbody.innerHTML = html;
}

function renderPagination(pagination) {
    const div = document.getElementById('pagination');
    if (!pagination || pagination.total <= pagination.per_page) {
        div.innerHTML = '';
        return;
    }
    const start = (currentPage - 1) * pagination.per_page + 1;
    const end = Math.min(currentPage * pagination.per_page, pagination.total);
    div.innerHTML = `
        <div class="text-sm text-gray-400">Menampilkan ${start} - ${end} dari ${pagination.total}</div>
        <div class="flex space-x-2">
            <button onclick="loadLivestocks(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''} class="px-3 py-1 border border-white/20 rounded-xl bg-white/5 hover:bg-white/10 transition disabled:opacity-50 disabled:cursor-not-allowed text-white">Prev</button>
            <button onclick="loadLivestocks(${currentPage + 1})" ${currentPage === pagination.last_page ? 'disabled' : ''} class="px-3 py-1 border border-white/20 rounded-xl bg-white/5 hover:bg-white/10 transition disabled:opacity-50 disabled:cursor-not-allowed text-white">Next</button>
        </div>
    `;
}

// ==================== LOAD KANDANG ====================
async function loadPensForFilter() {
    const select = document.getElementById('pen-filter');
    select.innerHTML = '<option value="">Memuat kandang...</option>';
    try {
        const res = await TernakPark.api.fetchData('/web-api/pens/data');
        if (res.success && res.data.pens && res.data.pens.length) {
            let options = '<option value="">Semua Kandang</option>';
            for (const p of res.data.pens) {
                options += `<option value="${p.id}">${escapeHtml(p.name)}</option>`;
            }
            select.innerHTML = options;
        } else {
            select.innerHTML = '<option value="">Tidak ada kandang</option>';
        }
    } catch (error) {
        console.error(error);
        select.innerHTML = '<option value="">Gagal memuat kandang</option>';
        TernakPark.ui.showToast('Gagal memuat data kandang', 'error');
    }
}

async function loadPensForModal() {
    const select = document.querySelector('#livestock-form select[name="pen_id"]');
    select.innerHTML = '<option value="">Memuat kandang...</option>';
    try {
        const res = await TernakPark.api.fetchData('/web-api/pens/data');
        if (res.success && res.data.pens && res.data.pens.length) {
            let options = '<option value="">Pilih Kandang</option>';
            for (const p of res.data.pens) {
                options += `<option value="${p.id}">${escapeHtml(p.name)} (${escapeHtml(p.category)})</option>`;
            }
            select.innerHTML = options;
        } else {
            select.innerHTML = '<option value="">Tidak ada kandang tersedia</option>';
        }
    } catch (error) {
        console.error(error);
        select.innerHTML = '<option value="">Gagal memuat kandang</option>';
        TernakPark.ui.showToast('Gagal memuat data kandang', 'error');
    }
}

// ==================== DELETE DENGAN MODAL ====================
function confirmDeleteLivestock(id, earTag) {
    deleteLivestockId = id;
    const messageEl = document.getElementById('delete-modal-message');
    messageEl.innerHTML = `Apakah Anda yakin ingin menonaktifkan ternak dengan Ear Tag <strong>${escapeHtml(earTag)}</strong>?<br>Data akan tetap tersimpan tetapi status menjadi tidak aktif.`;
    const modal = document.getElementById('delete-confirm-modal');
    modal.classList.remove('hidden');
    setTimeout(() => modal.classList.add('show'), 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-confirm-modal');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.classList.add('hidden');
        deleteLivestockId = null;
    }, 200);
}

async function executeDelete() {
    if (!deleteLivestockId) return;
    try {
        const response = await fetch(`/web-api/livestocks/${deleteLivestockId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        const json = await response.json();
        if (response.ok && json.success) {
            TernakPark.ui.showToast('Ternak berhasil dinonaktifkan', 'success');
            loadLivestocks();
        } else {
            TernakPark.ui.showToast(json.message || 'Gagal menghapus', 'error');
        }
    } catch (error) {
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    } finally {
        closeDeleteModal();
    }
}

// ==================== FUNGSI LAINNYA ====================
function applyFilters() {
    filters = {
        pen_id: document.getElementById('pen-filter').value,
        status: document.getElementById('status-filter').value === 'active' ? '1' : (document.getElementById('status-filter').value === 'inactive' ? '0' : ''),
        breed_type: document.getElementById('breed-filter').value
    };
    for (const k in filters) {
        if (!filters[k]) delete filters[k];
    }
    loadLivestocks(1);
}

function openAddModal() {
    document.getElementById('modal-title').innerText = 'Tambah Ternak';
    document.getElementById('livestock-form').reset();
    document.getElementById('edit-id').value = '';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('feed-info').classList.add('hidden');
    document.getElementById('livestock-modal').classList.remove('hidden');
}

async function openEditModal(id) {
    try {
        const res = await TernakPark.api.fetchData(`/web-api/livestocks/${id}/detail`);
        if (res.success) {
            const l = res.data;
            document.getElementById('modal-title').innerText = 'Edit Ternak';
            document.getElementById('edit-id').value = l.id;
            document.getElementById('ear_tag').value = l.ear_tag || '';
            document.getElementById('pen_id').value = l.pen?.id || '';
            document.getElementById('breed_type').value = l.breed_type || 'domba_lokal';
            document.getElementById('gender').value = l.gender || 'male';
            document.getElementById('birth_date').value = l.birth_date || '';
            document.getElementById('initial_weight').value = l.initial_weight || '';
            document.getElementById('date_in').value = l.date_in || '';
            document.getElementById('condition').value = l.condition || '';
            document.getElementById('father_ear_tag').value = l.father_ear_tag || '';
            document.getElementById('mother_ear_tag').value = l.mother_ear_tag || '';
            document.getElementById('health_status').value = l.health_status || 'good';
            document.getElementById('status').value = l.status ? '1' : '0';
            document.getElementById('notes').value = l.notes || '';
            if (l.image_url) {
                const preview = document.getElementById('image-preview');
                preview.querySelector('img').src = l.image_url;
                preview.classList.remove('hidden');
            } else {
                document.getElementById('image-preview').classList.add('hidden');
            }
            if (l.pen?.id) {
                const select = document.getElementById('pen_id');
                select.value = l.pen.id;
                onPenChange(select);
            }
            document.getElementById('livestock-modal').classList.remove('hidden');
        } else {
            TernakPark.ui.showToast('Gagal memuat data ternak', 'error');
        }
    } catch (error) {
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    }
}

function closeModal() {
    document.getElementById('livestock-modal').classList.add('hidden');
}

function openWeightModal(id, earTag) {
    document.getElementById('weight-modal-title').innerHTML = `Catat Berat - ${escapeHtml(earTag)}`;
    document.getElementById('weight-livestock-id').value = id;
    document.getElementById('record-weight-form').reset();
    document.getElementById('record-weight-form').querySelector('input[name="record_date"]').value = new Date().toISOString().split('T')[0];
    document.getElementById('weight-modal').classList.remove('hidden');
}

function closeWeightModal() {
    document.getElementById('weight-modal').classList.add('hidden');
}

async function submitWeightForm() {
    const form = document.getElementById('record-weight-form');
    const data = Object.fromEntries(new FormData(form));
    const id = data.livestock_id;
    const submitButton = form.querySelector('button[type="button"]:last-child');
    const originalText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';
    try {
        const response = await fetch(`/web-api/livestocks/${id}/record-weight`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify(data)
        });
        const json = await response.json();
        if (response.ok && json.success) {
            closeWeightModal();
            loadLivestocks();
            TernakPark.ui.showToast('Berat dicatat', 'success');
        } else {
            TernakPark.ui.showToast(json.message || 'Gagal mencatat berat', 'error');
        }
    } catch (error) {
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    }
}

function onPenChange(select) {
    const penId = select.value;
    const feedInfo = document.getElementById('feed-info');
    if (!penId) {
        feedInfo.classList.add('hidden');
        return;
    }
    fetchPenCategory(penId);
}

async function fetchPenCategory(penId) {
    try {
        const res = await TernakPark.api.fetchData(`/web-api/pens/${penId}/detail`);
        if (res.success) {
            const category = res.data.category;
            const feeds = getFeedsForCategory(category);
            const feedList = document.getElementById('feed-list');
            if (feeds.length) {
                feedList.innerHTML = feeds.map(feed => `<span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-200 text-sm">${escapeHtml(feed)}</span>`).join('');
                document.getElementById('feed-info').classList.remove('hidden');
            } else {
                feedList.innerHTML = '<span class="text-gray-400">Tidak ada rekomendasi pakan</span>';
                document.getElementById('feed-info').classList.remove('hidden');
            }
        }
    } catch (error) {
        console.error(error);
    }
}

function getFeedsForCategory(category) {
    const feedMap = {
        'Fattening': ['Silase', 'Complete Feed Kediri', 'Complete Feed Jember', 'Ampas Tahu', 'Complete Feed Madiun', 'Onggok', 'Jagung', 'LAK 105', 'Nutrifeed'],
        'Fattening Percobaan': ['Silase', 'Complete Feed Jember', 'Jagung', 'LAK 105', 'Pakchong'],
        'Kawin': ['Silase', 'Complete Feed Jember', 'Pakchong', 'Jagung', 'Complete Feed Madiun', 'LAK 105', 'Nutrifeed'],
        'Melahirkan': ['Silase', 'Jagung', 'Complete Feed Jember', 'Complete Feed Madiun', 'LAK 105', 'Pakchong', 'Nutrifeed', 'Crepfeed'],
        'Menyusui': ['Silase', 'Complete Feed Jember', 'Jagung', 'Complete Feed Madiun', 'Pakchong', 'Nutrifeed', 'LAK 105', 'Crepfeed'],
        'Prasapih': ['Silase', 'Complete Feed Jember', 'Jagung', 'Complete Feed Madiun', 'Pakchong', 'Crepfeed', 'LAK 105', 'Nutrifeed'],
        'Kambing': ['Silase', 'Complete Feed Madiun', 'Complete Feed Jember', 'Gembilina', 'Pakchong', 'Nutrifeed', 'LAK 105', 'Pongkol Ketela', 'Jagung', 'Ramban']
    };
    return feedMap[category] || [];
}

function openImportModal() {
    document.getElementById('import-modal').classList.remove('hidden');
}

function closeImportModal() {
    document.getElementById('import-modal').classList.add('hidden');
    document.getElementById('import-form').reset();
    document.getElementById('import-progress').classList.add('hidden');
}

document.getElementById('import-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    document.getElementById('import-progress').classList.remove('hidden');
    try {
        const response = await fetch('/web-api/livestocks/import', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        });
        const json = await response.json();
        if (json.success) {
            TernakPark.ui.showToast('Data ternak berhasil diimpor', 'success');
            closeImportModal();
            loadLivestocks();
        } else {
            TernakPark.ui.showToast(json.message || 'Gagal impor', 'error');
        }
    } catch (error) {
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        document.getElementById('import-progress').classList.add('hidden');
    }
});

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(match) {
        if (match === '&') return '&amp;';
        if (match === '<') return '&lt;';
        if (match === '>') return '&gt;';
        return match;
    });
}
</script>
@endpush
