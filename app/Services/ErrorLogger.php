<?php

namespace App\Services;

use App\Models\ErrorLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Throwable;

class ErrorLogger
{
    /**
     * Catat dan simpan log error ke database dan file teks (.txt) di storage lokal.
     */
    public static function log(Throwable $e): ?ErrorLog
    {
        try {
            $waktu = now()->format('Y-m-d H:i:s');
            $message = $e->getMessage() !== '' ? $e->getMessage() : get_class($e);
            $exceptionClass = get_class($e);
            $file = $e->getFile();
            $line = $e->getLine();
            $trace = $e->getTraceAsString();

            // Konteks HTTP / Request
            $url = null;
            $method = null;
            $ipAddress = null;
            $userAgent = null;
            $userId = null;
            $userName = 'Guest / Belum Login';

            try {
                if (request()) {
                    $url = request()->fullUrl();
                    $method = request()->method();
                    $ipAddress = request()->ip();
                    $userAgent = request()->userAgent();
                }
            } catch (Throwable) {
                // Abaikan jika tidak berjalan dalam konteks request HTTP
            }

            if (app()->runningInConsole() && ! $url) {
                $url = 'CLI: '.implode(' ', $_SERVER['argv'] ?? []);
                $method = 'CONSOLE';
                $ipAddress = '127.0.0.1';
            }

            try {
                if (Auth::check()) {
                    $user = Auth::user();
                    $userId = $user?->id;
                    $userName = ($user?->name ?? 'User').' (ID: '.$userId.' - '.($user?->email ?? '').')';
                }
            } catch (Throwable) {
                // Abaikan jika auth belum siap
            }

            // 1. Simpan ke File Lokal .txt (storage/logs/error-logs/ & storage/logs/errors.txt)
            self::saveToFile(
                waktu: $waktu,
                exceptionClass: $exceptionClass,
                message: $message,
                file: $file,
                line: $line,
                url: $url,
                method: $method,
                ipAddress: $ipAddress,
                userName: $userName,
                userAgent: $userAgent,
                trace: $trace
            );

            // 2. Simpan ke Database (Tabel error_logs)
            $dbLog = null;
            try {
                if (Schema::hasTable('error_logs')) {
                    $dbLog = ErrorLog::create([
                        'message' => $message,
                        'exception' => $exceptionClass,
                        'file' => $file,
                        'line' => $line,
                        'url' => $url,
                        'method' => $method,
                        'ip_address' => $ipAddress,
                        'user_id' => $userId,
                        'trace' => $trace,
                    ]);
                }
            } catch (Throwable) {
                // Abaikan jika koneksi database sedang terkendala
            }

            return $dbLog;
        } catch (Throwable) {
            // Logger tidak boleh memicu error kedua
            return null;
        }
    }

    /**
     * Tuliskan rincian error ke file teks biasa (.txt) di local storage.
     */
    protected static function saveToFile(
        string $waktu,
        string $exceptionClass,
        string $message,
        string $file,
        int $line,
        ?string $url,
        ?string $method,
        ?string $ipAddress,
        string $userName,
        ?string $userAgent,
        string $trace
    ): void {
        try {
            $folderPath = storage_path('logs/error-logs');
            if (! File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0755, true, true);
            }

            $entry = str_repeat('=', 80).PHP_EOL;
            $entry .= "[WAKTU]     : {$waktu}".PHP_EOL;
            $entry .= "[EXCEPTION] : {$exceptionClass}".PHP_EOL;
            $entry .= "[PESAN]     : {$message}".PHP_EOL;
            $entry .= "[FILE]      : {$file}".PHP_EOL;
            $entry .= "[BARIS]     : {$line}".PHP_EOL;
            $entry .= '[URL]       : '.($url ?? 'N/A').PHP_EOL;
            $entry .= '[METHOD]    : '.($method ?? 'N/A').PHP_EOL;
            $entry .= '[IP]        : '.($ipAddress ?? '127.0.0.1').PHP_EOL;
            $entry .= "[PENGGUNA]  : {$userName}".PHP_EOL;
            if ($userAgent) {
                $entry .= "[USER AGENT]: {$userAgent}".PHP_EOL;
            }
            $entry .= str_repeat('-', 80).PHP_EOL;
            $entry .= '[STACK TRACE]:'.PHP_EOL;
            $entry .= $trace.PHP_EOL;
            $entry .= str_repeat('=', 80).PHP_EOL.PHP_EOL;

            // Simpan ke log harian: storage/logs/error-logs/error-YYYY-MM-DD.txt
            $dailyFile = $folderPath.DIRECTORY_SEPARATOR.'error-'.date('Y-m-d').'.txt';
            File::append($dailyFile, $entry);

            // Simpan juga salinan ke file induk: storage/logs/errors.txt
            $masterFile = storage_path('logs/errors.txt');
            File::append($masterFile, $entry);
        } catch (Throwable) {
            // Abaikan jika penulisan filesystem terkendala
        }
    }
}
