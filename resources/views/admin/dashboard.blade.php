@extends('layouts.admin')

@section('title', 'EDUSAFE - Dashboard Admin')

@section('content')
<div class="admin-page-wrapper">
    <div class="admin-container">

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
                    <h3 class="stat-value">86</h3>
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
                    <option value="Pengantar Malware Analysis">Pengantar Malware Analysis</option>
                    <option value="Static Analysis Techniques">Static Analysis Techniques</option>
                    <option value="Behavioral Analysis">Behavioral Analysis</option>
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
                <input type="text" name="judul" required placeholder="Contoh: Pengenalan Malware & Ancaman Siber">
            </div>

            <div class="form-group">
                <label>Kategori Modul</label>
                <input type="text" name="kategori" required placeholder="Contoh: Cybersecurity Dasar">
            </div>

            <div class="form-group">
                <label>Ringkasan / Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="2" required placeholder="Jelaskan ringkasan singkat isi modul..."></textarea>
            </div>

            <div class="form-group">
                <label>Isi Materi Lengkap (Format Teks)</label>
                <textarea name="konten" rows="6" required placeholder="Tulis atau ketik isi materi pembelajaran secara lengkap di sini..."></textarea>
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

        <form id="formKuis" action="#" method="POST" onsubmit="handleFormKuisSubmit(event)">
            @csrf
            <input type="hidden" id="editIndex" value="-1">
            
            <!-- 1. Pilih Materi Terkait -->
            <div class="form-group">
                <label>Pilih Modul / Materi Kuis</label>
                <select name="materi_id" id="materi_id" required style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 8px; background: #FFF;">
                    <option value="">-- Pilih Materi Pembelajaran --</option>
                    <option value="Pengantar Malware Analysis">Pengantar Malware Analysis</option>
                    <option value="Static Analysis Techniques">Static Analysis Techniques</option>
                    <option value="Behavioral Analysis">Behavioral Analysis</option>
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
    // Data Dummy Kuis Awal
    let daftarSoalKuis = [
        {
            materi: "Pengantar Malware Analysis",
            pertanyaan: "Apa fungsi utama dari teknik Dynamic Analysis dalam analisis malware?",
            opsi_a: "Memeriksa baris kode source tanpa mengesksekusi file",
            opsi_b: "Mengamati perilaku malware secara langsung saat dijalankan dalam lingkungan terisolasi (Sandbox)",
            opsi_c: "Dekripsi file yang telah terinfeksi ransomware",
            opsi_d: "Menghapus otomatis virus dari sistem registri Windows",
            kunci: "B",
            pembahasan: "Dynamic Analysis dilakukan dengan menjalankan file malware di dalam sistem terisolasi (sandbox)."
        },
        {
            materi: "Pengantar Malware Analysis",
            pertanyaan: "Metode mana yang digunakan untuk mengidentifikasi malware tanpa mengeksekusi kodenya?",
            opsi_a: "Behavioral Analysis",
            opsi_b: "Static Analysis",
            opsi_c: "Dynamic Analysis",
            opsi_d: "Memory Analysis",
            kunci: "B",
            pembahasan: "Static Analysis dilakukan dengan memeriksa struktur file, string, dan header tanpa menjalankannya."
        },
        {
            materi: "Static Analysis Techniques",
            pertanyaan: "Jenis malware apa yang mereplikasi dirinya sendiri melalui jaringan tanpa bantuan interaksi manusia?",
            opsi_a: "Trojan Horse",
            opsi_b: "Worm",
            opsi_c: "Adware",
            opsi_d: "Spyware",
            kunci: "B",
            pembahasan: "Worm dapat menyebar dan mereplikasi dirinya secara mandiri memanfaatkan celah keamanan jaringan."
        }
    ];

    // Fungsi Render Tabel dengan Filter Materi & Penomoran Urut per Materi
    function renderTabelKuis() {
        let tbody = document.getElementById('tbodySoalKuis');
        let selectedMateri = document.getElementById('filterMateri').value;
        tbody.innerHTML = '';

        let filteredData = daftarSoalKuis.filter(soal => {
            return selectedMateri === "SEMUA" || soal.materi === selectedMateri;
        });

        document.getElementById('badgeTotalSoal').innerText = `Total: ${filteredData.length} Soal`;

        if(filteredData.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="table-empty">
                        Belum ada soal kuis untuk materi ini. Silakan klik tombol "+ Tambah Soal Kuis" di atas.
                    </td>
                </tr>
            `;
            return;
        }

        filteredData.forEach((soal, index) => {
            let originalIndex = daftarSoalKuis.indexOf(soal);

            let row = `
                <tr>
                    <td><strong>Soal #${index + 1}</strong></td>
                    <td><span class="badge-status-blue">${soal.materi}</span></td>
                    <td><strong>${soal.pertanyaan.length > 45 ? soal.pertanyaan.substring(0, 45) + '...' : soal.pertanyaan}</strong></td>
                    <td><span class="badge-status-green">Opsi ${soal.kunci}</span></td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn-cancel" style="padding: 4px 10px; font-size: 11px;" onclick="editSoal(${originalIndex})">Edit</button>
                            <button type="button" class="btn-cancel" style="padding: 4px 10px; font-size: 11px; color: #EF4444; border-color: #FCA5A5;" onclick="hapusSoal(${originalIndex})">Hapus</button>
                        </div>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    // Modal Toggles
    function toggleModal(show) {
        document.getElementById('modalTambahMateri').style.display = show ? 'flex' : 'none';
    }

    function toggleModalKuis(show) {
        document.getElementById('modalTambahKuis').style.display = show ? 'flex' : 'none';
    }

    // Buka Modal Tambah Soal Kuis Baru
    function bukaModalTambahKuis() {
        document.getElementById('editIndex').value = "-1";
        document.getElementById('modalKuisTitle').innerText = "Tambah Soal Kuis";
        document.getElementById('labelNomorSoal').innerText = `Input Soal Beruntun`;
        document.getElementById('btnTambahBeruntun').style.display = "inline-block";
        document.getElementById('btnSimpanText').innerText = "Selesai & Simpan Kuis";
        document.getElementById('formKuis').reset();
        document.getElementById('materi_id').disabled = false;
        toggleModalKuis(true);
    }

    // Tombol + Soal Berikutnya (Simpan sementara & lanjut ke soal berikutnya)
    function simpanDanLanjut() {
        let materi = document.getElementById('materi_id').value;
        let pertanyaan = document.getElementById('pertanyaan').value;
        let kunci = document.getElementById('kunci_jawaban').value;

        if(!materi || !pertanyaan || !kunci) {
            alert("Mohon lengkapi Materi, Pertanyaan, dan Kunci Jawaban terlebih dahulu!");
            return;
        }

        // Masukkan ke array dummy
        daftarSoalKuis.push({
            materi: materi,
            pertanyaan: pertanyaan,
            opsi_a: document.getElementById('opsi_a').value,
            opsi_b: document.getElementById('opsi_b').value,
            opsi_c: document.getElementById('opsi_c').value,
            opsi_d: document.getElementById('opsi_d').value,
            kunci: kunci,
            pembahasan: document.getElementById('pembahasan').value
        });

        renderTabelKuis();
        
        // Kunci dropdown materi agar tidak berubah di tengah sesi input soal beruntun
        let selectedMateriValue = materi;
        document.getElementById('materi_id').disabled = true;

        alert(`Soal berhasil dimasukkan! Silakan lanjutkan isi soal berikutnya.`);

        // Reset form input soal saja
        document.getElementById('pertanyaan').value = '';
        document.getElementById('opsi_a').value = '';
        document.getElementById('opsi_b').value = '';
        document.getElementById('opsi_c').value = '';
        document.getElementById('opsi_d').value = '';
        document.getElementById('kunci_jawaban').value = '';
        document.getElementById('pembahasan').value = '';
        
        // Kembalikan nilai materi yang terkunci
        document.getElementById('materi_id').value = selectedMateriValue;
    }

    // Fungsi Edit Soal
    function editSoal(index) {
        let soal = daftarSoalKuis[index];
        
        document.getElementById('editIndex').value = index;
        document.getElementById('modalKuisTitle').innerText = "Edit Soal Kuis";
        document.getElementById('labelNomorSoal').innerText = `Editing Soal Index ke-${index + 1}`;
        document.getElementById('btnTambahBeruntun').style.display = "none"; // Sembunyikan tombol + saat edit
        document.getElementById('btnSimpanText').innerText = "Update Soal";
        document.getElementById('materi_id').disabled = false;

        document.getElementById('materi_id').value = soal.materi;
        document.getElementById('pertanyaan').value = soal.pertanyaan;
        document.getElementById('opsi_a').value = soal.opsi_a;
        document.getElementById('opsi_b').value = soal.opsi_b;
        document.getElementById('opsi_c').value = soal.opsi_c;
        document.getElementById('opsi_d').value = soal.opsi_d;
        document.getElementById('kunci_jawaban').value = soal.kunci;
        document.getElementById('pembahasan').value = soal.pembahasan;

        toggleModalKuis(true);
    }

    // Fungsi Hapus Soal
    function hapusSoal(index) {
        if(confirm(`Apakah Anda yakin ingin menghapus soal ini?`)) {
            daftarSoalKuis.splice(index, 1);
            renderTabelKuis();
        }
    }

    // Handle Form Submit (Tombol Selesai & Simpan atau Update)
    function handleFormKuisSubmit(e) {
        e.preventDefault();
        
        let editIdx = parseInt(document.getElementById('editIndex').value);
        let materi = document.getElementById('materi_id').value;
        let pertanyaan = document.getElementById('pertanyaan').value;
        let kunci = document.getElementById('kunci_jawaban').value;

        if(!materi) {
            alert("Silakan pilih materi terlebih dahulu!");
            return;
        }

        if(editIdx > -1) {
            // Mode Update Data
            daftarSoalKuis[editIdx] = {
                materi: materi,
                pertanyaan: pertanyaan,
                opsi_a: document.getElementById('opsi_a').value,
                opsi_b: document.getElementById('opsi_b').value,
                opsi_c: document.getElementById('opsi_c').value,
                opsi_d: document.getElementById('opsi_d').value,
                kunci: kunci,
                pembahasan: document.getElementById('pembahasan').value
            };
            alert("Soal kuis berhasil diperbarui!");
        } else {
            // Mode Simpan Final (jika form terakhir diisi lalu klik Selesai & Simpan)
            if(pertanyaan && kunci) {
                daftarSoalKuis.push({
                    materi: materi,
                    pertanyaan: pertanyaan,
                    opsi_a: document.getElementById('opsi_a').value,
                    opsi_b: document.getElementById('opsi_b').value,
                    opsi_c: document.getElementById('opsi_c').value,
                    opsi_d: document.getElementById('opsi_d').value,
                    kunci: kunci,
                    pembahasan: document.getElementById('pembahasan').value
                });
            }
            alert("Kumpulan soal kuis berhasil disimpan secara permanen (Simulasi Dummy)!");
        }

        renderTabelKuis();
        toggleModalKuis(false);
    }

    // Inisialisasi saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        renderTabelKuis();
    });
</script>
@endsection