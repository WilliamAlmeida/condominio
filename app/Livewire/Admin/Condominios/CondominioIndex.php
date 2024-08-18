<?php

namespace App\Livewire\Admin\Condominios;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class CondominioIndex extends Component
{
    public function render()
    {
        return view('livewire.admin.condominios.condominio-index');
    }
}
