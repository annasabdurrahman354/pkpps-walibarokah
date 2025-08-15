<?php

namespace App\Filament\Resources\TagihanAdministrasiResource\Pages;

use App\Filament\Resources\TagihanAdministrasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTagihanAdministrasi extends ViewRecord
{
    protected static string $resource = TagihanAdministrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
