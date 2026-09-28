@extends('layouts.app')

@section('title', 'EDUSAFE - Kuis')

@section('content')
<div class="container">
    <div class="grid" style="grid-template-columns: 3fr 1fr; align-items: start; gap: 20px;">
        <div>
            <div class="card" style="background: #EBF3FF; border: none; padding: 30px;">
                <div class="badge" style="background: var(--primary); color: white; margin-bottom: 15px;">PERTANYAAN 7</div>
                <h2 style="color: var(--primary); margin-bottom: 25px;">Manakah dari berikut ini yang paling akurat mendeskripsikan "Ransomware" dalam konteks keamanan siber?</h2>
                
                <div class="card" style="margin-bottom: 15px; cursor: pointer;">
                    <input type="radio" name="q7" id="a"> <label for="a" style="margin-left: 10px;">Program yang mereplikasi diri secara otomatis...</label>
                </div>
                <div class="card" style="margin-bottom: 15px; border: 2px solid var(--primary); cursor: pointer;">
                    <input type="radio" name="q7" id="b" checked> <label for="b" style="margin-left: 10px; font-weight: bold;">Malware yang mengenkripsi file pengguna dan menuntut pembayaran...</label>
                </div>
                
                <div class="flex-between" style="margin-top: 30px;">
                    <a href="#" style="color: var(--primary); font-weight: bold;">&larr; Sebelumnya</a>
                    <div>
                        <button class="btn" style="background: #475569; margin-right: 10px;">Ragu-ragu</button>
                        <a href="{{ route('siswa.nilai') }}" class="btn">Simpan & Lanjut</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 15px; font-size: 16px;">Navigasi Soal</h3>
            <div class="grid" style="grid-template-columns: repeat(5, 1fr); gap: 8px; margin-bottom: 20px; text-align: center;">
                <div style="background: var(--primary); color: white; padding: 10px; border-radius: 4px;">1</div>
                <div style="background: var(--primary); color: white; padding: 10px; border-radius: 4px;">2</div>
                <div style="background: var(--primary); color: white; padding: 10px; border-radius: 4px;">3</div>
                <div style="background: var(--primary); color: white; padding: 10px; border-radius: 4px;">4</div>
                <div style="background: white; border: 1px solid var(--primary); color: var(--primary); padding: 10px; border-radius: 4px;">7</div>
            </div>
            <a href="{{ route('siswa.nilai') }}" class="btn" style="background: #EBF3FF; color: var(--primary); width: 100%; display: block; text-align: center;">Selesai & Kumpulkan</a>
        </div>
    </div>
</div>
@endsection