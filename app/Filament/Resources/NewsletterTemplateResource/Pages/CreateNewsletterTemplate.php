<?php

namespace App\Filament\Resources\NewsletterTemplateResource\Pages;

use App\Filament\Resources\NewsletterTemplateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletterTemplate extends CreateRecord
{
    protected static string $resource = NewsletterTemplateResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 