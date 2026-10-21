@extends('layouts.siswa')

@section('title', 'EDUSAFE - Pengerjaan Kuis')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/kuis.css') }}?v={{ time() }}">
    <style>
        .question-card-item { display: none; }
        .question-card-item.active-step { display: block; }
        .btn-prev:disabled, .btn-prev[disabled] { opacity: 0.4; cursor: not-allowed; }
    </style>
@endpush

@section('content')
<div class="quiz-wrap">
    <div class="quiz-container">
        
        <!-- Bar Progress & Timer Atas -->
        <div class="quiz-top-bar">
            <div>
               <div class="quiz-progress-label">
                   <span>Progress Belajar : {{ $namaModul }}</span>
                   <strong id="progress-text">1 / {{ count($daftarSoal) }} Soal</strong>
               </div>
               <div class="quiz-progress-track">
                   <div class="quiz-progress-fill" id="progress-fill-bar" style="width: {{ 100 / count($daftarSoal) }}%;"></div>
               </div>
            </div>
            <div class="quiz-timer-box" id="timer-display">
                ⏱️ 15:00
            </div>
        </div>

        <form id="quiz-form" action="{{ route('siswa.kuis.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="materi_id" value="{{ $materiId }}">

            <!-- Grid Utama (Soal & Sidebar Navigasi) -->
            <div class="quiz-main-grid">
                
                <!-- Kolom Kiri: Soal & Opsi -->
                <div class="quiz-question-card">
                    @foreach($daftarSoal as $num => $soal)
                        <div class="question-card-item {{ $num === 1 ? 'active-step' : '' }}" 
                             id="question-step-{{ $num }}"
                             data-step="{{ $num }}"
                             data-tips="{{ $soal['tips'] }}"
                             data-modul="{{ $soal['modul_terkait'] }}">
                            
                            <span class="q-badge">PERTANYAAN {{ $num }}</span>
                            <h2 class="q-title">{{ $soal['pertanyaan'] }}</h2>
                            
                            <div class="options-stack">
                                @foreach($soal['opsi'] as $key => $opsiText)
                                    <label class="opt-card opt-card-{{ $num }}" data-num="{{ $num }}">
                                        <input type="radio" 
                                               name="jawaban_{{ $num }}" 
                                               value="{{ $key }}"
                                               style="accent-color: #00288A; width: 16px; height: 16px;"> 
                                        <span><strong>{{ $key }}.</strong> {{ $opsiText }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="quiz-card-footer">
                                <button type="button" 
                                        class="btn-prev" 
                                        onclick="navigasiSoal({{ $num - 1 }})" 
                                        {{ $num === 1 ? 'disabled style=opacity:0.4;cursor:not-allowed;' : '' }}>
                                    &larr; Sebelumnya
                                </button>
                                
                                <div class="quiz-action-right">
                                    <button type="button" 
                                            class="btn-ragu" 
                                            id="btn-ragu-{{ $num }}"
                                            onclick="toggleRagu({{ $num }})">
                                        Ragu-ragu
                                    </button>
                                    
                                    @if($num < count($daftarSoal))
                                        <button type="button" 
                                                class="btn-next" 
                                                onclick="navigasiSoal({{ $num + 1 }})">
                                            Simpan & Lanjut &rarr;
                                        </button>
                                    @else
                                        <button type="submit" 
                                                class="btn-next" 
                                                style="background: #10B981;">
                                            Simpan & Selesai &check;
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Kolom Kanan: Sidebar Navigasi -->
                <div class="quiz-sidebar">
                    <h3 class="sidebar-title">Navigasi Soal</h3>
                    
                    <div class="num-grid">
                        @foreach($daftarSoal as $num => $soal)
                            <div class="num-box {{ $num === 1 ? 'current' : '' }}" 
                                 id="num-nav-{{ $num }}"
                                 onclick="navigasiSoal({{ $num }})">
                                {{ $num }}
                            </div>
                        @endforeach
                    </div>

                    <div class="status-legend">
                        <span><i class="dot blue"></i> Terjawab (<strong id="count-terjawab">0</strong>)</span>
                        <span><i class="dot yellow"></i> Ragu (<strong id="count-ragu">0</strong>)</span>
                        <span><i class="dot gray"></i> Belum (<strong id="count-belum">{{ count($daftarSoal) }}</strong>)</span>
                    </div>

                    <button type="submit" class="btn-submit-quiz">
                        Selesaikan Kumpulan Kuis
                    </button>

                    <div class="sidebar-banner">
                        <small>{{ $namaModul }}</small>
                    </div>
                </div>

            </div>
        </form>

        <!-- Dua Card Bawah (Tips Ujian & Materi Terkait Dinamis) -->
        <div class="quiz-bottom-grid">
            <div class="info-card">
                <div class="info-title">💡 Tips Ujian</div>
                <p id="info-card-tips">{{ $daftarSoal[1]['tips'] ?? 'Pahami kata kunci pada pertanyaan.' }}</p>
            </div>
            <div class="info-card">
                <div class="info-title">📖 Materi Terkait</div>
                <p id="info-card-modul">{{ $daftarSoal[1]['modul_terkait'] ?? $namaModul }}</p>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const totalSoal = {{ count($daftarSoal) }};
    let currentStep = 1;
    const raguState = {};

    function updateStats() {
        let answered = 0;
        let raguCount = 0;

        for (let i = 1; i <= totalSoal; i++) {
            const hasChecked = document.querySelector('input[name="jawaban_' + i + '"]:checked');
            const navBtn = document.getElementById('num-nav-' + i);
            const isRagu = raguState[i] === true;

            if (isRagu) {
                raguCount++;
            }

            if (navBtn) {
                navBtn.classList.remove('done', 'ragu', 'current');
                if (i === currentStep) {
                    navBtn.classList.add('current');
                } else if (isRagu) {
                    navBtn.classList.add('ragu');
                } else if (hasChecked) {
                    navBtn.classList.add('done');
                }
            }

            if (hasChecked) {
                answered++;
            }
        }

        const countTerjawab = document.getElementById('count-terjawab');
        const countRagu = document.getElementById('count-ragu');
        const countBelum = document.getElementById('count-belum');

        if (countTerjawab) countTerjawab.innerText = answered;
        if (countRagu) countRagu.innerText = raguCount;
        if (countBelum) countBelum.innerText = Math.max(0, totalSoal - answered);

        const progressPercent = Math.round((currentStep / totalSoal) * 100);
        const fillBar = document.getElementById('progress-fill-bar');
        const progressText = document.getElementById('progress-text');
        if (fillBar) fillBar.style.width = progressPercent + '%';
        if (progressText) progressText.innerText = currentStep + ' / ' + totalSoal + ' Soal';
    }

    function navigasiSoal(step) {
        if (step < 1 || step > totalSoal) return;

        document.querySelectorAll('.question-card-item').forEach(el => el.classList.remove('active-step'));
        const nextTarget = document.getElementById('question-step-' + step);
        if (nextTarget) {
            nextTarget.classList.add('active-step');
            currentStep = step;

            const tips = nextTarget.getAttribute('data-tips');
            const modul = nextTarget.getAttribute('data-modul');
            const tipsEl = document.getElementById('info-card-tips');
            const modulEl = document.getElementById('info-card-modul');
            if (tipsEl && tips) tipsEl.innerText = tips;
            if (modulEl && modul) modulEl.innerText = modul;
        }

        updateStats();
    }

    function toggleRagu(step) {
        raguState[step] = !raguState[step];
        const btn = document.getElementById('btn-ragu-' + step);
        if (btn) {
            if (raguState[step]) {
                btn.style.background = '#F59E0B';
                btn.innerText = 'Batal Ragu';
            } else {
                btn.style.background = '#334155';
                btn.innerText = 'Ragu-ragu';
            }
        }
        updateStats();
    }

    // Event listener untuk radio button dan highlight option card
    document.querySelectorAll('.opt-card').forEach(card => {
        card.addEventListener('click', function(e) {
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                const num = this.getAttribute('data-num');
                document.querySelectorAll('.opt-card-' + num).forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                updateStats();
            }
        });
    });

    // Countdown Timer 15 Menit
    let remainingTime = 15 * 60; // 15 menit
    const timerDisplay = document.getElementById('timer-display');

    const timerInterval = setInterval(function() {
        if (remainingTime <= 0) {
            clearInterval(timerInterval);
            alert('Waktu pengerjaan kuis telah habis! Jawaban Anda akan otomatis dikirim.');
            document.getElementById('quiz-form').submit();
            return;
        }

        remainingTime--;
        const minutes = Math.floor(remainingTime / 60);
        const seconds = remainingTime % 60;
        if (timerDisplay) {
            timerDisplay.innerText = '⏱️ ' + 
                String(minutes).padStart(2, '0') + ':' + 
                String(seconds).padStart(2, '0');
        }
    }, 1000);

    // Initial sync
    updateStats();
</script>
@endpush