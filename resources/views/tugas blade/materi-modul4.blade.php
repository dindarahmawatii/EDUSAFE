@extends('layouts.master')

@section('title', 'Daftar Materi Malware')

@section('content')
<h3>Daftar Materi Pembelajaran</h3>

<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Modul</th>
            <th>Judul Materi</th>
            <th>Deskripsi</th>
            <th>Durasi</th>
            <th>Tipe Materi</th>
        </tr>
    </thead>
    <tbody>
        <!-- 1. Perulangan Foreach untuk Array Multidimensi -->
        @foreach ($materiList as $materi)
        <tr>
            <td>{{ $materi['modul'] }}</td>
            <td>{{ $materi['judul'] }}</td>
            <td>{{ $materi['deskripsi'] }}</td>
            <td>{{ $materi['durasi'] }}</td>
            <td>
                {{-- 2. Kondisional untuk Tipe Materi --}}
                @if($materi['tipe'] == 'dasar')
                    <span style="color: green; font-weight: bold;">
                        {{ strtoupper($materi['tipe']) }}
                    </span>
                @elseif($materi['tipe'] == 'utama')
                    <span style="color: blue; font-weight: bold;">
                        {{ strtoupper($materi['tipe']) }}
                    </span>
                @else
                    <span style="color: darkred; font-weight: bold;">
                        {{ strtoupper($materi['tipe']) }}
                    </span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection