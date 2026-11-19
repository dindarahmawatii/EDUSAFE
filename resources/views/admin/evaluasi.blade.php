@extends('layouts.admin')

@section('title', 'EDUSAFE - Kelola Evaluasi')

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

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <div>
                <h1 class="admin-card-title" style="font-size: 24px; color: #00288A; margin-bottom: 6px;">Evaluasi Performa Pengguna</h1>
                <p style="color: #64748B; font-size: 14px; margin: 0;">Berikan penilaian dan umpan balik profesional untuk perkembangan akademik pengguna.</p>
            </div>
        </div>

        @if(! $siswa)
            <!-- Belum ada siswa yang dipilih -->
            <div class="admin-card" style="text-align:center; padding: 40px 20px;">
                <h3 style="margin: 0 0 8px; color: #0F172A;">Belum ada pelajar yang dipilih</h3>
                <p style="margin: 0 0 20px; color: #64748B; font-size: 14px;">Pilih pelajar dari halaman Data Pelajar, lalu klik tombol "Evaluasi".</p>
                <a href="{{ route('admin.data-pelajar') }}" class="btn-primary-admin" style="text-decoration:none; padding: 10px 24px;">Ke Data Pelajar</a>
            </div>
        @else
            <!-- Banner Info Pelajar (dinamis per siswa) -->
            <div class="admin-card" style="margin-bottom: 24px; background: #FFFFFF; border-left: 5px solid #00288A;">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div class="user-avatar-circle" style="width: 54px; height: 54px; font-size: 18px; font-weight: 800; background: #DDF0FF; color: #00288A;">{{ $siswa->initials }}</div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                                <h3 style="margin: 0; font-size: 18px; color: #0F172A; font-weight: 800;">{{ $siswa->name }}</h3>
                                <span class="badge-status-blue">ACTIVE SCHOLAR</span>
                            </div>
                            <p style="margin: 0; font-size: 13px; color: #64748B;">
                                ID: <strong>EDU-{{ str_pad((string) $siswa->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                | Modul Terakhir: <strong>{{ $modulTerakhir ?? 'Belum ada modul yang dibaca' }}</strong>
                            </p>
                        </div>
                    </div>
                    <div style="text-align: right; background: #F8FAFC; padding: 12px 20px; border-radius: 12px; border: 1px solid #E2E8F0;">
                        <span style="font-size: 26px; font-weight: 800; color: #00288A;">{{ $rerataNilai !== null ? $rerataNilai . '%' : '-' }}</span>
                        <p style="margin: 0; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">Rerata Kuis</p>
                    </div>
                </div>
            </div>

            <!-- Form Catatan Evaluasi -->
            <div class="admin-card">
                <h3 class="admin-card-title" style="margin-bottom: 8px;">Catatan Instruktur & Rekomendasi</h3>
                <p style="font-size: 13px; color: #64748B; margin-top: 0; margin-bottom: 20px;">Berikan detail mendalam mengenai kelebihan dan area yang perlu difokuskan oleh siswa.</p>

                <form method="POST" action="{{ route('admin.evaluasi.store', $siswa->id) }}">
                    @csrf
                    <div class="form-group" style="margin-bottom: 20px;">
                        <textarea name="catatan" rows="6" placeholder="Tuliskan evaluasi profesional Anda di sini..." style="line-height: 1.6;" required maxlength="5000">{{ old('catatan') }}</textarea>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #F1F5F9; padding-top: 20px;">
                        <p style="font-size: 12px; color: #64748B; margin: 0; max-width: 500px;">
                            💡 <em>Hasil evaluasi ini akan langsung tampil pada halaman evaluasi {{ $siswa->name }} setelah dikirimkan.</em>
                        </p>
                        <div>
                            <button type="submit" class="btn-primary-admin" style="padding: 10px 24px;">Simpan & Kirim Evaluasi</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Riwayat Evaluasi -->
            <div class="admin-card" style="margin-top: 24px;">
                <h3 class="admin-card-title" style="margin-bottom: 16px;">Riwayat Evaluasi</h3>
                @forelse($riwayatEvaluasi as $i => $item)
                    <div style="padding: 14px 0; {{ ! $loop->last ? 'border-bottom: 1px solid #F1F5F9;' : '' }}">
                        <div style="display:flex; justify-content:space-between; gap:12px; margin-bottom:6px;">
                            <small style="color:#94A3B8;">{{ optional($item->created_at)->format('d M Y, H:i') }}</small>
                            @if($loop->first)
                                <span class="badge-status-green">Tampil di halaman siswa</span>
                            @endif
                        </div>
                        <p style="margin:0; font-size:14px; color:#0F172A; line-height:1.6; white-space:pre-line;">{{ $item->catatan }}</p>
                    </div>
                @empty
                    <p style="margin:0; font-size:13px; color:#64748B;">Belum ada evaluasi untuk pelajar ini.</p>
                @endforelse
            </div>
        @endif

    </div>
</div>
@endsection
