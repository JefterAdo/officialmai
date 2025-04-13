<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PerformanceMonitor
{
    protected $startTime;
    protected $thresholds = [
        'query' => 100, // ms
        'request' => 500, // ms
        'memory' => 64, // MB
    ];

    public function startMeasure(): void
    {
        $this->startTime = microtime(true);
    }

    public function endMeasure(string $identifier): float
    {
        $duration = (microtime(true) - $this->startTime) * 1000;
        
        if ($duration > $this->thresholds['request']) {
            Log::warning("Performance alert: {$identifier} took {$duration}ms");
            $this->recordSlowRequest($identifier, $duration);
        }

        return $duration;
    }

    public function recordSlowRequest(string $identifier, float $duration): void
    {
        $key = 'slow_requests:' . date('Y-m-d');
        $data = Cache::get($key, []);
        
        $data[] = [
            'identifier' => $identifier,
            'duration' => $duration,
            'memory' => memory_get_peak_usage(true) / 1024 / 1024,
            'timestamp' => now()->toDateTimeString(),
            'url' => request()->fullUrl(),
        ];

        Cache::put($key, $data, now()->addDays(7));
    }

    public function getSlowRequests(string $date = null): array
    {
        $date = $date ?? date('Y-m-d');
        return Cache::get('slow_requests:' . $date, []);
    }

    public function checkMemoryUsage(): void
    {
        $memoryUsage = memory_get_peak_usage(true) / 1024 / 1024;
        
        if ($memoryUsage > $this->thresholds['memory']) {
            Log::warning("High memory usage detected: {$memoryUsage}MB");
        }
    }

    public function setThreshold(string $type, int $value): void
    {
        if (array_key_exists($type, $this->thresholds)) {
            $this->thresholds[$type] = $value;
        }
    }
} 