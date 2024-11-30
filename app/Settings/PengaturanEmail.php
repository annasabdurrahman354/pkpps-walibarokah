<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PengaturanEmail extends Settings
{
    public string $from_address;
    public string $from_name;
    public ?string $driver;
    public ?string $host;
    public int $port;
    public string $encryption;
    public ?string $username;
    public ?string $password;
    public ?int $timeout;
    public ?string $local_domain;

    public static function group(): string
    {
        return 'email';
    }

    public static function encrypted(): array
    {
        return [
            'username',
            'password',
        ];
    }

    public function loadMailSettingsToConfig($data = null): void
    {
        config([
            'email.mailers.smtp.host' => $data['host'] ?? $this->host,
            'email.mailers.smtp.port' => $data['port'] ?? $this->port,
            'email.mailers.smtp.encryption' => $data['encryption'] ?? $this->encryption,
            'email.mailers.smtp.username' => $data['username'] ?? $this->username,
            'email.mailers.smtp.password' => $data['password'] ?? $this->password,
            'email.from.address' => $data['from_address'] ?? $this->from_address,
            'email.from.name' => $data['from_name'] ?? $this->from_name,
        ]);
    }

    /**
     * Check if MailSettings is configured with necessary values.
     */
    public function isMailSettingsConfigured(): bool
    {
        // Check if the essential fields are not null
        return $this->host && $this->username && $this->password && $this->from_address;
    }
}
