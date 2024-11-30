<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusOrangTua : string implements HasLabel, HasColor {
    case MASIH_HIDUP = 'masih hidup';
    case MENINGGAL = 'meninggal';
    case TIDAK_DIKETAHUI = 'tidak diketahui';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MASIH_HIDUP => 'Masih Hidup',
            self::MENINGGAL => 'Meninggal',
            self::TIDAK_DIKETAHUI => 'Tidak Diketahui',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::MASIH_HIDUP => 'sucess',
            self::MENINGGAL => 'danger',
            self::TIDAK_DIKETAHUI => 'info',
        };
    }
}
