@extends('layouts.admin')

@section('title', 'EDUSAFE - Dashboard Admin')

@section('content')
<div class="admin-page-wrapper">
    <div class="admin-container">

        @if(session('success'))
            <div style="background:#DCFCE7;color:#166534;border:1px solid #BBF7D0;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:14px;font-weight:600;">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background:#FEE2E2;color:#991B1B;border:1px solid #FECACA;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:14px;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- 4 Kotak Statistik Utama -->
        <div class="admin-stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon">👥</div>
                    <span class="stat-trend">+12%↑</span>
                </div>
                <div>
                    <p class="stat-label">Total User</p>
                    <h3 class="stat-value">1,284</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon">📚</div>
                    <span class="stat-trend">+5%↑</span>
                </div>
                <div>
                    <p class="stat-label">Jumlah Materi</p>
                    <h3 class="stat-value">{{ $totalMateri ?? 0 }}</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon">⭐</div>
                    <span class="stat-trend negative">-2%↓</span>
                </div>
                <div>
                    <p class="stat-label">Rata-rata Nilai</p>
                    <h3 class="stat-value">78.5</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon">⏱</div>
                    <span class="stat-trend active-tag">Active</span>
                </div>
                <div>
                    <p class="stat-label">Kuis Berjalan</p>
                    <h3 class="stat-value">24</h3>
                </div>
            </div>
        </div>

        <!-- Bagian User Terbaru -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">User Terbaru</h3>
            </div>
            
            <div class="user-list">
                <div class="user-item">
                    <div class="user-avatar-circle">JD</div>
                    <div class="user-details">
                        <h4>Jane Doe</h4>
                        <p>Baru saja bergabung</p>
                    </div>
                </div>

                <div class="user-item">
                    <div class="user-avatar-circle">AS</div>
                    <div class="user-details">
                        <h4>Andi Saputra</h4>
                        <p>2 jam yang lalu</p>
                    </div>
                </div>

                <div class="user-item">
                    <div class="user-avatar-circle">RK</div>
                    <div class="user-details">
                        <h4>Rina Kartika</h4>
                        <p>5 jam yang lalu</p>
                    </div>
                </div>
            </div>

            <button class="btn-outline-full">Lihat Semua User</button>
        </div>

        <!-- Bagian Tabel Materi  -->
        <div class="admin-card">
            <div class="admin-card-header flex-between">
                <h3 class="admin-card-title">Materi </h3>
                <button class="btn-primary-admin" onclick="toggleModal(true)">+ Tambah Materi</button>
            </div>
            
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nama Materi</th>
                            <th>Kategori</th>
                            <th>Isi Konten</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materiList ?? [] as $materi)
                            <tr>
                                <td><strong>{{ $materi->judul }}</strong></td>
                                <td>{{ $materi->kategori }}</td>
                                <td>
                                    {{-- BENAR --}}
                                        @if($materi->konten || $materi->isi_teks)
                                        <span class="badge-status-blue">📝 Teks Tersedia</span>
                                    @else
                                        <span class="badge-status-red">Kosong</span>
                                    @endif
                                </td>
                                <td><span class="badge-status-green">Aktif</span></td>
                                <td class="action-dots">⋮</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="table-empty">
                                    Belum ada data materi di database. Silakan klik tombol "+ Tambah Materi" di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BAGIAN KELOLA SOAL KUIS (GROUPED BY MATERI) -->
        <div class="admin-card" style="margin-top: 30px;">
            <div class="admin-card-header flex-between">
                <div>
                    <h3 class="admin-card-title">Kelola Soal Kuis & Kunci Jawaban</h3>
                    <p style="color: #64748B; font-size: 13px; margin: 4px 0 0 0;">Atur kuis per materi pembelajaran beserta kunci jawaban dan pembahasannya.</p>
                </div>
                <button class="btn-primary-admin" onclick="bukaModalTambahKuis()">+ Tambah Soal Kuis</button>
            </div>

            <!-- Filter Dropdown Pilih Materi -->
            <div style="margin-bottom: 16px; display: flex; align-items: center; gap: 12px; background: #F8FAFC; padding: 12px 16px; border-radius: 8px; border: 1px solid #E2E8F0;">
                <label style="font-size: 13px; font-weight: 700; color: #334155;">Filter Berdasarkan Materi:</label>
                <select id="filterMateri" onchange="renderTabelKuis()" style="padding: 8px 12px; border-radius: 6px; border: 1px solid #CBD5E1; background: #FFF; font-size: 13px; min-width: 250px;">
                    <option value="SEMUA">-- Semua Materi Pembelajaran --</option>
                    @foreach($materiList as $materi)
                        <option value="{{ $materi->getKey() }}">{{ $materi->judul ?? $materi->namamateri }}</option>
                    @endforeach
                </select>
                <span id="badgeTotalSoal" class="badge-status-blue" style="font-size: 12px;">Total: 0 Soal</span>
            </div>
            
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 100px;">No. Soal</th>
                            <th>Modul / Materi</th>
                            <th>Pertanyaan Soal</th>
                            <th style="width: 120px;">Kunci</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbodySoalKuis">
                        <!-- Data Soal akan dirender secara dinamis oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- MODAL POPUP FORM TAMBAH MATERI (TEKS) -->
<div id="modalTambahMateri" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Tambah Modul Materi Baru</h3>
            <span class="modal-close" onclick="toggleModal(false)">&times;</span>
        </div>

        <form action="#" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Judul Materi</label>
                <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Pengenalan Malware & Ancaman Siber">
            </div>

            <div class="form-group">
                <label>Kategori Modul</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}" required placeholder="Contoh: Cybersecurity Dasar">
            </div>

            <div class="form-group">
                <label>Ringkasan / Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="2" required placeholder="Jelaskan ringkasan singkat isi modul...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-group">
                <label>Isi Materi Lengkap (Format Teks)</label>
                <textarea name="konten" rows="6" required placeholder="Tulis atau ketik isi materi pembelajaran secara lengkap di sini...">{{ old('konten') }}</textarea>
                <small>Teks ini nantinya akan dibaca langsung oleh siswa melalui halaman baca materi.</small>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="toggleModal(false)">Batal</button>
                <button type="submit" class="btn-submit">Simpan Materi</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL POPUP KELOLA SOAL KUIS (TAMBAH & EDIT) -->
<div id="modalTambahKuis" class="modal-overlay">
    <div class="modal-card" style="max-width: 600px;">
        <div class="modal-header">
            <div>
                <h3 id="modalKuisTitle">Tambah Soal Kuis</h3>
                <span id="labelNomorSoal" style="font-size: 12px; color: #00288A; font-weight: 700;">Input Soal Ke-1</span>
            </div>
            <span class="modal-close" onclick="toggleModalKuis(false)">&times;</span>
        </div>

        <form id="formKuis" action="{{ route('admin.kuis.storeAjax') }}" method="POST" onsubmit="handleFormKuisSubmit(event)">
            @csrf
            <input type="hidden" id="editIndex" value="-1">
            
            <!-- 1. Pilih Materi Terkait -->
            <div class="form-group">
                <label>Pilih Modul / Materi Kuis</label>
                <select name="materi_id" id="materi_id" required style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 8px; background: #FFF;">
                    <option value="">-- Pilih Materi Pembelajaran --</option>
                    @foreach($materiList as $materi)
                        <option value="{{ $materi->getKey() }}">{{ $materi->judul ?? $materi->namamateri }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Form Soal -->
            <div class="form-group">
                <label>Pertanyaan Soal</label>
                <textarea name="pertanyaan" id="pertanyaan" rows="3" required placeholder="Tuliskan pertanyaan kuis di sini..."></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div class="form-group"><label>Pilihan A</label><input type="text" name="opsi_a" id="opsi_a" required placeholder="Jawaban A"></div>
                <div class="form-group"><label>Pilihan B</label><input type="text" name="opsi_b" id="opsi_b" required placeholder="Jawaban B"></div>
                <div class="form-group"><label>Pilihan C</label><input type="text" name="opsi_c" id="opsi_c" required placeholder="Jawaban C"></div>
                <div class="form-group"><label>Pilihan D</label><input type="text" name="opsi_d" id="opsi_d" required placeholder="Jawaban D"></div>
            </div>

            <div class="form-group">
                <label>Kunci Jawaban yang Benar</label>
                <select name="kunci_jawaban" id="kunci_jawaban" required style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 8px; background: #FFF;">
                    <option value="">-- Pilih Kunci Jawaban --</option>
                    <option value="A">Opsi A</option>
                    <option value="B">Opsi B</option>
                    <option value="C">Opsi C</option>
                    <option value="D">Opsi D</option>
                </select>
            </div>

            <div class="form-group">
                <label>Pembahasan / Penjelasan Jawaban</label>
                <textarea name="pembahasan" id="pembahasan" rows="2" required placeholder="Tuliskan pembahasan..."></textarea>
            </div>

            <!-- Actions: Tombol Tambah (+) & Tombol Selesai -->
            <div class="modal-actions" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #E2E8F0; padding-top: 15px;">
                <button type="button" class="btn-cancel" onclick="toggleModalKuis(false)">Batal</button>
                <div style="display: flex; gap: 10px;">
                    <!-- Tombol + untuk lanjut soal berikutnya -->
                    <button type="button" id="btnTambahBeruntun" class="btn-primary-admin" style="background: #10B981;" onclick="simpanDanLanjut()">+ Soal Berikutnya</button>
                    <!-- Tombol Simpan Akhir -->
                    <button type="submit" class="btn-submit" id="btnSimpanText">Selesai & Simpan Kuis</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Data tabel diambil dari database; tidak ada lagi array soal hardcode.
    let daftarSoalKuis = @json($soalKuis ?? []);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    const storeSoalUrl = @json(route('admin.kuis.storeAjax'));
    const updateSoalUrl = @json(url('/admin/kuis'));
    const deleteSoalUrl = @json(url('/admin/kuis'));

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
        }[char]));
    }

    function renderTabelKuis() {
        const tbody = document.getElementById('tbodySoalKuis');
        const selectedMateri = document.getElementById('filterMateri').value;
        tbody.innerHTML = '';
        const filteredData = daftarSoalKuis.filter(soal => selectedMateri === 'SEMUA' || String(soal.materi_id) === String(selectedMateri));
        document.getElementById('badgeTotalSoal').innerText = `Total: ${filteredData.length} Soal`;

        if (filteredData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="table-empty">Belum ada soal kuis untuk materi ini. Silakan klik tombol "+ Tambah Soal Kuis" di atas.</td></tr>`;
            return;
        }

        filteredData.forEach((soal, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><strong>Soal #${index + 1}</strong></td>
                <td><span class="badge-status-blue">${escapeHtml(soal.materi)}</span></td>
                <td><strong>${escapeHtml(soal.pertanyaan.length > 45 ? soal.pertanyaan.substring(0, 45) + '...' : soal.pertanyaan)}</strong></td>
                <td><span class="badge-status-green">Opsi ${escapeHtml(soal.kunci)}</span></td>
                <td><div style="display:flex;gap:8px;">
                    <button type="button" class="btn-cancel" style="padding:4px 10px;font-size:11px;" data-edit-id="${escapeHtml(soal.id)}">Edit</button>
                    <button type="button" class="btn-cancel" style="padding:4px 10px;font-size:11px;color:#EF4444;border-color:#FCA5A5;" data-delete-id="${escapeHtml(soal.id)}">Hapus</button>
                </div></td>`;
            row.querySelector('[data-edit-id]').addEventListener('click', () => editSoal(soal.id));
            row.querySelector('[data-delete-id]').addEventListener('click', () => hapusSoal(soal.id));
            tbody.appendChild(row);
        });
    }

    function toggleModal(show) {
        document.getElementById('modalTambahMateri').style.display = show ? 'flex' : 'none';
    }
    function toggleModalKuis(show) {
        document.getElementById('modalTambahKuis').style.display = show ? 'flex' : 'none';
    }

    function bukaModalTambahKuis() {
        document.getElementById('editIndex').value = '-1';
        document.getElementById('modalKuisTitle').innerText = 'Tambah Soal Kuis';
        document.getElementById('labelNomorSoal').innerText = 'Input Soal Beruntun';
        document.getElementById('btnTambahBeruntun').style.display = 'inline-block';
        document.getElementById('btnSimpanText').innerText = 'Selesai & Simpan Kuis';
        document.getElementById('formKuis').reset();
        document.getElementById('materi_id').disabled = false;
        toggleModalKuis(true);
    }

    function dataFormKuis() {
        return {
            materi_id: document.getElementById('materi_id').value,
            pertanyaan: document.getElementById('pertanyaan').value.trim(),
            opsi_a: document.getElementById('opsi_a').value.trim(),
            opsi_b: document.getElementById('opsi_b').value.trim(),
            opsi_c: document.getElementById('opsi_c').value.trim(),
            opsi_d: document.getElementById('opsi_d').value.trim(),
            kunci_jawaban: document.getElementById('kunci_jawaban').value,
            pembahasan: document.getElementById('pembahasan').value.trim()
        };
    }

    async function requestJson(url, method, data = null) {
        const options = { method, headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest' } };
        if (data) {
            options.headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(data);
        }
        const response = await fetch(url, options);
        const result = await response.json().catch(() => ({}));
        if (!response.ok) {
            const message = result.message || (result.errors ? Object.values(result.errors).flat().join('\n') : 'Permintaan gagal.');
            throw new Error(message);
        }
        return result;
    }

    async function simpanDanLanjut() {
        const data = dataFormKuis();
        if (!document.getElementById('formKuis').reportValidity()) return;
        try {
            const saved = await requestJson(storeSoalUrl, 'POST', data);
            const materiTerkunci = data.materi_id;
            const materiLabel = document.querySelector(`#materi_id option[value="${CSS.escape(String(materiTerkunci))}"]`)?.textContent || 'Materi';
            daftarSoalKuis.push({ id: saved.id, materi_id: materiTerkunci, materi: materiLabel, pertanyaan: data.pertanyaan, opsi_a: data.opsi_a, opsi_b: data.opsi_b, opsi_c: data.opsi_c, opsi_d: data.opsi_d, kunci: data.kunci_jawaban, pembahasan: data.pembahasan });
            renderTabelKuis();
            document.getElementById('materi_id').value = materiTerkunci;
            document.getElementById('materi_id').disabled = true;
            ['pertanyaan','opsi_a','opsi_b','opsi_c','opsi_d','kunci_jawaban','pembahasan'].forEach(id => document.getElementById(id).value = '');
            document.getElementById('pertanyaan').focus();
            alert('Soal berhasil disimpan ke database. Silakan lanjutkan soal berikutnya.');
        } catch (error) { alert(error.message); }
    }

    async function editSoal(id) {
        const soal = daftarSoalKuis.find(item => String(item.id) === String(id));
        if (!soal) return;
        document.getElementById('editIndex').value = soal.id;
        document.getElementById('modalKuisTitle').innerText = 'Edit Soal Kuis';
        document.getElementById('labelNomorSoal').innerText = `Edit Soal #${soal.id}`;
        document.getElementById('btnTambahBeruntun').style.display = 'none';
        document.getElementById('btnSimpanText').innerText = 'Update Soal';
        document.getElementById('materi_id').disabled = false;
        document.getElementById('materi_id').value = soal.materi_id;
        document.getElementById('pertanyaan').value = soal.pertanyaan;
        document.getElementById('opsi_a').value = soal.opsi_a;
        document.getElementById('opsi_b').value = soal.opsi_b;
        document.getElementById('opsi_c').value = soal.opsi_c;
        document.getElementById('opsi_d').value = soal.opsi_d;
        document.getElementById('kunci_jawaban').value = soal.kunci;
        document.getElementById('pembahasan').value = soal.pembahasan || '';
        toggleModalKuis(true);
    }

    async function hapusSoal(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus soal ini?')) return;
        try {
            await requestJson(`${deleteSoalUrl}/${encodeURIComponent(id)}`, 'DELETE');
            daftarSoalKuis = daftarSoalKuis.filter(soal => String(soal.id) !== String(id));
            renderTabelKuis();
            alert('Soal berhasil dihapus.');
        } catch (error) { alert(error.message); }
    }

    async function handleFormKuisSubmit(event) {
        event.preventDefault();
        const form = document.getElementById('formKuis');
        if (!form.reportValidity()) return;
        const id = document.getElementById('editIndex').value;
        const data = dataFormKuis();
        try {
            if (id !== '-1') {
                await requestJson(`${updateSoalUrl}/${encodeURIComponent(id)}`, 'PUT', data);
                const target = daftarSoalKuis.find(soal => String(soal.id) === String(id));
                if (target) Object.assign(target, data, { materi: document.querySelector(`#materi_id option[value="${CSS.escape(String(data.materi_id))}"]`)?.textContent || 'Materi', kunci: data.kunci_jawaban });
                alert('Soal kuis berhasil diperbarui.');
            } else if (data.pertanyaan.trim()) {
                const saved = await requestJson(storeSoalUrl, 'POST', data);
                daftarSoalKuis.push({ id: saved.id, materi_id: data.materi_id, materi: document.querySelector(`#materi_id option[value="${CSS.escape(String(data.materi_id))}"]`)?.textContent || 'Materi', pertanyaan: data.pertanyaan, opsi_a: data.opsi_a, opsi_b: data.opsi_b, opsi_c: data.opsi_c, opsi_d: data.opsi_d, kunci: data.kunci_jawaban, pembahasan: data.pembahasan });
                alert('Soal kuis berhasil disimpan ke database.');
            }
            renderTabelKuis();
            toggleModalKuis(false);
        } catch (error) { alert(error.message); }
    }

    document.addEventListener('DOMContentLoaded', renderTabelKuis);
</script>
@endsection