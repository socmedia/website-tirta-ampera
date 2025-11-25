<?php

namespace Modules\Front\Livewire\Slider;

use Livewire\Component;
use Modules\Common\Services\SliderService;

class Milestone extends Component
{
    public function render()
    {
        return view('front::livewire.slider.milestone', [
            'sliders' => (new SliderService)->getPublicSlider(type: 'milestone')
        ]);
    }
}
