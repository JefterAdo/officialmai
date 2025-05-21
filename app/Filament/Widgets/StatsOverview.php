<?php

namespace App\Filament\Widgets;

use App\Models\News;
use App\Models\Event;
use App\Models\Member;
use App\Models\Media;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        return [
            Stat::make('Actualités', News::count())
                ->description('Total des actualités publiées')
                ->descriptionIcon('heroicon-m-newspaper')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Événements', Event::count())
                ->description('Total des événements')
                ->descriptionIcon('heroicon-m-calendar')
                ->chart([3, 5, 7, 12, 6, 8, 4])
                ->color('warning'),

            Stat::make('Membres', Member::count())
                ->description('Total des membres')
                ->descriptionIcon('heroicon-m-users')
                ->chart([15, 14, 16, 17, 18, 19, 20])
                ->color('primary'),

            Stat::make('Médias', Media::count())
                ->description('Total des médias')
                ->descriptionIcon('heroicon-m-photo')
                ->chart([10, 12, 15, 18, 20, 25, 30])
                ->color('danger'),
        ];
    }
} 