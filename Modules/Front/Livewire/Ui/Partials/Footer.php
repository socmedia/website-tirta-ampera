<?php

namespace Modules\Front\Livewire\Ui\Partials;

use Livewire\Component;
use Illuminate\Support\Arr;

class Footer extends Component
{
    /**
     * Get the footer data from config.
     */
    public function getFooterData(): array
    {
        return config('front.footer');
    }

    /**
     * Get the footer socials from config.
     */
    public function getSocials(): array
    {
        return config('front.socials');
    }

    /**
     * Get the footer contacts from config.
     */
    public function getContacts(): array
    {
        return config('front.contact');
    }

    public function render()
    {
        return view('front::livewire.ui.partials.footer', [
            'data' => $this->getFooterData(),
            'socials' => $this->getSocials(),
            'contact' => $this->getContacts(),
        ]);
    }
}
