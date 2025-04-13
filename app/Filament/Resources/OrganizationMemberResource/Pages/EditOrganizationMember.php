<?php

namespace App\Filament\Resources\OrganizationMemberResource\Pages;

use App\Filament\Resources\OrganizationMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationMember extends EditRecord
{
    protected static string $resource = OrganizationMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
