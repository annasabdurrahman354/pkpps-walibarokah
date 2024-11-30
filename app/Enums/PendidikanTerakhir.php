<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PendidikanTerakhir: string implements HasLabel{
    case TK = 'tk';
    case SD = 'sd';
    case SLTP = 'sltp';
    case SLTA = 'slta';
    case PAKET_C = 'paket c';
    case S1 = 's1';
    case S2 = 's2';
    case S3 = 's3';
    case D1 = 'd1';
    case D2 = 'd2';
    case D3 = 'd3';
    case D4 = 'd4';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TK => 'TK',
            self::SD => 'SD/Sederajat',
            self::SLTP => 'SLTP/Sederajat',
            self::SLTA => 'SLTA/Sederajat',
            self::PAKET_C => 'Paket C',
            self::S1 => 'Sarjana Strata-1 (S1)',
            self::S2 => 'Sarjana Strata-2 (S2)',
            self::S3 => 'Sarjana Strata-3 (S3)',
            self::D1 => 'Diploma-1 (D1)',
            self::D2 => 'Diploma-2 (D2)',
            self::D3 => 'Diploma-3 (D3)',
            self::D4 => 'Diploma-4 (D4)',
        };
    }

    public function getPrint(): ?string
    {
        return match ($this) {
            self::TK => 'TK',
            self::SD => 'SD',
            self::SLTP => 'SLTP',
            self::SLTA => 'SLTA',
            self::PAKET_C => 'Paket C',
            self::S1 => 'Sarjana Strata-1 (S1)',
            self::S2 => 'Sarjana Strata-2 (S2)',
            self::S3 => 'Sarjana Strata-3 (S3)',
            self::D1 => 'Diploma-1 (D1)',
            self::D2 => 'Diploma-2 (D2)',
            self::D3 => 'Diploma-3 (D3)',
            self::D4 => 'Diploma-4 (D4)',
        };
    }
}
