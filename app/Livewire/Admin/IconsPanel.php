<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;

class IconsPanel extends Component
{
    public $iconsPanelModal = true;

    #[On('openIconsPanel')]
    public function openIconsPanel()
    {
        $this->iconsPanelModal = true;
    }

    public function render()
    {
        return view('livewire.admin.icons-panel');
    }
}
