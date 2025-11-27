<?php

namespace App\Filament\Resources\PackageTransportResource\Pages;

use App\Filament\Resources\PackageTransportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPackageTransports extends ListRecords
{
    protected static string $resource = PackageTransportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
