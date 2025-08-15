<?php

namespace App\Filament\Resources\PembayaranAdministrasiResource\Pages;

use App\Filament\Resources\PembayaranAdministrasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembayaranAdministrasi extends EditRecord
{
    protected static string $resource = PembayaranAdministrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
