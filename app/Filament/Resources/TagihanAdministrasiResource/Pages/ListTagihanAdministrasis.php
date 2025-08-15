<?php

namespace App\Filament\Resources\TagihanAdministrasiResource\Pages;

use App\Filament\Resources\TagihanAdministrasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTagihanAdministrasis extends ListRecords
{
    protected static string $resource = TagihanAdministrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
