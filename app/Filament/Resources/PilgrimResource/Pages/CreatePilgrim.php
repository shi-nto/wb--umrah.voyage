<?php

namespace App\Filament\Resources\PilgrimResource\Pages;

use App\Filament\Resources\PilgrimResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePilgrim extends CreateRecord
{
    protected static string $resource = PilgrimResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // Passport creation is handled by the Repeater relationship on the PilgrimResource form
}
