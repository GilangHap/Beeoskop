<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    public $activeMenu = null;
    
    public function mount()
    {
        // Determine active menu based on current route
        $currentRoute = request()->route()->getName();
        
        // Extract the main section from the route name
        if (str_contains($currentRoute, '.')) {
            $this->activeMenu = explode('.', $currentRoute)[1];
        }
    }
    
    public function render()
    {
        return view('livewire.components.sidebar');
    }
}
