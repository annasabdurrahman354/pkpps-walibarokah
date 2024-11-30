<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Penghasilan: string implements HasLabel{
    case KURANG_DARI500K = 'kurang dari 500.000';
    case RP500K_1000K = '500.000 - 1.000.000';
    case RP1000K_2000K = '1.000.000 - 2.000.000';
    case RP2000K_3000K = '2.000.000 - 3.000.000';
    case RP3000K_5000K = '3.000.000 - 5.000.000';
    case LEBIH_5000K = 'lebih dari 5.000.000';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::KURANG_DARI500K => 'Kurang dari 500.000',
            self::RP500K_1000K => '500.000 - 1.000.000',
            self::RP1000K_2000K => '1.000.000 - 2.000.000',
            self::RP2000K_3000K => '2.000.000 - 3.000.000',
            self::RP3000K_5000K => '3.000.000 - 5.000.000',
            self::LEBIH_5000K => 'Lebih dari 5.000.000',
        };
    }
}
