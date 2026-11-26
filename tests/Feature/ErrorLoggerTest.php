<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\ErrorLogger;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ErrorLoggerTest extends TestCase
{
    use RefreshDatabase;

    public function test_error_logger_stores_log_in_database_and_local_txt_file(): void
    {
        $user = User::factory()->create([
            'name' => 'Budi Tester',
            'email' => 'budi.test@example.com',
        ]);

        $this->actingAs($user);

        $testException = new Exception('Koneksi timeout saat membaca materi.');

        $errorLog = ErrorLogger::log($testException);

        // 1. Validasi database record
        $this->assertNotNull($errorLog);
        $this->assertDatabaseHas('error_logs', [
            'id' => $errorLog->id,
            'message' => 'Koneksi timeout saat membaca materi.',
            'exception' => Exception::class,
            'user_id' => $user->id,
        ]);

        $this->assertNotEmpty($errorLog->file);
        $this->assertGreaterThan(0, $errorLog->line);
        $this->assertNotEmpty($errorLog->trace);

        // 2. Validasi file lokal .txt
        $dailyFile = storage_path('logs/error-logs/error-'.date('Y-m-d').'.txt');
        $masterFile = storage_path('logs/errors.txt');

        $this->assertTrue(File::exists($dailyFile));
        $this->assertTrue(File::exists($masterFile));

        $dailyContent = File::get($dailyFile);
        $this->assertStringContainsString('Koneksi timeout saat membaca materi.', $dailyContent);
        $this->assertStringContainsString('Budi Tester', $dailyContent);
        $this->assertStringContainsString('budi.test@example.com', $dailyContent);
        $this->assertStringContainsString('[STACK TRACE]:', $dailyContent);
    }

    public function test_error_logger_handles_guest_context(): void
    {
        $testException = new Exception('Error tanpa user login.');

        $errorLog = ErrorLogger::log($testException);

        $this->assertNotNull($errorLog);
        $this->assertDatabaseHas('error_logs', [
            'id' => $errorLog->id,
            'message' => 'Error tanpa user login.',
            'user_id' => null,
        ]);

        $masterFile = storage_path('logs/errors.txt');
        $this->assertTrue(File::exists($masterFile));

        $content = File::get($masterFile);
        $this->assertStringContainsString('Error tanpa user login.', $content);
        $this->assertStringContainsString('Guest / Belum Login', $content);
    }
}
