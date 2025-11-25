<?php

namespace Modules\Front\Livewire\Slider;

use Livewire\Component;
use Modules\Common\Services\SliderService;

class Hero extends Component
{
    /**
     * Holds the hero slider data.
     *
     * @var array
     */
    public array $slider = [];

    /**
     * Create a new component instance.
     */
    public function mount(SliderService $sliderService): void
    {
        $this->slider = $sliderService->getPublicSlider('hero')->toArray();
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('front::livewire.slider.hero', [
            'heroSlides' => $this->slider,
        ]);
    }
}
