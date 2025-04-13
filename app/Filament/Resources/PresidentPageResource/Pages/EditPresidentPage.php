<?php

namespace App\Filament\Resources\PresidentPageResource\Pages;

use App\Filament\Resources\PresidentPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPresidentPage extends EditRecord
{
    protected static string $resource = PresidentPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
