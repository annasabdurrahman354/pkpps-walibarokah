<?php

namespace App\Filament\Resources\PembayaranAdministrasiResource\Pages;

use App\Filament\Resources\PembayaranAdministrasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembayaranAdministrasis extends ListRecords
{
    protected static string $resource = PembayaranAdministrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
