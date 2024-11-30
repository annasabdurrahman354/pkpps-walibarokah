<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum KepemilikanRumah : string implements HasLabel, HasColor {
    case MILIK_SENDIRI = 'milik sendiri';
    case RUMAH_ORANG_TUA = 'rumah orang tua';
    case RUMAH_SAUDARA_KERABAT = 'rumah saudara/kerabat';
    case RUMAH_DINAS = 'rumah dinas';
    case SEWA_KONTRAK = 'sewa/kontrak';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::MILIK_SENDIRI => 'Milik Sendiri',
            self::RUMAH_ORANG_TUA => 'Rumah Orang Tua',
            self::RUMAH_SAUDARA_KERABAT => 'Rumah Saudara/Kerabat',
            self::RUMAH_DINAS => 'Rumah Dinas',
            self::SEWA_KONTRAK => 'Sewa/Kontrak',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::MILIK_SENDIRI => 'success',
            self::RUMAH_ORANG_TUA => 'primary',
            self::RUMAH_SAUDARA_KERABAT => 'secondary',
            self::RUMAH_DINAS => 'warning',
            self::SEWA_KONTRAK => 'danger',
        };
    }
}
