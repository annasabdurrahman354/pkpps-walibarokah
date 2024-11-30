<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BahasaKeseharian : string implements HasLabel, HasColor {
    case INDONESIA = 'indonesia';
    case JAWA = 'jawa';
    case DAERAH = 'daerah';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INDONESIA => 'Indonesia',
            self::JAWA => 'Jawa',
            self::DAERAH => 'Daerah',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::INDONESIA => 'primary',
            self::JAWA => 'secondary',
            self::DAERAH => 'info',
        };
    }
}
