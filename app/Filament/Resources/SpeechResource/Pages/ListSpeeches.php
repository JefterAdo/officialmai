<?php

namespace App\Filament\Resources\SpeechResource\Pages;

use App\Filament\Resources\SpeechResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpeeches extends ListRecords
{
    protected static string $resource = SpeechResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 