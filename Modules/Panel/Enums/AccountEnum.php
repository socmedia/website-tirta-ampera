<?php

namespace Modules\Panel\Enums;

enum AccountEnum: string
{
    case ACCOUNT = 'account';
    case SECURITY = 'security';
    case PREFERENCE = 'preference';

    /**
     * Get the account tabs
     *
     * @return array Returns the account tabs configuration
     */
    public static function getTabs(): array
    {
        return [
            [
                'id' => self::ACCOUNT->value,
                'label' => 'Account',
                'icon' => 'bx bx-user',
                'route' => 'panel.main.account',
            ],
            [
                'id' => self::SECURITY->value,
                'label' => 'Security',
                'icon' => 'bx bx-lock',
                'route' => 'panel.main.security',
            ],
            [
                'id' => self::PREFERENCE->value,
                'label' => 'Preference',
                'icon' => 'bx bx-cog',
                'route' => 'panel.main.preference',
            ],
        ];
    }
}