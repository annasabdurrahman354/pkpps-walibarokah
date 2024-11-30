<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum JenjangSekolah : string implements HasLabel, HasColor {
    case ULA = 'ula';
    case WUSTHA = 'wustha';
    case ULYA = 'ulya';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ULA => 'Ula',
            self::WUSTHA => 'Wustha',
            self::ULYA => 'Ulya',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::ULA => 'primary',
            self::WUSTHA => 'secondary',
            self::ULYA => 'success',
        };
    }
}
