<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class About extends Component
{
    #[Layout('livewire.components.layouts.app')]
    public function render()
    {
        return view('livewire.about');
    }
}
