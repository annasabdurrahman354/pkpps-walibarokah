<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Unit : string implements HasLabel, HasColor {
    case ULA = 'ula';
    case WUSTHA = 'wustha';
    case ULYA = 'ulya';
    case PONPES = 'ponpes';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::ULA => 'Ula',
            self::WUSTHA => 'Wustha',
            self::ULYA => 'Ulya',
            self::PONPES => 'Ponpes',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::ULA => 'primary',
            self::WUSTHA => 'secondary',
            self::ULYA => 'success',
            self::PONPES => 'info',
        };
    }
}
