<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusUser: string implements HasLabel, HasColor{
    case AKTIF = 'aktif';
    case SAMBANG = 'sambang';
    case NONAKTIF = 'nonaktif';
    case PURNA = 'purna';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::AKTIF => 'Aktif',
            self::SAMBANG => 'Sambang',
            self::NONAKTIF => 'Nonaktif',
            self::PURNA => 'Purna',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::AKTIF => 'success',
            self::SAMBANG => 'gray',
            self::NONAKTIF => 'gray',
            self::PURNA => 'info',
        };
    }
}
