<?php

namespace App\Livewire\Tenant\Imoveis;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Tenant\Imoveis;
use App\Models\Tenant\Moradores;
use Livewire\Attributes\Validate;

class ImovelMoradoresModal extends Component
{
    use Actions;

    public $imovelMoradoresModal = false;
 
    public Imoveis $imovel;

    public Moradores $proprietario;

    public $moradores = [];

    public $morador_id;

    #[\Livewire\Attributes\On('edit-moradores')]
    public function edit($rowId): void
    {
        $this->reset();

        $this->imovel = Imoveis::with('proprietario', 'moradores')->find($rowId);

        if($this->imovel->proprietario) $this->proprietario = $this->imovel->proprietario;
        if($this->imovel->moradores) $this->moradores = $this->imovel->moradores;

        $this->js('$openModal("imovelMoradoresModal")');
    }

    private function updateListMoradores()
    {
        $this->moradores = $this->imovel->moradores()->get();
    }

    public function adicionar_morador()
    {
        if(!$this->morador_id) {
            return $this->dialog()->info('Adicionar Morador', 'Selecione um morador para adicionar ao imóvel.');
        }

        try {
            $this->imovel->moradores()->attach($this->morador_id);

            $this->reset('morador_id');

            $this->updateListMoradores();

            $this->notification([
                'title'       => 'Morador adicionado!',
                'description' => 'Lista de Moradores atualizada com sucesso.',
                'icon'        => 'success'
            ]);
        } catch (\Throwable $th) {
            // throw $th;
    
            $this->notification([
                'title'       => 'Falha na atualização!',
                'description' => 'Não foi possivel adicionar o Morador.',
                'icon'        => 'error'
            ]);
        }
    }

    public function remover_morador($morador_id, $params=null)
    {
        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Remover este morador deste imóvel?',
                'acceptLabel' => 'Sim, remova',
                'method'      => 'remover_morador',
                'params'      => [$morador_id, 'Deleted'],
            ]);
            return;
        }

        try {
            $this->imovel->moradores()->detach($morador_id);

            $this->reset('morador_id');

            $this->updateListMoradores();

            $this->notification([
                'title'       => 'Morador removido!',
                'description' => 'Lista de Moradores atualizada com sucesso.',
                'icon'        => 'success'
            ]);
        } catch (\Throwable $th) {
            // throw $th;
    
            $this->notification([
                'title'       => 'Falha na atualização!',
                'description' => 'Não foi possivel remover o Morador.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.imoveis.imovel-moradores-modal');
    }
}
