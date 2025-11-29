<?php

namespace App\Filament\Resources\PilgrimResource\Pages;

use App\Filament\Resources\PilgrimResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPilgrim extends EditRecord
{
    protected static string $resource = PilgrimResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // Passport create/update is handled by the Repeater relationship in the form
}
