<?php

namespace Modules\Panel\Enums;

enum Documentation: string
{
    case CodeBase = 'code-base';
    case Website = 'website';
    case AccessControl = 'access-control';

    /**
     * Get the directory path for this documentation type.
     */
    public function getDirectory($locale): string
    {
        return match ($this) {
            self::AccessControl => storage_path('app/docs/access-control/' . $locale),
            self::CodeBase => storage_path('app/docs/code-base/' . $locale),
            self::Website => storage_path('app/docs/website/' . $locale),
        };
    }

    /**
     * Get all markdown files in the documentation directory.
     *
     * @return array
     */
    public function getFiles($locale): array
    {
        $directory = $this->getDirectory($locale);
        if (!is_dir($directory)) {
            return [];
        }
        $files = glob($directory . '/*.md');
        return $files ?: [];
    }

    /**
     * Get a human-readable label for the documentation type.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::AccessControl => 'Access Control',
            self::CodeBase => 'Code Base',
            self::Website => 'Website',
        };
    }

    /**
     * Get the route name or URL for this documentation type.
     *
     * @return string
     */
    public function route(): string
    {
        return match ($this) {
            self::AccessControl => route('panel.documentation.show', ['type' => self::AccessControl->value]),
            self::CodeBase => route('panel.documentation.show', ['type' => self::CodeBase->value]),
            self::Website => route('panel.documentation.show', ['type' => self::Website->value]),
        };
    }

    /**
     * Get the default markdown file name (without extension) for this documentation type and locale.
     *
     * @return string
     */
    public function defaultFile(): string
    {
        return match ($this) {
            self::AccessControl => 'overview',
            self::CodeBase => 'introduction',
            self::Website => 'overview',
        };
    }

    /**
     * Get a listing of markdown file names (without extension) for this documentation type and locale.
     *
     * @return array
     */
    public function fileListing(): array
    {
        return match ($this) {
            self::AccessControl => [
                ['name' => 'overview', 'roles' => ['Developer', 'Super Admin', 'Admin', 'Finance', 'Human Resource']],
                ['name' => 'sessions', 'roles' => ['Developer', 'Super Admin']],
                ['name' => 'users', 'roles' => ['Developer', 'Super Admin']],
                ['name' => 'roles', 'roles' => ['Developer', 'Super Admin']],
                ['name' => 'permissions', 'roles' => ['Developer', 'Super Admin']],
            ],
            self::CodeBase => [
                ['name' => 'introduction', 'roles' => ['Developer', 'Super Admin', 'Admin', 'Finance', 'Human Resource']],
                ['name' => 'configuration', 'roles' => ['Developer', 'Super Admin']],
                ['name' => 'user-roles', 'roles' => ['Developer', 'Super Admin', 'Admin', 'Finance', 'Human Resource']],
            ],
            self::Website => [
                ['name' => 'overview', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'category', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'contact-message', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'content', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'dashboard', 'roles' => ['Developer', 'Super Admin', 'Admin', 'Finance', 'Human Resource']],
                ['name' => 'faq', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'page', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'post', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'profile', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'roles', 'roles' => ['Developer', 'Super Admin']],
                ['name' => 'seo', 'roles' => ['Developer', 'Super Admin']],
                ['name' => 'slider', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'customer', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'setting', 'roles' => ['Developer', 'Super Admin', 'Admin']],
                ['name' => 'notification', 'roles' => ['Developer', 'Super Admin', 'Admin']],
            ],
        };
    }
}
