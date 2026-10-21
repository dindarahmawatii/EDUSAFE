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

        <!-- Bagian Tabel Materi Populer -->
        <div class="admin-card">
            <div class="admin-card-header flex-between">
                <h3 class="admin-card-title">Materi Populer</h3>
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

        <div class="admin-card" style="margin-top: 30px;">
            <div class="admin-card-header flex-between">
                <div>
                    <h3 class="admin-card-title">Kelola Soal Kuis & Kunci Jawaban</h3>
                    <p style="color: #64748B; font-size: 13px; margin: 4px 0 0 0;">Atur pertanyaan kuis, pilihan ganda, dan kunci jawaban untuk evaluasi siswa.</p>
                </div>
                <button class="btn-primary-admin" onclick="toggleModalKuis(true)">+ Tambah Soal Kuis</button>
            </div>
            
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Pertanyaan Soal</th>
                            <th>Kategori Modul</th>
                            <th>Opsi Jawaban</th>
                            <th>Kunci Jawaban</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kuisList ?? [] as $kuis)
                            <tr>
                                <td><strong>{{ Str::limit($kuis->pertanyaan, 40) }}</strong></td>
                                <td>{{ $kuis->kategori }}</td>
                                <td>4 Pilihan (A, B, C, D)</td>
                                <td><span class="badge-status-green">Opsi {{ $kuis->kunci_jawaban }}</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px;">
                                        <button class="btn-cancel" style="padding: 4px 10px; font-size: 11px;">Edit</button>
                                        <button class="btn-cancel" style="padding: 4px 10px; font-size: 11px; color: #EF4444; border-color: #FCA5A5;">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="table-empty">
                                    Belum ada soal kuis di database. Silakan klik tombol "+ Tambah Soal Kuis" di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div id="modalTambahMateri" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Tambah Modul Materi Baru</h3>
            <span class="modal-close" onclick="toggleModal(false)">&times;</span>
        </div>

        <form action="{{ route('admin.materi.store') }}" method="POST">
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

<div id="modalTambahKuis" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Tambah Soal Kuis & Kunci Jawaban</h3>
            <span class="modal-close" onclick="toggleModalKuis(false)">&times;</span>
        </div>

        <form action="#" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Pertanyaan Soal</label>
                <textarea name="pertanyaan" rows="3" required placeholder="Tuliskan pertanyaan kuis di sini..."></textarea>
            </div>

            <div class="form-group">
                <label>Pilihan A</label>
                <input type="text" name="opsi_a" required placeholder="Jawaban pilihan A">
            </div>
            <div class="form-group">
                <label>Pilihan B</label>
                <input type="text" name="opsi_b" required placeholder="Jawaban pilihan B">
            </div>
            <div class="form-group">
                <label>Pilihan C</label>
                <input type="text" name="opsi_c" required placeholder="Jawaban pilihan C">
            </div>
            <div class="form-group">
                <label>Pilihan D</label>
                <input type="text" name="opsi_d" required placeholder="Jawaban pilihan D">
            </div>

            <div class="form-group">
                <label>Kunci Jawaban yang Benar</label>
                <select name="kunci_jawaban" style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 8px; background: #FFF;" required>
                    <option value="">-- Pilih Kunci Jawaban --</option>
                    <option value="A">Opsi A</option>
                    <option value="B">Opsi B</option>
                    <option value="C">Opsi C</option>
                    <option value="D">Opsi D</option>
                </select>
            </div>
            
            <div class="form-group" style="margin-top: 16px;">
                <label>Pembahasan / Penjelasan Jawaban</label>
                <textarea name="pembahasan" rows="3" required placeholder="Tuliskan alasan atau penjelasan kenapa jawaban tersebut yang paling tepat..."></textarea>
                <small>Pembahasan ini akan dibaca oleh siswa di halaman hasil kuis setelah mereka selesai mengerjakannya.</small>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="toggleModalKuis(false)">Batal</button>
                <button type="submit" class="btn-submit">Simpan Soal Kuis</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('modalTambahMateri').dataset.open === '1') {
            toggleModal(true);
        }
    });
    function toggleModal(show) {
        document.getElementById('modalTambahMateri').style.display = show ? 'flex' : 'none';
    }

    function toggleModalKuis(show) {
        document.getElementById('modalTambahKuis').style.display = show ? 'flex' : 'none';
    }
</script>
@endsection