<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheStaticAssets
{
    protected $staticExtensions = [
        'css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'ico', 'svg',
        'woff', 'woff2', 'ttf', 'eot'
    ];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        $path = $request->path();
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($extension, $this->staticExtensions)) {
            $response->header('Cache-Control', 'public, max-age=31536000');
            $response->header('Pragma', 'public');
            $response->header('X-Content-Type-Options', 'nosniff');
            
            // Ajoute un ETag pour la validation du cache
            if (!$response->headers->has('ETag')) {
                $response->setEtag(md5($response->getContent()));
            }
        }

        return $response;
    }
} 