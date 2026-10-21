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
                        <!-- Row 1 -->
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="user-avatar-circle">RP</div>
                                    <strong style="color: #0F172A;">Rizky Pratama</strong>
                                </div>
                            </td>
                            <td style="color: #64748B;">
                                EDU-2024-089<br>
                                <small style="color: #94A3B8;">rizky@gmail.com</small>
                            </td>
                            <td><strong>12</strong> / 15 Modul</td>
                            <td><strong style="color: #00288A; font-size: 15px;">88%</strong></td>
                            <td><span class="badge-status-green">Aktif</span></td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.evaluasi') }}" class="btn-cancel" style="padding: 6px 14px; font-size: 12px; text-decoration: none;">Evaluasi</a>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="user-avatar-circle">JD</div>
                                    <strong style="color: #0F172A;">Jane Doe</strong>
                                </div>
                            </td>
                            <td style="color: #64748B;">
                                EDU-2024-090<br>
                                <small style="color: #94A3B8;">jane.doe@gmail.com</small>
                            </td>
                            <td><strong>5</strong> / 15 Modul</td>
                            <td><strong style="color: #00288A; font-size: 15px;">75%</strong></td>
                            <td><span class="badge-status-green">Aktif</span></td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.evaluasi') }}" class="btn-cancel" style="padding: 6px 14px; font-size: 12px; text-decoration: none;">Evaluasi</a>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="user-avatar-circle">AS</div>
                                    <strong style="color: #0F172A;">Andi Saputra</strong>
                                </div>
                            </td>
                            <td style="color: #64748B;">
                                EDU-2024-091<br>
                                <small style="color: #94A3B8;">andi@gmail.com</small>
                            </td>
                            <td><strong>8</strong> / 15 Modul</td>
                            <td><strong style="color: #00288A; font-size: 15px;">82%</strong></td>
                            <td><span class="badge-status-red" style="background: #FEF3C7; color: #92400E;">Inaktif 3 Hari</span></td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.evaluasi') }}" class="btn-cancel" style="padding: 6px 14px; font-size: 12px; text-decoration: none;">Evaluasi</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection