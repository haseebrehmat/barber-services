<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Slide extends Component
{
    public $slide;
    public $key;

    public function __construct($slide, $key)
    {
        $this->slide = $slide;
        $this->key = $key;
    }

    public function format($content)
    {
        $content = strip_tags($content);
        return strlen($content) > 130 ? substr($content, 0, 130) . "..." : $content;
    }

    public function render()
    {
        return view('components.slide');
    }
}
