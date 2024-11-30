<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum KebutuhanKhusus : string implements HasLabel {
    case TIDAK_ADA = 'tidak ada';
    case LAMBAN_BELAJAR = 'lamban belajar';
    case KESULITAN_BELAJAR_SPESIFIK = 'kesulitan belajar spesifik';
    case GANGGUAN_KOMUNIKASI = 'gangguan komunikasi';
    case BERBAKAT = 'berbakat';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TIDAK_ADA => 'Tidak Ada',
            self::LAMBAN_BELAJAR => 'Lamban Belajar',
            self::KESULITAN_BELAJAR_SPESIFIK => 'Kesulitan Belajar Spesifik',
            self::GANGGUAN_KOMUNIKASI => 'Gangguan Komunikasi',
            self::BERBAKAT => 'Berbakat',
        };
    }
}
