<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class ViewCacheService
{
    protected $cacheDuration = 3600; // 1 heure par défaut

    public function getOrSetCache(string $key, string $view, array $data = [], int $duration = null): string
    {
        $duration = $duration ?? $this->cacheDuration;

        return Cache::remember($key, $duration, function () use ($view, $data) {
            return View::make($view, $data)->render();
        });
    }

    public function clearViewCache(string $key = null): void
    {
        if ($key) {
            Cache::forget($key);
        } else {
            Cache::tags(['views'])->flush();
        }
    }

    public function setCacheDuration(int $seconds): self
    {
        $this->cacheDuration = $seconds;
        return $this;
    }

    public function cachePartials(): void
    {
        // Cache des éléments communs
        $this->cacheHeader();
        $this->cacheFooter();
        $this->cacheNavigation();
    }

    protected function cacheHeader(): void
    {
        $this->getOrSetCache('header', 'partials.header');
    }

    protected function cacheFooter(): void
    {
        $this->getOrSetCache('footer', 'partials.footer');
    }

    protected function cacheNavigation(): void
    {
        $this->getOrSetCache('navigation', 'layouts.navigation');
    }
} 