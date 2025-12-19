<?php

use Illuminate\Support\Facades\Schema;

return [
    'navbar' => [
        [
            'type'   => 'menu',
            'label'   => 'Beranda',
            'route'  => 'front.index',
            'active' => 'front.index',
        ],
        [
            'type'   => 'menu',
            'label'   => 'Tentang Kami',
            'route'  => 'front.about',
            'active' => 'front.about',
        ],
        [
            'type'   => 'menu',
            'label'  => 'Layanan',
            'route'  => 'front.service.index',
            'active' => 'front.service.*',
            'submenu' => [
                [
                    'label' => 'Bayar Tagihan Online',
                    'route' => 'front.service.pay-bill',
                ],
                [
                    'label' => 'Pindah Meter',
                    'route' => 'front.service.move-meter',
                ],
                [
                    'label' => 'Ganti Stop Kran',
                    'route' => 'front.service.replace-stop-valve',
                ],
                [
                    'label' => 'Balik Nama',
                    'route' => 'front.service.change-name',
                ],
                [
                    'label' => 'Tutup Sementara',
                    'route' => 'front.service.temporary-disconnect',
                ],
                [
                    'label' => 'Buka Kembali',
                    'route' => 'front.service.reconnect',
                ],
            ],
        ],
        [
            'type'   => 'menu',
            'label'  => 'Info Pelanggan',
            'route'  => 'front.customer-info.rights-obligations',
            'active' => 'front.customer-info.*',
            'submenu' => [
                [
                    'label' => 'Hak dan Kewajiban',
                    'route' => 'front.customer-info.rights-obligations',
                ],
                [
                    'label' => 'Larangan Pelanggan',
                    'route' => 'front.customer-info.prohibitions',
                ],
                [
                    'label' => 'Golongan Pelanggan',
                    'route' => 'front.customer-info.groups',
                ],
                [
                    'label' => 'Informasi Tarif',
                    'route' => 'front.customer-info.tariff',
                ],
                [
                    'label' => 'Info Gangguan',
                    'route' => 'front.customer-info.disturbance-info',
                ],
            ],
        ],
        [
            'type'   => 'menu',
            'label'   => 'Berita',
            'route'  => 'front.news.index',
            'active' => 'front.news.*',
        ],
        [
            'type'   => 'menu',
            'label'   => 'Kontak',
            'route'  => 'front.contact',
            'active' => 'front.contact',
        ],
    ],
    'footer' => [
        'sections' => [
            [
                'title' => 'Utama',
                'items' => [
                    [
                        'label' => 'Beranda',
                        'route' => 'front.index',
                    ],
                    [
                        'label' => 'Tentang Kami',
                        'route' => 'front.about',
                    ],
                    [
                        'label' => 'Layanan',
                        'route' => 'front.service.index',
                    ],
                    [
                        'label' => 'Berita & Artikel',
                        'route' => 'front.news.index',
                    ],
                ],
            ],
            [
                'title' => 'Info Pelanggan',
                'items' => [
                    [
                        'label' => 'Hak & Kewajiban',
                        'route' => 'front.customer-info.rights-obligations',
                    ],
                    [
                        'label' => 'Larangan Pelanggan',
                        'route' => 'front.customer-info.prohibitions',
                    ],
                    [
                        'label' => 'Golongan',
                        'route' => 'front.customer-info.groups',
                    ],
                    [
                        'label' => 'Tarif',
                        'route' => 'front.customer-info.tariff',
                    ],
                    [
                        'label' => 'Info Gangguan',
                        'route' => 'front.customer-info.disturbance-info',
                    ],
                ],
            ],
            [
                'title' => 'Bantuan',
                'items' => [
                    [
                        'label' => 'Kontak Kami',
                        'route' => 'front.contact',
                    ],
                    [
                        'label' => 'Syarat & Ketentuan',
                        'route' => 'front.terms-conditions',
                    ],
                    [
                        'label' => 'Kebijakan Privasi',
                        'route' => 'front.privacy-policy',
                    ],
                ],
            ],
        ],
    ],
    'contact' => [
        'main' => [
            [
                'icon' => 'bx bx-location',
                'label' => 'Alamat',
                'value' => getSetting('contact_address'),
            ],
            [
                'icon' => 'bx bx-phone',
                'label' => 'Telp.',
                'value' => getSetting('contact_phone'),
            ],
            [
                'icon' => 'bx bx-printer',
                'label' => 'Fax',
                'value' => getSetting('contact_fax'),
            ],
        ],
        'help' => [
            [
                'icon' => 'bx bx-user-voice',
                'label' => 'Info Pelayanan',
                'value' => getSetting('contact_service_info'),
            ],
            [
                'icon' => 'bxl bx-whatsapp',
                'label' => 'WhatsApp',
                'value' => phone(getSetting('contact_whatsapp')),
            ],
            [
                'icon' => 'bx bx-envelope',
                'label' => 'Email',
                'value' => getSetting('contact_email'),
            ],
            [
                'icon' => 'bx bx-envelope',
                'label' => 'Email Support',
                'value' => getSetting('contact_support_email'),
            ],
        ],
    ],
    'socials' => Schema::hasTable('app_settings') ? [
        [
            'icon' => 'bxl bx-instagram',
            'url' => getSetting('social_instagram'),
        ],
        [
            'icon' => 'bxl bx-facebook',
            'url' => getSetting('social_facebook'),
        ],
        [
            'icon' => 'bxl bx-tiktok',
            'url' => getSetting('social_tiktok'),
        ],
    ] : [],
];
