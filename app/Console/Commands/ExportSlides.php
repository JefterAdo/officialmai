<?php

namespace App\Console\Commands;

use App\Models\Slide;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ExportSlides extends Command
{
    protected $signature = 'slides:export';
    protected $description = 'Exporter les slides et leurs images';

    public function handle()
    {
        $exportDir = storage_path('app/exports/slides');
        if (!File::exists($exportDir)) {
            File::makeDirectory($exportDir, 0755, true);
        }

        $slides = Slide::all();
        $this->info('Exportation de ' . $slides->count() . ' slides...');

        $exportData = [];
        foreach ($slides as $slide) {
            $exportData[] = $slide->toArray();

            if ($slide->image_path && File::exists(public_path($slide->image_path))) {
                $fileName = basename($slide->image_path);
                $targetPath = $exportDir . '/images/' . $fileName;
                
                if (!File::exists($exportDir . '/images')) {
                    File::makeDirectory($exportDir . '/images', 0755, true);
                }
                
                File::copy(public_path($slide->image_path), $targetPath);
                $this->info('Image copiée : ' . $fileName);
            }
        }

        File::put($exportDir . '/slides.json', json_encode($exportData, JSON_PRETTY_PRINT));
        
        if (File::exists(resource_path('views/welcome.blade.php'))) {
            File::copy(
                resource_path('views/welcome.blade.php'),
                $exportDir . '/slider_code.blade.php'
            );
            $this->info('Code du slider copié');
        }

        $this->info('Export terminé ! Les données sont dans : ' . $exportDir);
    }
} 