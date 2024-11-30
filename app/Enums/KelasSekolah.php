<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum KelasSekolah : string implements HasLabel {
    case I = 'I';
    case II = 'II';
    case III = 'III';
    case IV = 'IV';
    case V = 'V';
    case VI = 'VI';
    case VII = 'VII';
    case VIII = 'VIII';
    case IX = 'IX';
    case X = 'X';
    case XI = 'XI';
    case XII = 'XII';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::I => 'I',
            self::II => 'II',
            self::III => 'III',
            self::IV => 'IV',
            self::V => 'V',
            self::VI => 'VI',
            self::VII => 'VII',
            self::VIII => 'VIII',
            self::IX => 'IX',
            self::X => 'X',
            self::XI => 'XI',
            self::XII => 'XII',

        };
    }
}
