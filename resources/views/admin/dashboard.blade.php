@extends('layouts.admin')

@section('title', 'EDUSAFE - Dashboard Admin')

@section('content')
<div class="container">
    <!-- 4 Kotak Statistik Utama (Tetap Seperti Semula) -->
    <div class="grid grid-4" style="grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
        <!-- ... Statistik Cards ... -->
    </div>

    <!-- Bagian User Terbaru (Tetap Seperti Semula) -->
    <div class="card" style="margin-bottom: 30px;">
        <!-- ... User Terbaru Content ... -->
    </div>

    <!-- Bagian Tabel Materi Populer -->
    <div class="card" style="margin-bottom: 20px;">
        <div class="flex-between" style="margin-bottom: 20px;">
            <h3>Materi Populer</h3>
            <!-- Tombol Pemicu Modal -->
            <button class="btn" onclick="toggleModal(true)">+ Tambah Materi</button>
        </div>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border); color: var(--text-muted); text-align: left;">
                        <th style="padding: 15px;">Nama Materi</th>
                        <th style="padding: 15px;">Kategori</th>
                        <th style="padding: 15px;">Dokumen PDF</th>
                        <th style="padding: 15px;">Status</th>
                        <th style="padding: 15px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materiList ?? [] as $materi)
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 15px;">{{ $materi->judul }}</td>
                            <td style="padding: 15px;">{{ $materi->kategori }}</td>
                            <td style="padding: 15px;">
                                @if($materi->file_pdf)
                                    <span class="badge" style="background: #EBF3FF; color: var(--primary);">📄 Tersedia</span>
                                @else
                                    <span class="badge" style="background: #FEE2E2; color: #B91C1C;">Kosong</span>
                                @endif
                            </td>
                            <td style="padding: 15px; color: #10B981; font-weight: bold;">Aktif</td>
                            <td style="padding: 15px; cursor: pointer; color: var(--text-muted);">⋮</td>
                        </tr>
                    @empty
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td colspan="5" style="padding: 15px; text-align: center; color: var(--text-muted);">Belum ada materi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL POPUP FORM TAMBAH MATERI PDF         -->
<!-- ========================================== -->
<div id="modalTambahMateri" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div class="card" style="width: 520px; max-width: 90%; background: white; border-radius: 12px; padding: 30px;">
        <div class="flex-between" style="margin-bottom: 20px;">
            <h3 style="color: var(--primary); margin: 0;">Tambah Materi & Upload PDF</h3>
            <span onclick="toggleModal(false)" style="cursor: pointer; font-size: 20px; font-weight: bold; color: var(--text-muted);">&times;</span>
        </div>

        <form action="{{ route('admin.materi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="input-group">
                <label>Judul Materi</label>
                <input type="text" name="judul" required placeholder="Contoh: Pengenalan Malware & Ancaman Siber">
            </div>

            <div class="input-group">
                <label>Kategori</label>
                <input type="text" name="kategori" required placeholder="Contoh: Cybersecurity Fundamentals">
            </div>

            <div class="input-group">
                <label>Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" required placeholder="Jelaskan ringkasan isi modul..."></textarea>
            </div>

            <!-- Input File PDF -->
            <div class="input-group">
                <label>Upload File PDF Materi</label>
                <input type="file" name="file_pdf" accept=".pdf" required style="padding: 8px;">
                <small style="color: var(--text-muted); font-size: 11px;">Format wajib .PDF (Maksimal 10MB)</small>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
                <button type="button" class="btn btn-outline" onclick="toggleModal(false)">Batal</button>
                <button type="submit" class="btn">Simpan & Upload</button>
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