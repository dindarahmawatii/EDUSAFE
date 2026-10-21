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

    </div>
</div>

<!-- ========================================== -->
<!-- MODAL POPUP FORM TAMBAH MATERI (TEKS)      -->
<!-- ========================================== -->
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

<script>
    function toggleModal(show) {
        document.getElementById('modalTambahMateri').style.display = show ? 'flex' : 'none';
    }
</script>
@endsection