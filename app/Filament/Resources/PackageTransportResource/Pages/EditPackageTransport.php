<?php

namespace App\Filament\Resources\PackageTransportResource\Pages;

use App\Filament\Resources\PackageTransportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackageTransport extends EditRecord
{
    protected static string $resource = PackageTransportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
