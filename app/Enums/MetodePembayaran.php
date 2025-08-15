<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MetodePembayaran : string implements HasLabel, HasColor {
    case CASH = 'cash';
    case TRANSFER = 'transfer';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::TRANSFER => 'Transfer',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::CASH => 'primary',
            self::TRANSFER => 'secondary',
        };
    }
}
