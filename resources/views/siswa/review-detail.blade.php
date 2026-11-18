@extends('layouts.siswa')

@section('title', 'EDUSAFE - Pembahasan Kuis')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/nilai.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="nilai-page-wrapper">
    <div class="nilai-container" style="max-width: 850px;">
        
        <!-- Tombol Navigasi Kembali -->
        <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('siswa.review') }}" style="color: #00288A; font-weight: 700; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                ← Kembali ke Pilih Pembahasan
            </a>
            <a href="{{ route('siswa.nilai') }}" style="color: #64748B; font-weight: 600; text-decoration: none; font-size: 13px;">
                Lihat Ringkasan Nilai →
            </a>
        </div>

        <!-- Banner Header Review Modul -->
        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <span class="badge-quiz">Modul {{ $nomorModul }} &bull; Review Pembahasan</span>
                <h2 style="margin: 8px 0 4px 0; font-size: 20px; color: #0F172A; font-weight: 800;">{{ $namaModul }}</h2>
                <p style="margin: 0; color: #64748B; font-size: 13px;">Tanggal Pengerjaan: <strong>{{ $tanggalPengerjaan }}</strong></p>
                @if($hasPengerjaan && count($daftarSoal) > 0)
                    <div style="margin-top: 8px; font-size: 13px; color: #475569;">
                        Hasil: <strong style="color: #10B981;">{{ $totalBenar }} Benar</strong> &bull; <strong style="color: #EF4444;">{{ $totalSalah }} Salah</strong> dari {{ count($daftarSoal) }} Soal
                    </div>
                @endif
            </div>
            <div style="text-align: right; background: #DDF0FF; padding: 12px 20px; border-radius: 12px; min-width: 120px;">
                <span style="font-size: 24px; font-weight: 800; color: #00288A;">
                    {{ $skor !== null ? $skor . ' / 100' : '- / 100' }}
                </span>
                <p style="margin: 0; font-size: 11px; font-weight: 700; color: #00288A; text-transform: uppercase;">Skor Akhir</p>
            </div>
        </div>

        @if(! $hasPengerjaan)
            <div style="background: #FEF3C7; border: 1px solid #FCD34D; color: #92400E; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 13px; line-height: 1.5;">
                ⚠️ <strong>Perhatian:</strong> Anda belum mengerjakan kuis untuk modul ini. Di bawah ini ditampilkan kunci jawaban dan pembahasan materi untuk referensi belajar Anda.
            </div>
        @endif

        <!-- List Pembahasan Soal-Soal -->
        @forelse($daftarSoal as $num => $soal)
            @php
                $jawabanUser = $jawabanUserMap[$num] ?? $jawabanUserMap[(string) $num] ?? null;
                $isBenar = ($jawabanUser !== null && strtoupper($jawabanUser) === strtoupper($soal['jawaban_benar']));
                $isDijawab = ($jawabanUser !== null);
            @endphp
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="font-weight: 800; color: #00288A; font-size: 13px;">SOAL NO. {{ $num }}</span>
                    @if(! $hasPengerjaan)
                        <span style="background: #E2E8F0; color: #475569; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700;">Kunci Jawaban</span>
                    @elseif($isBenar)
                        <span style="background: #D1FAE5; color: #065F46; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700;">Jawaban Benar (+{{ $poinPerSoal }})</span>
                    @else
                        <span style="background: #FEE2E2; color: #991B1B; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700;">Jawaban Salah (+0)</span>
                    @endif
                </div>

                <h3 style="font-size: 15px; color: #0F172A; line-height: 1.5; margin-bottom: 16px; font-weight: 700;">
                    {{ $soal['pertanyaan'] }}
                </h3>

                <!-- Opsi Jawaban A, B, C, D -->
                <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                    @foreach(['A', 'B', 'C', 'D'] as $opsiKey)
                        @php
                            $teksOpsi = $soal['opsi'][$opsiKey] ?? '';
                            $isUserChoice = ($jawabanUser !== null && strtoupper($jawabanUser) === $opsiKey);
                            $isCorrectChoice = (strtoupper($soal['jawaban_benar']) === $opsiKey);
                        @endphp

                        @if($isUserChoice && $isCorrectChoice)
                            <!-- Jawaban User Benar -->
                            <div style="padding: 12px 16px; border-radius: 10px; background: #D1FAE5; border: 1.5px solid #10B981; font-size: 13px; color: #065F46; font-weight: 700;">
                                {{ $opsiKey }}. {{ $teksOpsi }} <span style="margin-left: 6px; color: #047857;">✓ (Jawaban Anda Benar)</span>
                            </div>
                        @elseif($isUserChoice && ! $isCorrectChoice)
                            <!-- Jawaban User Salah -->
                            <div style="padding: 12px 16px; border-radius: 10px; background: #FEE2E2; border: 1.5px solid #EF4444; font-size: 13px; color: #991B1B; font-weight: 700;">
                                {{ $opsiKey }}. {{ $teksOpsi }} <span style="margin-left: 6px; color: #B91C1C;">✗ (Jawaban Anda)</span>
                            </div>
                        @elseif($isCorrectChoice && $hasPengerjaan)
                            <!-- Kunci Jawaban Benar (saat user salah/tidak jawab) -->
                            <div style="padding: 12px 16px; border-radius: 10px; background: #ECFDF5; border: 1.5px solid #34D399; font-size: 13px; color: #065F46; font-weight: 700;">
                                {{ $opsiKey }}. {{ $teksOpsi }} <span style="margin-left: 6px; color: #059669;">✓ (Kunci Jawaban Benar)</span>
                            </div>
                        @elseif($isCorrectChoice && ! $hasPengerjaan)
                            <!-- Kunci Jawaban Benar (belum pernah mengerjakan kuis) -->
                            <div style="padding: 12px 16px; border-radius: 10px; background: #ECFDF5; border: 1.5px solid #34D399; font-size: 13px; color: #065F46; font-weight: 700;">
                                {{ $opsiKey }}. {{ $teksOpsi }} <span style="margin-left: 6px; color: #059669;">✓ (Kunci Jawaban)</span>
                            </div>
                        @else
                            <!-- Opsi Netral -->
                            <div style="padding: 12px 16px; border-radius: 10px; background: #F8FAFC; border: 1px solid #E2E8F0; font-size: 13px; color: #475569;">
                                {{ $opsiKey }}. {{ $teksOpsi }}
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Teks Pembahasan dari Instruktur -->
                @if(! empty($soal['tips']))
                    <div style="background: #EBF3FF; border-left: 4px solid #00288A; padding: 16px; border-radius: 8px;">
                        <h4 style="margin: 0 0 6px 0; color: #00288A; font-size: 13px; font-weight: 800;">💡 Pembahasan Instruktur:</h4>
                        <p style="margin: 0; font-size: 13px; color: #334155; line-height: 1.6;">
                            {{ $soal['tips'] }}
                        </p>
                    </div>
                @endif
            </div>
        @empty
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 36px; text-align: center; color: #64748B;">
                <p style="margin: 0; font-size: 15px; font-weight: 600;">Belum ada bank soal yang tersedia untuk modul ini.</p>
                <p style="margin: 8px 0 0 0; font-size: 13px;">Silakan kembali ke <a href="{{ route('siswa.review') }}" style="color: #00288A; font-weight: 700;">Pilih Pembahasan</a> untuk modul lainnya.</p>
            </div>
        @endforelse

    </div>
</div>
@endsection