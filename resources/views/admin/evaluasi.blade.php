@extends('layouts.admin')

@section('title', 'EDUSAFE - Kelola Evaluasi')

@section('content')
<div class="admin-page-wrapper">
    <div class="admin-container">
        
        <!-- Header Halaman -->
        <div style="margin-bottom: 25px;">
            <h1 class="admin-card-title" style="font-size: 24px; color: #00288A; margin-bottom: 6px;">Evaluasi Performa Pengguna</h1>
            <p style="color: #64748B; font-size: 14px; margin: 0;">Berikan penilaian dan umpan balik profesional untuk perkembangan akademik pengguna.</p>
        </div>

        <!-- Banner Info Pelajar -->
        <div class="admin-card" style="margin-bottom: 24px; background: #FFFFFF; border-left: 5px solid #00288A;">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div class="user-avatar-circle" style="width: 54px; height: 54px; font-size: 18px; font-weight: 800; background: #DDF0FF; color: #00288A;">RP</div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                            <h3 style="margin: 0; font-size: 18px; color: #0F172A; font-weight: 800;">Rizky Pratama</h3>
                            <span class="badge-status-blue">ACTIVE SCHOLAR</span>
                        </div>
                        <p style="margin: 0; font-size: 13px; color: #64748B;">ID: <strong>EDU-2024-089</strong> | Modul Terakhir: <strong>Malware Analysis Fundamentals</strong></p>
                    </div>
                </div>
                <div style="text-align: right; background: #F8FAFC; padding: 12px 20px; border-radius: 12px; border: 1px solid #E2E8F0;">
                    <span style="font-size: 26px; font-weight: 800; color: #00288A;">88%</span>
                    <p style="margin: 0; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">Rerata Kuis</p>
                </div>
            </div>
        </div>

        <!-- Form Catatan Evaluasi -->
        <div class="admin-card">
            <h3 class="admin-card-title" style="margin-bottom: 8px;">Catatan Instruktur & Rekomendasi</h3>
            <p style="font-size: 13px; color: #64748B; margin-top: 0; margin-bottom: 20px;">Berikan detail mendalam mengenai kelebihan dan area yang perlu difokuskan oleh siswa.</p>

            <form action="{{ route('admin.evaluasi') }}" method="GET">
                <div class="form-group" style="margin-bottom: 20px;">
                    <textarea rows="6" placeholder="Tuliskan evaluasi profesional Anda di sini..." style="line-height: 1.6;"></textarea>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #F1F5F9; padding-top: 20px;">
                    <p style="font-size: 12px; color: #64748B; margin: 0; max-width: 500px;">
                        💡 <em>Hasil evaluasi ini akan langsung tampil pada dashboard profil pengguna setelah dikirimkan secara resmi.</em>
                    </p>
                    <div style="display: flex; gap: 12px;">
                        <a href="{{ route('admin.dashboard') }}" class="btn-cancel" style="text-decoration: none; padding: 10px 20px; font-size: 13px;">Draf Evaluasi</a>
                        <button type="button" class="btn-primary-admin" style="padding: 10px 22px;">Simpan & Kirim Evaluasi</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection