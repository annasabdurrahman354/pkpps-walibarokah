<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RoleUser : string implements HasLabel, HasColor {
    case BENDAHARA = 'bendahara';
    case SEKRETARIS = 'sekretaris';
    case PAMONG = 'pamong';
    case SUPER_ADMIN = 'super admin';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BENDAHARA => 'Bendahara',
            self::SEKRETARIS => 'Sekretaris',
            self::PAMONG => 'Pamong',
            self::SUPER_ADMIN => 'Super Admin',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::BENDAHARA => 'info',
            self::SEKRETARIS => 'warning',
            self::PAMONG => 'success',
            self::SUPER_ADMIN => 'primary',
        };
    }
}
