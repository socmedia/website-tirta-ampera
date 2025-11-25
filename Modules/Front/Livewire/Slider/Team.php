<?php

namespace Modules\Front\Livewire\Slider;

use Livewire\Component;
use Modules\Common\Services\SliderService;

class Team extends Component
{
    public function render()
    {
        return view('front::livewire.slider.team', [
            'sliders' => (new SliderService)->getPublicSlider(type: 'bod')
        ]);
    }
}
