<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;

class Room extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
       return view('components.rooms.room-list-item');
    }
}
