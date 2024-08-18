<?php

namespace App\Livewire\Tenant\Blocos;

use App\Models\Tenant\Blocos;
use Livewire\Attributes\Validate;
use Livewire\Component;
use WireUi\Traits\Actions;

class BlocoEditModal extends Component
{
    use Actions;

    public $blocoEditModal = false;
 
    public Blocos $bloco;

    #[Validate('required|min:3')]
    public $nome;

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->resetValidation();

        $this->bloco = Blocos::find($rowId);

        $this->fill($this->bloco);

        $this->js('$openModal("blocoEditModal")');
    }

    public function save($params=null)
    {
        $validated = $this->validate();

        $this->validate([
            'nome' => tenant()->unique('blocos')->ignore($this->bloco)
        ]);

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Atualizar as informações deste bloco?',
                'acceptLabel' => 'Sim, atualize',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        try {
            $this->bloco->update($validated);

            $this->reset('blocoEditModal');
    
            $this->notification([
                'title'       => 'Bloco atualizado!',
                'description' => 'Bloco foi atualizado com sucesso.',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            // throw $th;
    
            $this->notification([
                'title'       => 'Falha na atualização!',
                'description' => 'Não foi possivel atualizar o Bloco.',
                'icon'        => 'error'
            ]);
        }
    }

    public function delete($params=null)
    {
        if($params == null) {
            $this->dialog()->confirm([
                'icon'        => 'trash',
                'title'       => 'Você tem certeza?',
                'description' => 'Deletar este bloco?',
                'acceptLabel' => 'Sim, delete',
                'method'      => 'delete',
                'params'      => 'Deleted',
            ]);
            return;
        }

        try {
            $this->bloco->delete();

            $this->reset('blocoEditModal');

            $this->notification([
                'title'       => 'Bloco deletado!',
                'description' => 'Bloco foi deletado com sucesso',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            //throw $th;
    
            $this->notification([
                'title'       => 'Falha ao deletar!',
                'description' => 'Não foi possivel deletar o Bloco.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.blocos.bloco-edit-modal');
    }
}
