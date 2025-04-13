<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Filament\Components\SeoAnalyzer;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::component('seo-analyzer', SeoAnalyzer::class);
    }
} 
 