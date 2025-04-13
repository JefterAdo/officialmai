<?php

namespace App\Filament\Resources\OfficialDocumentResource\Pages;

use App\Filament\Resources\OfficialDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOfficialDocuments extends ListRecords
{
    protected static string $resource = OfficialDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
