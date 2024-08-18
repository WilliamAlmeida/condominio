<?php

namespace App\Livewire\Tenant\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.tenant')]
class DashboardIndex extends Component
{
    public function render()
    {
        return view('livewire.tenant.dashboard.dashboard-index');
    }
}
