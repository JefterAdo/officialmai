<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('download')
                ->label('Télécharger')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => route('documents.download', $this->record->slug))
                ->openUrlInNewTab(),
            Actions\Action::make('view')
                ->label('Voir dans le navigateur')
                ->icon('heroicon-o-eye')
                ->url(fn () => route('documents.view', $this->record->slug))
                ->openUrlInNewTab(),
        ];
    }
}
