<?php

return [
    'name' => 'Panel',
    'navbar' => [
        [
            'label' => 'Website',
            'icon' => 'bx bx-globe',
            'route' => 'panel.web.index',
            'description' => 'View and manage the public site',
            'roles' => ['Developer', 'Super Admin', 'Admin', 'Finance', 'Human Resource'],
        ],
        [
            'label' => 'Access Control',
            'icon' => 'bx bx-shield',
            'route' => 'panel.acl.index',
            'description' => 'Manage roles, permissions, and access levels',
            'roles' => ['Developer', 'Super Admin'],
        ],
        [
            'label' => 'Monitoring',
            'icon' => 'bx bx-pulse',
            'route' => 'pulse',
            'description' => 'Keep track of app performance',
            'roles' => ['Developer', 'Super Admin'],
        ],
        [
            'label' => 'Logs',
            'icon' => 'bx bx-clipboard-detail',
            'route' => 'log-viewer.index',
            'description' => 'View system and application logs',
            'attributes' => [
                'wire:navigate' => true,
            ],
            'roles' => ['Developer', 'Super Admin'],
        ],
        [
            'label' => 'Documentation',
            'icon' => 'bx bx-book-open',
            'route' => 'panel.main.documentation.index',
            'description' => 'Browse the system documentation',
            'roles' => ['Developer', 'Super Admin', 'Admin', 'Finance', 'Human Resource'],
        ],
    ],

    'sidebar' => [
        'web' => [
            // Dashboard
            [
                'type' => 'menu',
                'label' => 'dashboard',
                'icon' => 'bx bx-home',
                'route' => 'panel.web.index',
                'active' => 'panel.web.index',
                'permissions' => ['view-dashboard']
            ],

            // Content Management (sorted by most frequently accessed by users)
            [
                'type' => 'divider',
                'label' => 'content_management',
                'permissions' => [
                    'view-post',
                    'view-post-category',
                    'view-content',
                    'view-page',
                    // removed: 'view-product',
                    // removed: 'view-product-category',
                    // removed: 'view-store',
                    // removed: 'view-store-category',
                    // removed: 'view-career',
                    // removed: 'view-career-category',
                    // removed: 'view-career-applicants',
                    // removed: 'view-investor',
                    // removed: 'view-investor-documents',
                    // removed: 'view-investor-faq',
                    // removed: 'view-investor-category',
                    'view-faq-category',
                    // removed: 'view-collaboration-request'
                ]
            ],
            // 1. Posts (Blog/News/Articles)
            [
                'type' => 'menu',
                'label' => 'post',
                'icon' => 'bx bx-news',
                'active' => 'panel.web.post.*',
                'permissions' => [
                    'view-post',
                    'view-post-category'
                ],
                'children' => [
                    [
                        'type' => 'menu',
                        'label' => 'all_post',
                        'route' => 'panel.web.post.main.index',
                        'active' => 'panel.web.post.main.*',
                        'permissions' => ['view-post']
                    ],
                    [
                        'type' => 'menu',
                        'label' => 'categories',
                        'route' => 'panel.web.post.category.index',
                        'active' => 'panel.web.post.category.*',
                        'permissions' => ['view-post-category']
                    ]
                ],
            ],
            // 2. Pages & Content
            [
                'type' => 'menu',
                'label' => 'contents',
                'icon' => 'bx bx-file-detail',
                'active' => ['panel.web.content.*', 'panel.web.page.*'],
                'permissions' => [
                    'view-content',
                    'view-page'
                ],
                'children' => [
                    [
                        'type' => 'menu',
                        'label' => 'pages',
                        'route' => 'panel.web.page.index',
                        'active' => 'panel.web.page.*',
                        'permissions' => ['view-page']
                    ],
                    [
                        'type' => 'menu',
                        'label' => 'content_list',
                        'route' => 'panel.web.content.index',
                        'active' => 'panel.web.content.*',
                        'permissions' => ['view-content']
                    ],
                ],
            ],
            // Removed: Products, Stores, Career, Investor, Collaboration, Instagram

            // Marketing & Engagement
            [
                'type' => 'divider',
                'label' => 'marketing_and_seo',
                'permissions' => [
                    'view-slider',
                    'view-seo',
                    // removed: 'view-instagram'
                ]
            ],
            [
                'type' => 'menu',
                'label' => 'slider',
                'icon' => 'bx bx-image',
                'route' => 'panel.web.slider.index',
                'active' => 'panel.web.slider.*',
                'permissions' => ['view-slider']
            ],
            [
                'type' => 'menu',
                'label' => 'seo',
                'icon' => 'bx bx-megaphone',
                'route' => 'panel.web.seo.index',
                'active' => 'panel.web.seo.*',
                'permissions' => ['view-seo'],
            ],
            // [
            //     'type' => 'menu',
            //     'label' => 'faq',
            //     'icon' => 'bx bx-help-circle',
            //     'active' => 'panel.web.faq.*',
            //     'permissions' => ['view-faq'],
            //     'children' => [
            //         [
            //             'type' => 'menu',
            //             'label' => 'all_faq',
            //             'route' => 'panel.web.faq.main.index',
            //             'active' => 'panel.web.faq.main.*',
            //             'permissions' => ['view-faq']
            //         ],
            //         [
            //             'type' => 'menu',
            //             'label' => 'faq_categories',
            //             'route' => 'panel.web.faq.category.index',
            //             'active' => 'panel.web.faq.category.*',
            //             'permissions' => ['view-faq-category']
            //         ],
            //     ],
            // ],

            // Customer Management
            [
                'type' => 'divider',
                'label' => 'customer_management',
                'permissions' => [
                    'view-contact-message'
                ]
            ],
            [
                'type' => 'menu',
                'label' => 'guest_messages',
                'icon' => 'bx bx-envelope',
                'route' => 'panel.web.contactmessage.index',
                'active' => 'panel.web.contactmessage.*',
                'permissions' => ['view-contact-message']
            ],
        ],

        'acl' => [
            [
                'type' => 'menu',
                'label' => 'dashboard',
                'icon' => 'bx bx-home',
                'route' => 'panel.acl.index',
                'active' => 'panel.acl.index',
                'permissions' => ['view-acl-dashboard']
            ],
            [
                'type' => 'menu',
                'label' => 'sessions',
                'icon' => 'bx bx-pulse',
                'route' => 'panel.acl.session.index',
                'active' => 'panel.acl.session.*',
                'permissions' => ['view-session']
            ],
            [
                'type' => 'menu',
                'label' => 'users',
                'icon' => 'bx bx-user',
                'route' => 'panel.acl.user.index',
                'active' => 'panel.acl.user.*',
                'permissions' => ['view-user']
            ],
            [
                'type' => 'menu',
                'label' => 'roles',
                'icon' => 'bx bx-shield',
                'route' => 'panel.acl.role.index',
                'active' => 'panel.acl.role.*',
                'permissions' => ['view-role']
            ],
            [
                'type' => 'menu',
                'label' => 'permissions',
                'icon' => 'bx bx-lock ',
                'route' => 'panel.acl.permission.index',
                'active' => 'panel.acl.permission.*',
                'permissions' => ['view-permission']
            ],
        ],

        'footer' => [
            [
                'label' => 'My Account',
                'icon' => 'bx bx-user',
                'route' => 'panel.main.account',
                'description' => 'Manage your account settings and preferences',
            ],
            [
                'label' => 'Settings',
                'icon' => 'bx bx-cog',
                'route' => 'panel.main.setting.index',
                'description' => 'Configure system settings and preferences',
            ],
        ],
    ],
];
