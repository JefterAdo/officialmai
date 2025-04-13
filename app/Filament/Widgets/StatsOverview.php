<?php

namespace App\Filament\Widgets;

use App\Models\Audio;
use App\Models\PhotoGallery;
use App\Models\Speech;
use App\Models\Video;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        try {
            return [
                Stat::make('Galeries Photos', PhotoGallery::count())
                    ->description('Total des galeries photos')
                    ->descriptionIcon('heroicon-m-photo')
                    ->chart([7, 2, 10, 3, 15, 4, 17])
                    ->color('success'),

                Stat::make('Vidéos', Video::count())
                    ->description('Total des vidéos')
                    ->descriptionIcon('heroicon-m-video-camera')
                    ->chart([15, 4, 17, 7, 2, 10, 3])
                    ->color('warning'),

                Stat::make('Discours', Speech::count())
                    ->description('Total des discours')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->chart([2, 10, 3, 15, 4, 17, 7])
                    ->color('danger'),

                Stat::make('Fichiers Audio', Audio::count())
                    ->description('Total des fichiers audio')
                    ->descriptionIcon('heroicon-m-musical-note')
                    ->chart([10, 3, 15, 4, 17, 7, 2])
                    ->color('info'),
            ];
        } catch (\Exception $e) {
            return [
                Stat::make('Galeries Photos', 0)
                    ->description('Total des galeries photos')
                    ->descriptionIcon('heroicon-m-photo')
                    ->color('success'),

                Stat::make('Vidéos', 0)
                    ->description('Total des vidéos')
                    ->descriptionIcon('heroicon-m-video-camera')
                    ->color('warning'),

                Stat::make('Discours', 0)
                    ->description('Total des discours')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('danger'),

                Stat::make('Fichiers Audio', 0)
                    ->description('Total des fichiers audio')
                    ->descriptionIcon('heroicon-m-musical-note')
                    ->color('info'),
            ];
        }
    }
} 