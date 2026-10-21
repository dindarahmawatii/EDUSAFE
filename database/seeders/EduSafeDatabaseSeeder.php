<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EduSafeDatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi data awal modul, kuis, dan bank soal.
     */
    public function run(): void
    {
        // 1. Seed Tabel Materi
        $materiData = [
            [
                'namamateri' => 'Pengenalan Malware & Ancaman Siber',
                'konten' => 'Malware (Malicious Software) adalah istilah umum untuk setiap perangkat lunak berbahaya yang sengaja dirancang untuk menyusup, merusak, atau mengeksploitasi sistem komputer tanpa izin pemiliknya.',
                'kategori' => 'Cybersecurity Fundamentals',
            ],
            [
                'namamateri' => 'Klasifikasi & Jenis-Jenis Malware',
                'konten' => 'Klasifikasi taksonomi malware mencakup Virus (memerlukan file inang), Worm (menyebar mandiri via jaringan), Trojan (menyamar sebagai aplikasi sah), Ransomware (enkripsi tebusan), Spyware, Adware, dan Rootkit.',
                'kategori' => 'Malware Analysis',
            ],
            [
                'namamateri' => 'Vektor Serangan & Mekanisme Infeksi',
                'konten' => 'Vektor transmisi malware memanfaatkan rekayasa sosial (Phishing/Spear Phishing), lampiran email jahat, drive-by downloads pada browser tidak ter-patch, media penyimpanan eksternal, dan eksploitasi celah zero-day.',
                'kategori' => 'Threat Intelligence',
            ],
            [
                'namamateri' => 'Cara Mengatasi & Mitigasi Malware',
                'konten' => 'SOP penanganan insiden darurat saat sistem terinfeksi malware: isolasi koneksi jaringan seketika, identifikasi proses mencurigakan, pemindaian via Anti-Malware mutakhir, eliminasi infeksi, serta audit integritas file sistem.',
                'kategori' => 'Incident Response',
            ],
            [
                'namamateri' => 'Upaya Pencegahan & Defense in Depth',
                'konten' => 'Menerapkan pendekatan Defense in Depth, manajemen pembaruan patch berkala pada OS dan software, konfigurasi firewall terukur, prinsip hak akses terendah (least privilege), serta edukasi kesadaran keamanan siber bagi pengguna.',
                'kategori' => 'System Hardening',
            ],
            [
                'namamateri' => 'Sejarah & Evolusi Malware Digital',
                'konten' => 'Evolusi malware dimulai dari eksperimen Creeper virus tahun 1971 pada ARPANET, penyebaran virus PC komersial pertama Brain tahun 1986, fenomena Morris Worm, hingga ancaman modern seperti ransomware terdesentralisasi dan malware berbasis AI.',
                'kategori' => 'Cyber History',
            ],
        ];

        foreach ($materiData as $index => $item) {
            $id = $index + 1;
            $exists = DB::table('materi')->where('idmateri', $id)->first();
            if (! $exists) {
                DB::table('materi')->insert(array_merge($item, [
                    'idmateri' => $id,
                    'created_at' => now(),
                ]));
            }
        }

        // 2. Seed Tabel Kuis
        $kuisExists = DB::table('kuis')->where('idkuis', 1)->first();
        if (! $kuisExists) {
            DB::table('kuis')->insert([
                'idkuis' => 1,
                'namakuis' => 'Kuis Evaluasi Malware & Keamanan Siber',
                'deskripsi' => 'Uji pemahaman komprehensif mengenai konsep dasar malware, klasifikasi ancaman siber, dan analisis respon mitigasi keamanan.',
                'waktuPengerjaan' => 15,
                'created_at' => now(),
            ]);
        }

        // 3. Seed Tabel Soal
        $soalList = [
            [
                'idsoal' => 1,
                'pertanyaan' => 'Apa definisi yang paling tepat mengenai Malware (Malicious Software) dalam konteks keamanan siber?',
                'pilihan_a' => 'Perangkat lunak berbahaya yang sengaja dirancang untuk merusak, mencuri data, atau mengeksploitasi sistem tanpa izin.',
                'pilihan_b' => 'Aplikasi resmi dari vendor sistem operasi untuk memperbarui patch keamanan perangkat.',
                'pilihan_c' => 'Software pengolah dokumen digital yang berjalan di lingkungan cloud.',
                'pilihan_d' => 'Protokol jaringan standar untuk meningkatkan kecepatan akses internet.',
                'jawaban_benar' => 'A',
            ],
            [
                'idsoal' => 2,
                'pertanyaan' => 'Jenis malware yang mampu mereplikasi dirinya secara mandiri dan menyebar melalui jaringan tanpa interaksi pengguna adalah...',
                'pilihan_a' => 'Worm',
                'pilihan_b' => 'Trojan Horse',
                'pilihan_c' => 'Adware',
                'pilihan_d' => 'Spyware',
                'jawaban_benar' => 'A',
            ],
            [
                'idsoal' => 3,
                'pertanyaan' => 'Malware yang menyamarkan dirinya sebagai aplikasi resmi atau berguna untuk menipu korban agar menginstalnya disebut...',
                'pilihan_a' => 'Trojan Horse',
                'pilihan_b' => 'Ransomware',
                'pilihan_c' => 'Rootkit',
                'pilihan_d' => 'Keylogger',
                'jawaban_benar' => 'A',
            ],
            [
                'idsoal' => 4,
                'pertanyaan' => 'Manakah dari berikut ini yang paling akurat mendeskripsikan ancaman "Ransomware"?',
                'pilihan_a' => 'Malware yang mengenkripsi file korban dan menuntut uang tebusan untuk mendapatkan kunci dekripsi.',
                'pilihan_b' => 'Program yang menampilkan iklan pop-up terus-menerus di web browser.',
                'pilihan_c' => 'Tool pemantau jaringan yang digunakan administrator untuk audit keamanan.',
                'pilihan_d' => 'Script otomatis untuk membersihkan temporary files di hard disk.',
                'jawaban_benar' => 'A',
            ],
            [
                'idsoal' => 5,
                'pertanyaan' => 'Malware tersembunyi yang merekam setiap ketukan tombol keyboard untuk mencuri kredensial akun dan password adalah...',
                'pilihan_a' => 'Keylogger',
                'pilihan_b' => 'Bootkit',
                'pilihan_c' => 'Logic Bomb',
                'pilihan_d' => 'Worm',
                'jawaban_benar' => 'A',
            ],
            [
                'idsoal' => 6,
                'pertanyaan' => 'Metode rekayasa sosial (Social Engineering) yang paling sering digunakan untuk menyebarkan malware melalui pesan atau email palsu adalah...',
                'pilihan_a' => 'Phishing',
                'pilihan_b' => 'SQL Injection',
                'pilihan_c' => 'Buffer Overflow',
                'pilihan_d' => 'Cross-Site Scripting (XSS)',
                'jawaban_benar' => 'A',
            ],
            [
                'idsoal' => 7,
                'pertanyaan' => 'Apa langkah mitigasi pertama yang wajib dilakukan saat sebuah komputer terindikasi kuat terinfeksi malware aktif?',
                'pilihan_a' => 'Segera putuskan koneksi jaringan (LAN/Wi-Fi) untuk mencegah transmisi lateral ke komputer lain.',
                'pilihan_b' => 'Mengirim salinan file terinfeksi ke rekan kerja melalui chat.',
                'pilihan_c' => 'Membiarkan perangkat tetap terhubung untuk menunggu instruksi hacker.',
                'pilihan_d' => 'Menghapus folder System32 secara manual.',
                'jawaban_benar' => 'A',
            ],
            [
                'idsoal' => 8,
                'pertanyaan' => 'Teknik analisis malware di mana sampel dieksekusi di dalam lingkungan terisolasi untuk dipantau perilakunya disebut...',
                'pilihan_a' => 'Analisis Dinamis (Dynamic Analysis / Sandboxing)',
                'pilihan_b' => 'Analisis Statis (Static Analysis)',
                'pilihan_c' => 'Reverse Engineering Manual',
                'pilihan_d' => 'Code Review Pasif',
                'jawaban_benar' => 'A',
            ],
            [
                'idsoal' => 9,
                'pertanyaan' => 'Tindakan pencegahan paling efektif untuk meminimalisir eksploitasi kerentanan keamanan oleh malware adalah...',
                'pilihan_a' => 'Rutin menerapkan pembaruan (patch) sistem operasi dan perangkat lunak secara berkala.',
                'pilihan_b' => 'Mematikan fitur proteksi antivirus agar performa komputer meningkat.',
                'pilihan_c' => 'Menggunakan password yang sama untuk seluruh akun layanan.',
                'pilihan_d' => 'Menginstal aplikasi bajakan dari situs tidak resmi.',
                'jawaban_benar' => 'A',
            ],
            [
                'idsoal' => 10,
                'pertanyaan' => 'Strategi pengamanan dengan menerapkan beberapa lapisan perlindungan di berbagai tingkatan sistem dikenal sebagai...',
                'pilihan_a' => 'Defense in Depth',
                'pilihan_b' => 'Single Point of Protection',
                'pilihan_c' => 'Open Trust Architecture',
                'pilihan_d' => 'Zero Tolerance Network',
                'jawaban_benar' => 'A',
            ],
        ];

        foreach ($soalList as $soal) {
            $exists = DB::table('soal')->where('idsoal', $soal['idsoal'])->first();
            if (! $exists) {
                DB::table('soal')->insert(array_merge($soal, [
                    'idkuis' => 1,
                ]));
            }
        }
    }
}
