<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Add essential HTTP security headers to protect against Clickjacking,
     * MIME sniffing, XSS, and unauthorized framing.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        $response = $next($request);

        // Clickjacking protection: only allow same-origin iframe embedding
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME type sniffing attacks
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Legacy XSS filter protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Control referrer information leakage
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Restrict sensitive browser APIs / hardware features
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=()');

        // Restrict cross-domain policy files
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // Enforce HTTPS HSTS when in production or on secure requests
        if ($request->isSecure() || app()->isProduction() || config('app.env') === 'production') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Comprehensive Content Security Policy (allows Google Fonts, Bunny fonts, Alpine CDN, inline SVGs & styles)
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com https://cdn.jsdelivr.net; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://unpkg.com https://cdn.jsdelivr.net; " .
               "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net data:; " .
               "img-src 'self' data: https: http: blob:; " .
               "connect-src 'self' https: ws: wss:; " .
               "base-uri 'self'; " .
               "form-action 'self' https://wa.me; " .
               "frame-ancestors 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        // Suppress technology disclosure headers
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
