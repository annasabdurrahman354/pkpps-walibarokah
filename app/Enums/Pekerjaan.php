<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Pekerjaan : string implements HasLabel {
    case TIDAK_BEKERJA = 'tidak bekerja';
    case IBU_RUMAH_TANGGA = 'ibu rumah tangga';
    case AGAMAWAN = 'agamawan';
    case ARTIS = 'artis';
    case BIDAN = 'bidan';
    case BURUH_TETAP = 'buruh tetap';
    case BURUH_TIDAK_TETAP = 'buruh tidak tetap';
    case DOSEN = 'dosen';
    case GURU = 'guru';
    case HAKIM = 'hakim';
    case ILMUWAN = 'ilmuwan';
    case JAKSA = 'jaksa';
    case MASINIS = 'masinis';
    case NELAYAN = 'nelayan';
    case NOTARIS = 'notaris';
    case PELUKIS = 'pelukis';
    case PENSIUNAN = 'pensiunan';
    case PNS = 'pns';
    case PETANI = 'petani';
    case PELAYAN = 'pelayan';
    case PILOT = 'pilot';
    case POLRI = 'polri';
    case POLITIKUS = 'politikus';
    case PRAMUGARA = 'pramugara';
    case PRAMUGARI = 'pramugari';

    case PENGACARA = 'pengacara';
    case PEGAWAI_SWASTA = 'pegawai swasta';
    case SATPAM = 'satpam';
    case SENIMAN = 'seniman';
    case SOPIR = 'sopir';
    case TNI = 'tni';
    case WIRASWASTA = 'wiraswasta';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TIDAK_BEKERJA => 'Tidak Bekerja',
            self::IBU_RUMAH_TANGGA => 'Ibu Rumah Tangga',
            self::AGAMAWAN => 'Agamawan',
            self::ARTIS => 'Artis',
            self::BIDAN => 'Bidan',
            self::BURUH_TETAP => 'Buruh Tetap',
            self::BURUH_TIDAK_TETAP => 'Buruh Tidak Tetap',
            self::DOSEN => 'Dosen',
            self::GURU => 'Guru',
            self::HAKIM => 'Hakim',
            self::ILMUWAN => 'Ilmuwan',
            self::JAKSA => 'Jaksa',
            self::MASINIS => 'Masinis',
            self::NELAYAN => 'Nelayan',
            self::NOTARIS => 'Notaris',
            self::PELUKIS => 'Pelukis',
            self::PENSIUNAN => 'Pensiunan',
            self::PNS => 'PNS',
            self::PETANI => 'Petani',
            self::PELAYAN => 'Pelayan',
            self::PILOT => 'Pilot',
            self::POLRI => 'Polri',
            self::POLITIKUS => 'Politikus',
            self::PRAMUGARA => 'Pramugara',
            self::PENGACARA => 'Pengacara',
            self::PEGAWAI_SWASTA => 'Pegawai Swasta',
            self::SATPAM => 'Satpam',
            self::SENIMAN => 'Seniman',
            self::SOPIR => 'Sopir',
            self::TNI => 'TNI/Polri',
            self::WIRASWASTA => 'Wiraswasta',
        };
    }
}
