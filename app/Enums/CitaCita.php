<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CitaCita : string implements HasLabel {
    case PNS         = 'pns';
    case TNI_POLRI   = 'tni/polri';
    case GURU_DOSEN  = 'guru/dosen';
    case DOKTER      = 'dokter';
    case POLITIKUS   = 'politikus';
    case WIRASWASTA  = 'wiraswasta';
    case SENIMAN_ARTIS = 'seniman/artis';
    case ILMUWAN     = 'ilmuwan';
    case AGAMAWAN    = 'agamawan';
    case LAINNYA     = 'lainnya';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PNS             => 'PNS',
            self::TNI_POLRI       => 'TNI/Polri',
            self::GURU_DOSEN      => 'Guru/Dosen',
            self::DOKTER          => 'Dokter',
            self::POLITIKUS       => 'Politikus',
            self::WIRASWASTA      => 'Wiraswasta',
            self::SENIMAN_ARTIS   => 'Seniman/Artis',
            self::ILMUWAN         => 'Ilmuwan',
            self::AGAMAWAN        => 'Agamawan',
            self::LAINNYA         => 'Lainnya',
        };
    }
}
