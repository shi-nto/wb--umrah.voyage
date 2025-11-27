<?php

namespace App\Filament\Resources\PassportInfoResource\Pages;

use App\Filament\Resources\PassportInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPassportInfos extends ListRecords
{
    protected static string $resource = PassportInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
