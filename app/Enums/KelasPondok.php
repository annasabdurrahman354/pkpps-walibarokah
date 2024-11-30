<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum KelasPondok : string implements HasLabel, HasColor {
    case PEGON_BACAAN = 'pegon bacaan';
    case LAMBATAN = 'lambatan';
    case CEPATAN = 'cepatan';
    case SARINGAN = 'saringan';
    case TES = 'tes';
    case HADITS_BESAR = 'hadits besar';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::PEGON_BACAAN => 'Pegon Bacaan',
            self::LAMBATAN => 'Lambatan',
            self::CEPATAN => 'Cepatan',
            self::SARINGAN => 'Saringan',
            self::TES => 'Tes',
            self::HADITS_BESAR => 'Hadits Besar',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::PEGON_BACAAN => 'danger',
            self::LAMBATAN => 'warning',
            self::CEPATAN => 'info',
            self::SARINGAN => 'secondary',
            self::TES => 'primary',
            self::HADITS_BESAR => 'success',

        };
    }
}
