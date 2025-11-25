<?php

namespace App\Traits;

use Modules\Common\Enums\Lang;

trait WithLocaleDropdown
{
    /**
     * The current display locale.
     *
     * @var string|null
     */
    public ?string $locale = null;

    /**
     * The available languages/locales.
     *
     * @var array
     */
    public array $languages = [];

    /**
     * Set the display locale and available languages.
     *
     * @return void
     */
    public function setLocale()
    {
        // You may want to customize this logic to fit your app's locale/language structure
        $locales = Lang::allInfo('$wire.changeLocale');
        $current = app()->getLocale() ?? 'en';

        $this->languages = $locales;
        $this->locale = $current;
    }

    /**
     * Change the display locale.
     *
     * @param string $code
     * @return void
     */
    public function changeLocale($code)
    {
        $this->locale = $code;
    }
}
