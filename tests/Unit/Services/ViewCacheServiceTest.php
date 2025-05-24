<?php

namespace Tests\Unit\Services;

use App\Services\ViewCacheService;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ViewCacheServiceTest extends TestCase
{
    protected $viewCacheService;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer une instance du service
        $this->viewCacheService = new ViewCacheService();
    }
    
    /** @test */
    public function it_returns_cached_content_in_testing_environment()
    {
        $result = $this->viewCacheService->getOrSetCache(
            'test-key', 
            'test-view', 
            ['data' => 'test'], 
            60
        );
        
        $this->assertEquals('cached-content', $result);
    }
    
    /** @test */
    public function it_can_clear_cache()
    {
        Cache::shouldReceive('forget')
            ->once()
            ->with('test-key');
            
        $this->viewCacheService->clearViewCache('test-key');
    }
    
    /** @test */
    public function it_can_clear_all_caches()
    {
        Cache::shouldReceive('tags')
            ->once()
            ->with(['views'])
            ->andReturnSelf();
            
        Cache::shouldReceive('flush')
            ->once();
            
        $this->viewCacheService->clearViewCache();
    }
}
