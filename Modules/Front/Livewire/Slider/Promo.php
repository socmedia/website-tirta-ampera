<?php

namespace Modules\Front\Livewire\Slider;

use Livewire\Component;
use Modules\Common\Services\SliderService;

class Promo extends Component
{
    /**
     * Holds the promo slider data.
     *
     * @var array
     */
    public array $slider = [];

    /**
     * Create a new component instance.
     */
    public function mount(SliderService $sliderService): void
    {
        $this->slider = $sliderService->getPublicSlider('promotion')->toArray();
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('front::livewire.slider.promo', [
            'promoSlider' => $this->slider,
        ]);
    }
}
