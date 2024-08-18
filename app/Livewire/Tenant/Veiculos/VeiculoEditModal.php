<?php

namespace App\Livewire\Tenant\Veiculos;

use App\Models\Tenant\Veiculos;
use Livewire\Attributes\Validate;
use Livewire\Component;
use WireUi\Traits\Actions;

class VeiculoEditModal extends Component
{
    use Actions;

    public $veiculoEditModal = false;
 
    public Veiculos $veiculo;

    #[Validate('required|min:7')]
    public $placa;

    #[Validate('nullable|min:3')]
    public $modelo;

    #[Validate('nullable|min:3')]
    public $marca;

    #[Validate('nullable|min:3')]
    public $cor;

    #[Validate('nullable')]
    #[Validate('date_format:Y')]
    #[Validate('after:1900')]
    #[Validate('before_or_equal:Y', message: 'Ano deve ser igual ou anterior ao atual.')]
    public $ano;

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->resetValidation();

        $this->veiculo = Veiculos::find($rowId);

        $this->fill($this->veiculo);

        $this->js('$openModal("veiculoEditModal")');
    }

    public function save($params=null)
    {
        $this->validate([
            'placa' => tenant()->unique('veiculos')->ignore($this->veiculo)
        ]);

        $validated = $this->validate();

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Atualizar as informações deste veículo?',
                'acceptLabel' => 'Sim, atualize',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        try {
            $this->veiculo->update($validated);

            $this->reset('veiculoEditModal');
    
            $this->notification([
                'title'       => 'Veículo atualizado!',
                'description' => 'Veículo foi atualizado com sucesso.',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            // throw $th;
    
            $this->notification([
                'title'       => 'Falha na atualização!',
                'description' => 'Não foi possivel atualizar o Veículo.',
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
                'description' => 'Deletar este veiculo?',
                'acceptLabel' => 'Sim, delete',
                'method'      => 'delete',
                'params'      => 'Deleted',
            ]);
            return;
        }

        try {
            $this->veiculo->delete();

            $this->reset('veiculoEditModal');

            $this->notification([
                'title'       => 'Veiculo deletado!',
                'description' => 'Veiculo foi deletado com sucesso',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            //throw $th;
    
            $this->notification([
                'title'       => 'Falha ao deletar!',
                'description' => 'Não foi possivel deletar o Veiculo.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.veiculos.veiculo-edit-modal');
    }
}
