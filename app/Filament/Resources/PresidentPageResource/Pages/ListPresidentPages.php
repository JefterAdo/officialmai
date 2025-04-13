<?php

namespace App\Filament\Resources\PresidentPageResource\Pages;

use App\Filament\Resources\PresidentPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPresidentPages extends ListRecords
{
    protected static string $resource = PresidentPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
