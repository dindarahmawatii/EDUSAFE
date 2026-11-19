<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menambahkan header keamanan untuk halaman web:
 *  - Content-Security-Policy (dengan nonce per-request untuk <script>/<style> inline)
 *  - Anti-clickjacking (X-Frame-Options + CSP frame-ancestors)
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        // Nonce baru di setiap request, dibagikan ke semua view sebagai $cspNonce.
        $nonce = base64_encode(random_bytes(16));
        View::share('cspNonce', $nonce);

        /** @var Response $response */
        $response = $next($request);

        // Anti-clickjacking: halaman tidak boleh dibingkai (iframe) oleh situs lain.
        $response->headers->set('X-Frame-Options', 'DENY');

        // Halaman error debug Laravel memakai script inline sendiri; jangan diblokir saat debug.
        $skipCsp = config('app.debug') && $response->getStatusCode() >= 500;

        if (! $skipCsp && ! $response->headers->has('Content-Security-Policy')) {
            $response->headers->set('Content-Security-Policy', $this->policy($nonce));
        }

        return $response;
    }

    private function policy(string $nonce): string
    {
        return implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'nonce-{$nonce}'",
            "style-src 'self' 'nonce-{$nonce}'",
            // Atribut style="..." dipakai luas di view; hanya atribut yang diizinkan inline, bukan <style>.
            "style-src-attr 'unsafe-inline'",
            // images.unsplash.com dipakai sebagai background di public/css/pages/siswa/kuis.css
            "img-src 'self' data: https://images.unsplash.com",
            "font-src 'self'",
            "connect-src 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
        ]);
    }
}
