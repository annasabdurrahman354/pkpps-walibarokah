<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Halaman Contoh
    |--------------------------------------------------------------------------
    */
    // 'page' => [
    //     'title' => 'Judul Halaman',
    //     'heading' => 'Judul Utama',
    //     'subheading' => 'Subjudul Halaman',
    //     'navigationLabel' => 'Label Navigasi Halaman',
    //     'section' => [],
    //     'fields' => []
    // ],

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Umum
    |--------------------------------------------------------------------------
    */
    'general_settings' => [
        'title' => 'Pengaturan Situs',
        'heading' => 'Pengaturan Situs',
        'subheading' => 'Kelola pengaturan situs situs di sini.',
        'navigationLabel' => 'Situs',
        'sections' => [
            "site" => [
                "title" => "Situs",
                "description" => "Kelola pengaturan dasar."
            ],
            "theme" => [
                "title" => "Tema",
                "description" => "Ganti tema default."
            ],
        ],
        "fields" => [
            "brand_name" => "Nama Brand",
            "site_active" => "Status Situs",
            "brand_logoHeight" => "Tinggi Logo Brand",
            "brand_logo" => "Logo Brand",
            "site_favicon" => "Favicon Situs",
            "primary" => "Utama",
            "secondary" => "Sekunder",
            "gray" => "Abu-abu",
            "success" => "Sukses",
            "danger" => "Bahaya",
            "info" => "Informasi",
            "warning" => "Peringatan",
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Email
    |--------------------------------------------------------------------------
    */
    'mail_settings' => [
        'title' => 'Pengaturan Email',
        'heading' => 'Pengaturan Email',
        'subheading' => 'Kelola konfigurasi email.',
        'navigationLabel' => 'Email',
        'sections' => [
            "config" => [
                "title" => "Konfigurasi",
                "description" => "Deskripsi"
            ],
            "sender" => [
                "title" => "Dari (Pengirim)",
                "description" => "Deskripsi"
            ],
            "mail_to" => [
                "title" => "Kirim ke",
                "description" => "Deskripsi"
            ],
        ],
        "fields" => [
            "placeholder" => [
                "receiver_email" => "Email penerima.."
            ],
            "driver" => "Driver",
            "host" => "Host",
            "port" => "Port",
            "encryption" => "Enkripsi",
            "timeout" => "Timeout",
            "username" => "Nama Pengguna",
            "password" => "Kata Sandi",
            "email" => "Email",
            "name" => "Nama",
            "mail_to" => "Kirim ke",
        ],
        "actions" => [
            "send_test_mail" => "Kirim Email Uji"
        ]
    ],

];
