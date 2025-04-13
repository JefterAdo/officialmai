<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettingService
{
    protected string $cachePrefix = 'site_settings_';

    public function get(string $key, $default = null)
    {
        return Cache::remember($this->cachePrefix . $key, 3600, function () use ($key, $default) {
            $setting = SiteSetting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public function set(string $key, $value, string $type = 'text', string $group = 'general', ?string $description = null): void
    {
        $setting = SiteSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'description' => $description,
            ]
        );

        Cache::forget($this->cachePrefix . $key);
    }

    public function forget(string $key): void
    {
        SiteSetting::where('key', $key)->delete();
        Cache::forget($this->cachePrefix . $key);
    }

    public function all(): array
    {
        return Cache::remember($this->cachePrefix . 'all', 3600, function () {
            return SiteSetting::all()
                ->mapWithKeys(function ($setting) {
                    return [$setting->key => $setting->value];
                })
                ->toArray();
        });
    }

    public function getByGroup(string $group): array
    {
        return Cache::remember($this->cachePrefix . 'group_' . $group, 3600, function () use ($group) {
            return SiteSetting::where('group', $group)
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [$setting->key => $setting->value];
                })
                ->toArray();
        });
    }

    public function clearCache(): void
    {
        $settings = SiteSetting::all();
        foreach ($settings as $setting) {
            Cache::forget($this->cachePrefix . $setting->key);
        }
        Cache::forget($this->cachePrefix . 'all');
    }
} 