<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum KebutuhanDisabilitas : string implements HasLabel {
    case TIDAK_ADA = 'tidak ada';
    case TUNA_NETRA = 'tuna netra';
    case TUNA_RUNGU = 'tuna rungu';
    case TUNA_WICARA = 'tuna wicara';
    case TUNA_DAKSA = 'tuna daksa';
    case TUNA_GRAHITA = 'tuna grahita';
    case TUNA_LARAS = 'tuna laras';
    case LAINNYA = 'lainnya';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::TIDAK_ADA => 'Tidak Ada',
            self::TUNA_NETRA => 'Tuna Netra',
            self::TUNA_RUNGU => 'Tuna Rungu',
            self::TUNA_WICARA => 'Tuna Wicara',
            self::TUNA_DAKSA => 'Tuna Daksa',
            self::TUNA_GRAHITA => 'Tuna Grahita',
            self::TUNA_LARAS=> 'Tuna Laras',
            self::LAINNYA => 'Lainnya',
        };
    }
}
