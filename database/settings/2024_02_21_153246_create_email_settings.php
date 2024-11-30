<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('email.from_address', 'no-reply@tcm-walibarokah.org');
        $this->migrator->add('email.from_name', 'Tes Calon Mubaligh');
        $this->migrator->add('email.driver', 'smtp');
        $this->migrator->add('email.host', null);
        $this->migrator->add('email.port', 587);
        $this->migrator->add('email.encryption', 'tls');
        $this->migrator->addEncrypted('email.username', null);
        $this->migrator->addEncrypted('email.password', null);
        $this->migrator->add('email.timeout', null);
        $this->migrator->add('email.local_domain', null);
    }
};
