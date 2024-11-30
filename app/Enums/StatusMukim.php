<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusMukim : string implements HasLabel, HasColor {
    case MUKIM = 'mukim';
    case TIDAK_MUKIM = 'tidak mukim';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MUKIM => 'Mukim',
            self::TIDAK_MUKIM => 'Tidak Mukim',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::MUKIM => 'primary',
            self::TIDAK_MUKIM => 'secondary',
        };
    }
}
