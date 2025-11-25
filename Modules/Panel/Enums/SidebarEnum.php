<?php

namespace Modules\Panel\Enums;

enum SidebarEnum: string
{
    case WEB = 'web';
    case ACL = 'acl';
    case MAIN = 'main';

    /**
     * Get the sidebar group based on the route
     *
     * @param string $route The route to check
     * @return self|null Returns the matching sidebar group or null if no match found
     */
    public static function getGroup(string $route): ?self
    {
        foreach (self::cases() as $case) {
            if (str_contains($route, "panel.{$case->value}.")) {
                return $case;
            }
        }
        return null;
    }
}