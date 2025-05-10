<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DynamicIcon extends Component
{
    public $icon;
    public $class;

    public function __construct($icon, $class = '')
    {
        $this->icon = $icon;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.dynamic-icon');
    }
}
