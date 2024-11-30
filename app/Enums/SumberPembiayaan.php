<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SumberPembiayaan : string implements HasLabel, HasColor {
    case ORANG_TUA = 'orang tua';
    case WALI_ORANG_TUA_ASUH = 'wali/orang tua asuh';
    case TANGGUNGAN_SENDIRI = 'tanggungan sendiri';
    case LAINNYA = 'lainnya';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ORANG_TUA => 'Orang Tua',
            self::WALI_ORANG_TUA_ASUH => 'Wali/Orang Tua Asuh',
            self::TANGGUNGAN_SENDIRI => 'Tanggungan Sendiri',
            self::LAINNYA => 'Lainnya',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::ORANG_TUA => 'primary',
            self::WALI_ORANG_TUA_ASUH => 'secondary',
            self::TANGGUNGAN_SENDIRI => 'warning',
            self::LAINNYA => 'info',
        };
    }
}
