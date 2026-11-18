@extends('layouts.siswa')

@section('title', 'EDUSAFE - Pembahasan Kuis')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/nilai.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="nilai-page-wrapper">
    <div class="nilai-container" style="max-width: 850px;">
        
        <!-- Navigation Back -->
        <div style="margin-bottom: 20px;">
            <a href="{{ route('siswa.nilai') }}" style="color: #00288A; font-weight: 700; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                ← Kembali ke Ringkasan Nilai
            </a>
        </div>

        <!-- Banner Detail Kuis -->
        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span class="badge-quiz">Review Pembahasan</span>
                <h2 style="margin: 8px 0 4px 0; font-size: 20px; color: #0F172A;">Malware Analysis Fundamentals</h2>
                <p style="margin: 0; color: #64748B; font-size: 13px;">Tanggal Pengerjaan: 24 Oktober 2026</p>
            </div>
            <div style="text-align: right; background: #DDF0FF; padding: 12px 20px; border-radius: 12px;">
                <span style="font-size: 24px; font-weight: 800; color: #00288A;">90 / 100</span>
                <p style="margin: 0; font-size: 11px; font-weight: 700; color: #00288A; text-transform: uppercase;">Skor Akhir</p>
            </div>
        </div>

        <!-- Soal 1 -->
        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-weight: 800; color: #00288A; font-size: 13px;">SOAL NO. 1</span>
                <span style="background: #D1FAE5; color: #065F46; padding: 2px 10px; border-radius: 6px; font-size: 11px; font-weight: 700;">Jawaban Benar (+10)</span>
            </div>
            <h3 style="font-size: 15px; color: #0F172A; line-height: 1.5; margin-bottom: 16px;">
                Apa fungsi utama dari teknik Dynamic Analysis dalam analisis malware?
            </h3>

            <!-- Opsi Jawaban -->
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                <div style="padding: 12px 16px; border-radius: 10px; background: #F8FAFC; border: 1px solid #E2E8F0; font-size: 13px; color: #475569;">
                    A. Memeriksa baris kode source tanpa mengesksekusi file.
                </div>
                <div style="padding: 12px 16px; border-radius: 10px; background: #D1FAE5; border: 1px solid #10B981; font-size: 13px; color: #065F46; font-weight: 700;">
                    B. Mengamati perilaku malware secara langsung saat dijalankan dalam lingkungan terisolasi (Sandbox). ✓ (Jawaban Anda)
                </div>
                <div style="padding: 12px 16px; border-radius: 10px; background: #F8FAFC; border: 1px solid #E2E8F0; font-size: 13px; color: #475569;">
                    C. Dekripsi file yang telah terinfeksi ransomware.
                </div>
                <div style="padding: 12px 16px; border-radius: 10px; background: #F8FAFC; border: 1px solid #E2E8F0; font-size: 13px; color: #475569;">
                    D. Menghapus otomatis virus dari sistem registri Windows.
                </div>
            </div>

            <!-- Teks Pembahasan dari Admin -->
            <div style="background: #EBF3FF; border-left: 4px solid #00288A; padding: 16px; border-radius: 8px;">
                <h4 style="margin: 0 0 6px 0; color: #00288A; font-size: 13px; font-weight: 800;">💡 Pembahasan Instruktur:</h4>
                <p style="margin: 0; font-size: 13px; color: #334155; line-height: 1.6;">
                    Dynamic Analysis dilakukan dengan menjalankan file malware di dalam sistem terisolasi (sandbox) untuk mengamati aktivitas nyata seperti perubahan registry, lalu lintas jaringan, dan modifikasi file.
                </p>
            </div>
        </div>

        <!-- Soal 2 (Contoh Jawaban Salah) -->
        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-weight: 800; color: #00288A; font-size: 13px;">SOAL NO. 2</span>
                <span style="background: #FEE2E2; color: #991B1B; padding: 2px 10px; border-radius: 6px; font-size: 11px; font-weight: 700;">Jawaban Salah (+0)</span>
            </div>
            <h3 style="font-size: 15px; color: #0F172A; line-height: 1.5; margin-bottom: 16px;">
                Jenis malware apa yang mereplikasi dirinya sendiri ke komputer lain melalui jaringan tanpa bantuan interaksi manusia?
            </h3>

            <!-- Opsi Jawaban -->
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                <div style="padding: 12px 16px; border-radius: 10px; background: #FEE2E2; border: 1px solid #EF4444; font-size: 13px; color: #991B1B;">
                    A. Trojan Horse ✗ (Jawaban Anda)
                </div>
                <div style="padding: 12px 16px; border-radius: 10px; background: #D1FAE5; border: 1px solid #10B981; font-size: 13px; color: #065F46; font-weight: 700;">
                    B. Worm ✓ (Kunci Jawaban Benar)
                </div>
                <div style="padding: 12px 16px; border-radius: 10px; background: #F8FAFC; border: 1px solid #E2E8F0; font-size: 13px; color: #475569;">
                    C. Adware
                </div>
                <div style="padding: 12px 16px; border-radius: 10px; background: #F8FAFC; border: 1px solid #E2E8F0; font-size: 13px; color: #475569;">
                    D. Spyware
                </div>
            </div>

            <!-- Teks Pembahasan dari Admin -->
            <div style="background: #EBF3FF; border-left: 4px solid #00288A; padding: 16px; border-radius: 8px;">
                <h4 style="margin: 0 0 6px 0; color: #00288A; font-size: 13px; font-weight: 800;">💡 Pembahasan Instruktur:</h4>
                <p style="margin: 0; font-size: 13px; color: #334155; line-height: 1.6;">
                    Worm berbeda dari Trojan. Worm dapat menyebar dan mereplikasi dirinya secara mandiri memanfaatkan celah keamanan jaringan tanpa membutuhkan eksekusi pengguna.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection