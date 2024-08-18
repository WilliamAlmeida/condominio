<?php

namespace App\Livewire\Tenant\Blocos;

use App\Models\Tenant\Blocos;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

class BlocoCreateModal extends Component
{
    use Actions;

    public $blocoCreateModal = false;
 
    #[Validate('required|min:3')]
    public $nome;

    #[\Livewire\Attributes\On('create')]
    public function create(): void
    {
        $this->resetValidation();

        $this->reset();

        $this->js('$openModal("blocoCreateModal")');
    }

    public function save($params=null)
    {
        $validated = $this->validate();
        
        $this->validate([
            'nome' => tenant()->unique('blocos')
        ]);

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Registrar este novo bloco?',
                'acceptLabel' => 'Sim, registre',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            $bloco = Blocos::create($validated);

            $this->reset('blocoCreateModal');
    
            $this->notification([
                'title'       => 'Bloco registrado!',
                'description' => 'Bloco foi registrado com sucesso.',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');

            DB::commit();
            // DB::rollBack();

        } catch (\Throwable $th) {
            DB::rollBack();

            // throw $th;
    
            $this->notification([
                'title'       => 'Falha no cadastro!',
                'description' => 'Não foi possivel registrar o Bloco.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.blocos.bloco-create-modal');
    }
}
