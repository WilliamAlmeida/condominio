<?php

namespace App\Livewire\Tenant\Moradores;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Tenant\Moradores;
use Livewire\Attributes\Validate;

class MoradorImoveisModal extends Component
{
    use Actions;

    public $moradorImoveisModal = false;
 
    public Moradores $morador;

    public Moradores $proprietario;

    public $imoveis = [];

    public $imovel_id;

    #[\Livewire\Attributes\On('edit-imoveis')]
    public function edit($rowId): void
    {
        $this->reset();

        $this->morador = Moradores::with('imoveis')->find($rowId);

        if($this->morador->imoveis) $this->imoveis = $this->morador->imoveis;

        $this->js('$openModal("moradorImoveisModal")');
    }

    private function updateListImoveis()
    {
        $this->imoveis = $this->morador->imoveis()->get();
    }

    public function adicionar_imovel()
    {
        if(!$this->imovel_id) {
            return $this->dialog()->info('Adicionar Imóvel', 'Selecione um imóvel para adicionar ao morador.');
        }

        try {
            $this->morador->imoveis()->attach($this->imovel_id);

            $this->reset('imovel_id');

            $this->updateListImoveis();

            $this->notification([
                'title'       => 'Imóvel adicionado!',
                'description' => 'Lista de Imóveis atualizada com sucesso.',
                'icon'        => 'success'
            ]);
        } catch (\Throwable $th) {
            // throw $th;
    
            $this->notification([
                'title'       => 'Falha na atualização!',
                'description' => 'Não foi possivel adicionar o Imóvel.',
                'icon'        => 'error'
            ]);
        }
    }

    public function remover_imovel($imovel_id, $params=null)
    {
        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Remover este imóvel deste morador?',
                'acceptLabel' => 'Sim, remova',
                'method'      => 'remover_imovel',
                'params'      => [$imovel_id, 'Deleted'],
            ]);
            return;
        }

        try {
            $this->morador->imoveis()->find($imovel_id)->update(['proprietario_id' => null]);

            $this->reset('imovel_id');

            $this->updateListImoveis();

            $this->notification([
                'title'       => 'Imóvel removido!',
                'description' => 'Lista de Imóveis atualizada com sucesso.',
                'icon'        => 'success'
            ]);
        } catch (\Throwable $th) {
            // throw $th;
    
            $this->notification([
                'title'       => 'Falha na atualização!',
                'description' => 'Não foi possivel remover o Imóvel.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.moradores.morador-imoveis-modal');
    }
}
