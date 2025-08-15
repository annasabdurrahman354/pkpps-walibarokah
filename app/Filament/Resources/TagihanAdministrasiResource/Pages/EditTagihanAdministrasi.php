<?php

namespace App\Filament\Resources\TagihanAdministrasiResource\Pages;

use App\Filament\Resources\TagihanAdministrasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTagihanAdministrasi extends EditRecord
{
    protected static string $resource = TagihanAdministrasiResource::class;

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
