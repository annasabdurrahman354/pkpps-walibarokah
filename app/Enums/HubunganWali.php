<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum HubunganWali : string implements HasLabel {
    case AYAH = 'ayah';
    case IBU = 'ibu';
    case SAUDARA = 'saudara';
    case KERABAT = 'kerabat';
    case NONKERABAT = 'nonkerabat';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::AYAH => 'Ayah',
            self::IBU => 'Ibu',
            self::SAUDARA => 'Saudara',
            self::KERABAT => 'Kerabat',
            self::NONKERABAT => 'Nonkerabat',
        };
    }
}
