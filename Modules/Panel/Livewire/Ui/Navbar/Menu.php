<?php

namespace Modules\Panel\Livewire\Ui\Navbar;

use Livewire\Component;

class Menu extends Component
{
    /**
     * Get the menu items for the navigation
     *
     * @return array<array{
     *     label: string,
     *     icon: string,
     *     route: string|null,
     *     description: string,
     *     attributes?: array<string, mixed>
     * }>
     */
    public function getMenuItems(): array
    {
        return config('panel.navbar');
    }

    public function render()
    {
        return view('panel::livewire.ui.navbar.menu', [
            'menuItems' => $this->getMenuItems(),
        ]);
    }
}
