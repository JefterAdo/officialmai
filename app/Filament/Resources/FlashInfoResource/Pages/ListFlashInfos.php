<?php

namespace App\Filament\Resources\FlashInfoResource\Pages;

use App\Filament\Resources\FlashInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlashInfos extends ListRecords
{
    protected static string $resource = FlashInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
