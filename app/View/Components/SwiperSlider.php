<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SwiperSlider extends Component
{

    public $sliders;

    public function __construct($sliders)
    {
        $this->sliders = $sliders;
    }

    public function render()
    {
        return view('components.swiper-slider');
    }
}
