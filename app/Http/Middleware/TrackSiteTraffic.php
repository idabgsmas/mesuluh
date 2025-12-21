<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteVisit;

class TrackSiteTraffic
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. JANGAN CATAT jika yang dibuka adalah halaman Admin atau API
        if ($request->is('admin*') || $request->is('filament*') || $request->is('livewire*') || $request->is('api*')) {
            return $next($request);
        }

        // 2. TENTUKAN KUNCI UNIK (Berdasarkan URL)
        // Kunci ini akan disimpan di session browser pengguna
        $url = $request->fullUrl();
        $sessionKey = 'visited_' . md5($url);

        // 3. CEK APAKAH SUDAH PERNAH DICATAT DI SESI INI?
        if (!session()->has($sessionKey)) {

            // Jika belum, simpan ke database
            SiteVisit::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $url,
            ]);

            // Tandai di session bahwa URL ini sudah dikunjungi (berlaku 2 jam default session)
            session()->put($sessionKey, true);
        }

        return $next($request);
    }
}