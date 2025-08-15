<?php

namespace App\Filament\Resources\PembayaranAdministrasiResource\Pages;

use App\Filament\Resources\PembayaranAdministrasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPembayaranAdministrasi extends ViewRecord
{
    protected static string $resource = PembayaranAdministrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
