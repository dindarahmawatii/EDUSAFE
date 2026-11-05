@extends('layouts.admin')

@section('title', 'EDUSAFE - Data Pelajar')

@section('content')
<div class="admin-page-wrapper">
    <div class="admin-container">
        
        <!-- Header Halaman -->
        <div class="flex-between" style="margin-bottom: 25px;">
            <div>
                <h1 class="admin-card-title" style="font-size: 24px; color: #00288A; margin-bottom: 6px;">Manajemen Data Pelajar</h1>
                <p style="color: #64748B; font-size: 14px; margin: 0;">Kelola informasi akun, progres modul, dan status keaktifan siswa EDUSAFE.</p>
            </div>
            <button class="btn-primary-admin">+ Tambah Pelajar Baru</button>
        </div>

        <!-- Tabel Ringkasan Pelajar dalam Card -->
        <div class="admin-card">
            <!-- Filter & Search Bar -->
            <div class="flex-between" style="margin-bottom: 20px; gap: 15px;">
                <input type="text" placeholder="🔍 Cari nama, NISN, atau email..." style="padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; width: 320px; font-size: 14px;">
                <div>
                    <select style="padding: 10px 14px; border: 1px solid #CBD5E1; border-radius: 8px; color: #475569; font-size: 14px; background: #FFFFFF;">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Inaktif</option>
                    </select>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Pelajar</th>
                            <th>ID / Email</th>
                            <th>Modul Selesai</th>
                            <th>Rerata Nilai</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelajarList ?? [] as $pelajar)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div class="user-avatar-circle">{{ $pelajar['initials'] }}</div>
                                        <strong style="color: #0F172A;">{{ $pelajar['name'] }}</strong>
                                    </div>
                                </td>
                                <td style="color: #64748B;">
                                    EDU-{{ str_pad((string) $pelajar['id'], 4, '0', STR_PAD_LEFT) }}<br>
                                    <small style="color: #94A3B8;">{{ $pelajar['email'] }}</small>
                                </td>
                                <td><strong>{{ $pelajar['modul_selesai'] }}</strong> / {{ $totalModul ?? 6 }} Modul</td>
                                <td><strong style="color: #00288A; font-size: 15px;">{{ $pelajar['rerata_nilai'] }}%</strong></td>
                                <td><span class="badge-status-green">{{ $pelajar['status'] }}</span></td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.evaluasi') }}" class="btn-cancel" style="padding: 6px 14px; font-size: 12px; text-decoration: none;">Evaluasi</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="table-empty" style="text-align: center; padding: 24px; color: #64748B;">
                                    Belum ada data pelajar yang terdaftar di database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection