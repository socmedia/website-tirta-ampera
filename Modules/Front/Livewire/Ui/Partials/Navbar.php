<?php

namespace Modules\Front\Livewire\Ui\Partials;

use Livewire\Component;

class Navbar extends Component
{
    /**
     * Whether the navbar should always be fixed.
     *
     * @var bool
     */
    public bool $alwaysFixed = false;

    /**
     * Initialize the component.
     *
     * @param bool $alwaysFixed
     */
    public function mount(bool $alwaysFixed = false): void
    {
        $this->alwaysFixed = $alwaysFixed;
    }

    /**
     * Get the menu items for the navigation.
     */
    public function getMenuItems(): array
    {
        return config('front.navbar', []);
    }

    public function render()
    {
        return view('front::livewire.ui.partials.navbar', [
            'menuItems' => $this->getMenuItems(),
        ]);
    }
}
