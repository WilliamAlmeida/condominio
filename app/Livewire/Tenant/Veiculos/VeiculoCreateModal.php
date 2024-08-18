<?php

namespace App\Livewire\Tenant\Veiculos;

use App\Models\Tenant\Veiculos;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

class VeiculoCreateModal extends Component
{
    use Actions;

    public $veiculoCreateModal = false;

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

    #[\Livewire\Attributes\On('create')]
    public function create(): void
    {
        $this->resetValidation();

        $this->reset();

        $this->js('$openModal("veiculoCreateModal")');
    }

    public function save($params=null)
    {
        $this->validate([
            'placa' => tenant()->unique('veiculos')
        ]);

        $validated = $this->validate();

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Registrar este novo veículo?',
                'acceptLabel' => 'Sim, registre',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            $veiculo = Veiculos::create($validated);

            $this->reset('veiculoCreateModal');
    
            $this->notification([
                'title'       => 'Veículo registrado!',
                'description' => 'Veículo foi registrado com sucesso.',
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
                'description' => 'Não foi possivel registrar o Veículo.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.veiculos.veiculo-create-modal');
    }
}
