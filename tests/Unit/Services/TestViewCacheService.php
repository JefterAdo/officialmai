<?php

namespace Tests\Unit\Services;

use App\Services\ViewCacheService;

class TestViewCacheService extends ViewCacheService
{
    protected function cacheHeader(): void
    {
        // Ne rien faire pendant les tests
    }

    protected function cacheFooter(): void
    {
        // Ne rien faire pendant les tests
    }

    protected function cacheNavigation(): void
    {
        // Ne rien faire pendant les tests
    }
}
