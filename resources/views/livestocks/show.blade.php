@extends('layouts.app')

@section('title', 'Detail Ternak')
@section('header-title', 'Detail Ternak')

@section('content')
<div class="space-y-6">
    <!-- Tombol Kembali ke Dashboard -->
    <div class="flex justify-end">
        <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- Card Informasi Utama Premium --}}
    <div class="glass-card p-6">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-white" id="ear-tag">-</h2>
                        <p class="text-emerald-200 text-sm" id="breed">-</p>
                    </div>
                    <span id="status-badge" class="px-3 py-1 rounded-full text-sm font-medium"></span>
                </div>
                <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4 text-sm text-gray-300">
                    <div><span class="font-semibold text-gray-400">Jenis Kelamin</span><br><span id="gender">-</span></div>
                    <div><span class="font-semibold text-gray-400">Tanggal Lahir</span><br><span id="birth">-</span></div>
                    <div><span class="font-semibold text-gray-400">Umur (hari)</span><br><span id="age">- hari</span></div>
                    <div><span class="font-semibold text-gray-400">Kandang</span><br><span id="pen">-</span></div>
                    <div><span class="font-semibold text-gray-400">Kondisi</span><br><span id="condition">-</span></div>
                    <div><span class="font-semibold text-gray-400">Umur Reproduksi</span><br><span id="reproductive-age">-</span></div>
                </div>
            </div>
            <div class="w-full lg:w-80 rounded-2xl overflow-hidden border border-white/20 bg-black/20">
                <img id="livestock-image" src="https://via.placeholder.com/600x400?text=Foto+Ternak" alt="Foto Ternak" class="w-full h-56 object-cover">
            </div>
        </div>
    </div>

    {{-- Grid Detail dan Edit --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Detail Lengkap --}}
        <div class="xl:col-span-2 glass-card p-6">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
                <i class="fas fa-info-circle text-emerald-400"></i>
                <h3 class="font-bold text-white text-lg">Detail Lengkap Ternak</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-300">
                <div><span class="font-medium text-gray-400">Berat Awal (BB In)</span><br><span id="initial-weight">- kg</span></div>
                <div><span class="font-medium text-gray-400">BB Terbaru</span><br><span id="current-weight">- kg</span></div>
                <div><span class="font-medium text-gray-400">Tanggal Timbang Terakhir</span><br><span id="last-weight-date">-</span></div>
                <div><span class="font-medium text-gray-400">Tanggal Masuk (Date In)</span><br><span id="date-in">-</span></div>
                <div><span class="font-medium text-gray-400">Day On Farm</span><br><span id="day-on-farm">- hari</span></div>
                <div><span class="font-medium text-gray-400">Status di Kandang</span><br><span id="pen-status">-</span></div>
                <div><span class="font-medium text-gray-400">Tanggal Kematian/Terjual</span><br><span id="death-sold-date">-</span></div>
                <div><span class="font-medium text-gray-400">Induk Jantan (Pejantan)</span><br><span id="father">-</span></div>
                <div><span class="font-medium text-gray-400">Induk Betina</span><br><span id="mother">-</span></div>
                <div><span class="font-medium text-gray-400">Kesehatan</span><br><span id="health">-</span></div>
                <div class="md:col-span-2"><span class="font-medium text-gray-400">Catatan</span><br><span id="notes" class="whitespace-pre-line">-</span></div>
            </div>

            {{-- Riwayat Berat --}}
            <div class="mt-6">
                <div class="flex items-center gap-2 border-b border-white/10 pb-2 mb-3">
                    <i class="fas fa-chart-line text-emerald-400"></i>
                    <h3 class="font-semibold text-white">Riwayat Berat</h3>
                </div>
                <div id="weight-history" class="space-y-3 max-h-72 overflow-y-auto pr-2"></div>
            </div>
        </div>

        {{-- Kolom Kanan: Edit & Upload Foto --}}
        <div class="glass-card p-6">
            <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
                <i class="fas fa-edit text-emerald-400"></i>
                <h3 class="font-bold text-white text-lg">Edit Data & Upload Foto</h3>
            </div>
            <form id="livestock-edit-form" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div>
                    <label class="block text-sm font-medium text-gray-300">Ear Tag</label>
                    <input type="text" id="input-ear-tag" name="ear_tag" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Jenis Ternak</label>
                    <select id="input-breed-type" name="breed_type" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
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
                    <label class="block text-sm font-medium text-gray-300">Jenis Kelamin</label>
                    <select id="input-gender" name="gender" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                        <option value="male">Jantan</option>
                        <option value="female">Betina</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Tanggal Lahir</label>
                    <input type="date" id="input-birth-date" name="birth_date" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Berat Awal (kg)</label>
                    <input type="number" step="0.1" id="input-initial-weight" name="initial_weight" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Kesehatan</label>
                    <select id="input-health-status" name="health_status" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="excellent">Sangat Baik</option>
                        <option value="good">Baik</option>
                        <option value="fair">Cukup</option>
                        <option value="poor">Kurang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Kondisi</label>
                    <input type="text" id="input-condition" name="condition" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Contoh: Menyusui, Bakalan, Cacat, dll">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Tanggal Masuk (Date In)</label>
                    <input type="date" id="input-date-in" name="date_in" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Induk Jantan (Ear Tag)</label>
                    <input type="text" id="input-father" name="father_ear_tag" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Induk Betina (Ear Tag)</label>
                    <input type="text" id="input-mother" name="mother_ear_tag" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Foto Ternak</label>
                    <input type="file" id="input-image" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30">
                    <div id="image-preview" class="mt-2 hidden">
                        <img src="" alt="Preview" class="h-24 w-auto rounded border border-white/20">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Catatan</label>
                    <textarea id="input-notes" name="notes" rows="3" class="mt-1 block w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent"></textarea>
                </div>
                <button type="button" id="save-livestock" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white rounded-xl py-2.5 font-semibold shadow-md transition-all transform hover:scale-[1.02]">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- Pakan yang Digunakan --}}
    <div class="glass-card p-6">
        <div class="flex items-center gap-2 border-b border-white/10 pb-3 mb-4">
            <i class="fas fa-seedling text-emerald-400"></i>
            <h3 class="font-bold text-white text-lg">Pakan yang Digunakan</h3>
        </div>
        <div id="feed-info" class="flex flex-wrap gap-2">
            <div class="text-gray-400">Memuat...</div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Menyesuaikan tampilan badge status agar tetap terlihat di latar gelap */
    .bg-green-100.text-green-800 {
        background-color: rgba(16, 185, 129, 0.2) !important;
        color: #a7f3d0 !important;
    }
    .bg-red-100.text-red-800 {
        background-color: rgba(239, 68, 68, 0.2) !important;
        color: #fecaca !important;
    }
    /* Riwayat berat card */
    #weight-history .border {
        border-color: rgba(255, 255, 255, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
// Mendapatkan ID ternak dari server-side (variabel PHP $livestock)
let livestockId = {{ $livestock['id'] ?? 0 }};

document.addEventListener('DOMContentLoaded', async function() {
    if (!livestockId || livestockId === 0) {
        TernakPark.ui.showToast('ID ternak tidak valid', 'error');
        return;
    }
    await loadLivestockDetail();
    document.getElementById('save-livestock').addEventListener('click', submitLivestockUpdate);
    document.getElementById('input-image').addEventListener('change', previewImage);
});

async function loadLivestockDetail() {
    try {
        const response = await TernakPark.api.fetchData(`/web-api/livestocks/${livestockId}/detail`);
        if (response.success) {
            const data = response.data;
            renderDetail(data);
            populateEditForm(data);
            renderWeightHistory(data.weight_records);
        } else {
            TernakPark.ui.showToast('Gagal memuat detail', 'error');
        }
    } catch (error) {
        console.error(error);
        TernakPark.ui.showToast('Koneksi error: ' + error.message, 'error');
    }
}

function renderDetail(data) {
    // Informasi dasar
    document.getElementById('ear-tag').innerText = data.ear_tag || '-';
    document.getElementById('breed').innerText = (data.breed_type || '').replace(/_/g, ' ') || '-';
    document.getElementById('gender').innerText = data.gender === 'male' ? 'Jantan' : 'Betina';
    document.getElementById('birth').innerText = data.birth_date ? new Date(data.birth_date).toLocaleDateString('id-ID') : '-';
    document.getElementById('age').innerText = data.age_days ? data.age_days + ' hari' : '-';
    document.getElementById('pen').innerText = data.pen?.name || '-';
    document.getElementById('condition').innerText = data.condition || '-';
    document.getElementById('reproductive-age').innerText = data.reproductive_age || '-';

    // Detail tambahan
    document.getElementById('initial-weight').innerText = data.initial_weight ? data.initial_weight + ' kg' : '-';
    document.getElementById('current-weight').innerText = data.current_weight ? data.current_weight + ' kg' : '-';
    document.getElementById('last-weight-date').innerText = data.last_weight_date ? new Date(data.last_weight_date).toLocaleDateString('id-ID') : '-';
    document.getElementById('date-in').innerText = data.date_in ? new Date(data.date_in).toLocaleDateString('id-ID') : '-';
    document.getElementById('day-on-farm').innerText = data.day_on_farm !== undefined ? data.day_on_farm + ' hari' : '-';
    document.getElementById('pen-status').innerText = data.status ? 'Di Kandang' : (data.date_of_death_or_sold ? 'Keluar' : 'Tidak Aktif');
    document.getElementById('death-sold-date').innerText = data.date_of_death_or_sold ? new Date(data.date_of_death_or_sold).toLocaleDateString('id-ID') : '-';
    document.getElementById('father').innerText = data.father_ear_tag || '-';
    document.getElementById('mother').innerText = data.mother_ear_tag || '-';
    document.getElementById('health').innerText = data.health_status || '-';
    document.getElementById('notes').innerText = data.notes || '-';

    // Badge status (warna disesuaikan untuk latar gelap)
    const badge = document.getElementById('status-badge');
    if (data.status) {
        badge.innerText = 'Aktif';
        badge.className = 'px-3 py-1 rounded-full text-sm font-medium bg-emerald-500/20 text-emerald-200';
    } else {
        badge.innerText = 'Tidak Aktif';
        badge.className = 'px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-200';
    }

    // Gambar
    const photo = document.getElementById('livestock-image');
    photo.src = data.image_url || 'https://via.placeholder.com/600x400?text=Foto+Ternak';

    // Pakan berdasarkan kandang
    if (data.pen?.id) {
        renderFeedInfo(data.pen.id);
    } else {
        document.getElementById('feed-info').innerHTML = '<div class="text-gray-500">Tidak ada data kandang</div>';
    }
}

function populateEditForm(data) {
    document.getElementById('input-ear-tag').value = data.ear_tag || '';
    document.getElementById('input-breed-type').value = data.breed_type || 'domba_lokal';
    document.getElementById('input-gender').value = data.gender || 'male';
    document.getElementById('input-birth-date').value = data.birth_date || '';
    document.getElementById('input-initial-weight').value = data.initial_weight || '';
    document.getElementById('input-health-status').value = data.health_status || 'good';
    document.getElementById('input-condition').value = data.condition || '';
    document.getElementById('input-date-in').value = data.date_in || '';
    document.getElementById('input-father').value = data.father_ear_tag || '';
    document.getElementById('input-mother').value = data.mother_ear_tag || '';
    document.getElementById('input-notes').value = data.notes || '';
}

function renderWeightHistory(records) {
    const container = document.getElementById('weight-history');
    if (!records || records.length === 0) {
        container.innerHTML = '<div class="text-gray-400 text-center py-4">Belum ada catatan berat</div>';
        return;
    }
    let html = '';
    for (const record of records) {
        html += `
            <div class="flex justify-between items-center p-3 border border-white/10 rounded-xl bg-white/5">
                <span class="text-gray-300">${new Date(record.record_date).toLocaleDateString('id-ID')}</span>
                <span class="font-semibold text-emerald-300">${record.weight_kg} kg</span>
            </div>
        `;
    }
    container.innerHTML = html;
}

async function renderFeedInfo(penId) {
    try {
        const category = await fetchPenCategory(penId);
        const feeds = getFeedsForCategory(category);
        const feedInfo = document.getElementById('feed-info');
        if (feeds.length) {
            feedInfo.innerHTML = feeds.map(feed => `<span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-200 text-sm">${escapeHtml(feed)}</span>`).join('');
        } else {
            feedInfo.innerHTML = '<div class="text-gray-500">Tidak ada data pakan untuk kategori ini</div>';
        }
    } catch (error) {
        console.error(error);
        document.getElementById('feed-info').innerHTML = '<div class="text-gray-500">Gagal memuat data pakan</div>';
    }
}

async function fetchPenCategory(penId) {
    const response = await TernakPark.api.fetchData(`/web-api/pens/${penId}/detail`);
    if (response.success) {
        return response.data.category;
    }
    throw new Error('Gagal mengambil kategori kandang');
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

function previewImage(event) {
    const preview = document.getElementById('image-preview');
    const file = event.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            TernakPark.ui.showToast('Ukuran foto maksimal 2MB', 'error');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
}

async function submitLivestockUpdate() {
    const form = document.getElementById('livestock-edit-form');
    const formData = new FormData(form);
    const fileInput = document.getElementById('input-image');
    if (fileInput.files.length) {
        formData.append('image', fileInput.files[0]);
    }

    const submitButton = document.getElementById('save-livestock');
    const originalText = submitButton.innerText;
    submitButton.disabled = true;
    submitButton.innerText = 'Menyimpan...';

    try {
        const response = await fetch(`/web-api/livestocks/${livestockId}/update`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        let result;
        try {
            result = await response.json();
        } catch (parseError) {
            const rawText = await response.text();
            console.error('Response not JSON:', rawText.substring(0, 500));
            throw new Error('Server error (response bukan JSON). Lihat log backend.');
        }

        if (response.ok && result.success) {
            TernakPark.ui.showToast('Data ternak berhasil diperbarui', 'success');
            await loadLivestockDetail();
            document.getElementById('input-image').value = '';
            document.getElementById('image-preview').classList.add('hidden');
        } else {
            let errorMsg = result.message || 'Gagal menyimpan data';
            if (result.errors) {
                errorMsg = Object.values(result.errors).flat().join(', ');
            }
            TernakPark.ui.showToast(errorMsg, 'error');
            console.error('Update response:', result);
        }
    } catch (error) {
        console.error('Update error:', error);
        TernakPark.ui.showToast('Koneksi gagal: ' + error.message, 'error');
    } finally {
        submitButton.disabled = false;
        submitButton.innerText = originalText;
    }
}

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
