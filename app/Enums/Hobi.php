<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Hobi : string implements HasLabel {
    case OLAHRAGA    = 'olahraga';
    case KESENIAN    = 'kesenian';
    case MEMBACA     = 'membaca';
    case MENULIS     = 'menulis';
    case JALAN_JALAN = 'jalan-jalan';
    case LAINNYA     = 'lainnya';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::OLAHRAGA    => 'Olahraga',
            self::KESENIAN    => 'Kesenian',
            self::MEMBACA     => 'Membaca',
            self::MENULIS     => 'Menulis',
            self::JALAN_JALAN => 'Jalan-jalan',
            self::LAINNYA     => 'Lainnya',
        };
    }
}
