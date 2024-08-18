<?php

namespace App\Livewire\Conta;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Locked;

class ContaView extends Component
{
    #[Locked]
    public User $usuario;

    public function mount()
    {
        $this->usuario = User::with('foto:id,url,rel_table,rel_id')->find(auth()->id());
    }

    public function render()
    {
        $layout = tenant() ? 'components.layouts.tenant' : 'components.layouts.admin';

        return view('livewire.conta.conta-view')->layout($layout);
    }
}
