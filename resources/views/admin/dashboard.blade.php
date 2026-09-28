@extends('layouts.admin')

@section('title', 'EDUSAFE - Dashboard Admin')

@section('content')
<div class="container">
    <!-- 4 Kotak Statistik Utama -->
    <div class="grid grid-4" style="grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
        <div class="card" style="background: #EBF3FF;">
            <div class="flex-between" style="margin-bottom: 10px;">
                <div style="background: var(--primary); color: white; width: 30px; height: 30px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">👤</div>
                <span style="font-size: 12px; color: #10B981; font-weight: bold;">+12% &uarr;</span>
            </div>
            <p style="font-size: 13px; color: var(--text-muted);">Total User</p>
            <h2 style="font-size: 32px; color: var(--primary);">1,284</h2>
        </div>
        
        <div class="card" style="background: #EBF3FF;">
            <div class="flex-between" style="margin-bottom: 10px;">
                <div style="background: var(--primary); color: white; width: 30px; height: 30px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">📖</div>
                <span style="font-size: 12px; color: #10B981; font-weight: bold;">+5% &uarr;</span>
            </div>
            <p style="font-size: 13px; color: var(--text-muted);">Jumlah Materi</p>
            <h2 style="font-size: 32px; color: var(--primary);">86</h2>
        </div>

        <div class="card" style="background: #EBF3FF;">
            <div class="flex-between" style="margin-bottom: 10px;">
                <div style="background: #475569; color: white; width: 30px; height: 30px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">⭐</div>
                <span style="font-size: 12px; color: #EF4444; font-weight: bold;">-2% &darr;</span>
            </div>
            <p style="font-size: 13px; color: var(--text-muted);">Rata-rata Nilai</p>
            <h2 style="font-size: 32px; color: var(--primary);">78.5</h2>
        </div>

        <div class="card" style="background: #EBF3FF;">
            <div class="flex-between" style="margin-bottom: 10px;">
                <div style="background: #1E293B; color: white; width: 30px; height: 30px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">⏱️</div>
                <span style="font-size: 12px; color: #10B981; font-weight: bold;">Active</span>
            </div>
            <p style="font-size: 13px; color: var(--text-muted);">Kuis Berjalan</p>
            <h2 style="font-size: 32px; color: var(--primary);">24</h2>
        </div>
    </div>

    <!-- Bagian User Terbaru -->
    <div class="card" style="margin-bottom: 30px;">
        <h3 style="margin-bottom: 20px;">User Terbaru</h3>
        
        <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="background: #EBF3FF; color: var(--primary); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">JD</div>
                <div>
                    <div style="font-size: 14px; font-weight: bold;">Jane Doe</div>
                    <div style="font-size: 12px; color: var(--text-muted);">Baru saja bergabung</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="background: #EBF3FF; color: var(--primary); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">AS</div>
                <div>
                    <div style="font-size: 14px; font-weight: bold;">Andi Saputra</div>
                    <div style="font-size: 12px; color: var(--text-muted);">2 jam yang lalu</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="background: #EBF3FF; color: var(--primary); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">RK</div>
                <div>
                    <div style="font-size: 14px; font-weight: bold;">Rina Kartika</div>
                    <div style="font-size: 12px; color: var(--text-muted);">5 jam yang lalu</div>
                </div>
            </div>
        </div>
        
        <a href="{{ url('/data-pelajar') }}" class="btn btn-outline" style="width: 100%; text-align: center; display: block; border-radius: 8px;">Lihat Semua User</a>
    </div>

    <!-- Bagian Tabel Materi Populer -->
    <div class="card" style="margin-bottom: 20px;">
        <div class="flex-between" style="margin-bottom: 20px;">
            <h3>Materi Populer</h3>
            <button class="btn">+ Tambah Materi</button>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border); color: var(--text-muted); text-align: left;">
                        <th style="padding: 15px;">Nama Materi</th>
                        <th style="padding: 15px;">Kategori</th>
                        <th style="padding: 15px;">Peserta</th>
                        <th style="padding: 15px;">Tingkat Kesulitan</th>
                        <th style="padding: 15px;">Status</th>
                        <th style="padding: 15px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 15px;">Dasar-Dasar Malware Analysis</td>
                        <td style="padding: 15px;">Cybersecurity</td>
                        <td style="padding: 15px;">420</td>
                        <td style="padding: 15px;"><span class="badge" style="background: #DBEAFE; color: #1D4ED8;">Menengah</span></td>
                        <td style="padding: 15px; color: #10B981; font-weight: bold;">Aktif</td>
                        <td style="padding: 15px; cursor: pointer; color: var(--text-muted);">⋮</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 15px;">Reverse Engineering Part 1</td>
                        <td style="padding: 15px;">Security Engineering</td>
                        <td style="padding: 15px;">215</td>
                        <td style="padding: 15px;"><span class="badge" style="background: #FEE2E2; color: #B91C1C;">Lanjutan</span></td>
                        <td style="padding: 15px; color: #10B981; font-weight: bold;">Aktif</td>
                        <td style="padding: 15px; cursor: pointer; color: var(--text-muted);">⋮</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 15px;">Pengantar Trojan & Worms</td>
                        <td style="padding: 15px;">Malware History</td>
                        <td style="padding: 15px;">1,024</td>
                        <td style="padding: 15px;"><span class="badge" style="background: #E0E7FF; color: #4338CA;">Pemula</span></td>
                        <td style="padding: 15px; color: var(--text-muted); font-weight: bold;">Draft</td>
                        <td style="padding: 15px; cursor: pointer; color: var(--text-muted);">⋮</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection