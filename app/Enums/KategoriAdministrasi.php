<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum KategoriAdministrasi: string implements HasLabel, HasColor{
    case BEBAS = 'bebas';
    case PENUH = 'penuh';
    case SUBSIDI = 'subsidi';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BEBAS => 'Bebas',
            self::PENUH => 'Penuh',
            self::SUBSIDI => 'Subsidi',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::BEBAS => 'primary',
            self::PENUH => 'secondary',
            self::SUBSIDI => 'warning',
        };
    }
}
