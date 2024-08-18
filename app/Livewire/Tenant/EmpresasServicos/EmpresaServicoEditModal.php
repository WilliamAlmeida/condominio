<?php

namespace App\Livewire\Tenant\EmpresasServicos;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Traits\HelperQueries;
use App\Models\Tenant\Enderecos;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\EmpresasServicos;
use App\Http\Controllers\Api\CepController;
use App\Livewire\Forms\Tenant\EnderecoForm;
use App\Livewire\Forms\Tenant\EmpresaServicoForm;

class EmpresaServicoEditModal extends Component
{
    use Actions;
    use HelperQueries;

    public $empresaservicoEditModal = false;

    public EmpresasServicos $empresaservico;

    public $array_estados;
 
    public EmpresaServicoForm $form;
    public EnderecoForm $endereco;

    public function mount()
    {
        $this->array_estados = $this->array_estados();
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->form->resetValidation();
        $this->endereco->resetValidation();

        $this->empresaservico = EmpresasServicos::with('endereco')->find($rowId);

        $this->form->fill($this->empresaservico);

        if($this->empresaservico->endereco) {
            $this->endereco->fill($this->empresaservico->endereco);
        }else{
            $this->endereco->reset();
        }

        $this->js('$openModal("empresaservicoEditModal")');
    }

    public function updated($name, $value) 
    {
        if($name == 'endereco.estado_id') {
            if(!$value) $this->endereco->cidade_id = null;
        }
    }

    public function pesquisar_cep()
    {
        $cep = preg_replace( '/[^0-9]/', '', $this->endereco->cep);

        if(empty($cep)) {
            // $this->set_focus(['query' => '[name="endereco.cep"]']);
            return;
        }

        $helper = new CepController;
        $response = json_decode($helper->show($cep));

        if($response->status == 'ERROR') {
            // $this->set_focus(['query' => '[name="endereco.cep"]']);

            $this->dialog()->error(
                $title = 'Error!!!',
                $description = $response->message
            );
            return;
        }

        $this->endereco->fillCep($response);

        $this->notification()->success(
            $title = 'Cep Encontrado',
            $description = "Busca pelo CEP {$this->endereco->cep} foi finalizada!"
        );

        // $this->set_focus(['query' => '[name="endereco.numero"]']);
        $this->endereco->resetValidation();
    }

    public function save($params=null)
    {
        $this->form->validate([
            'cnpj' => tenant()->unique('empresas_servicos')->ignore($this->empresaservico)
        ]);

        $validated = $this->form->validate();

        $address_validated = $this->endereco->validate();

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Atualizar as informações desta empresa de serviço?',
                'acceptLabel' => 'Sim, atualize',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            $this->empresaservico->update($validated);

            if($this->empresaservico->endereco) {
                $this->empresaservico->endereco->update($address_validated);
            } else {
                $endereco = Enderecos::create($address_validated);
                $this->empresaservico->update(['endereco_id' => $endereco->id]);
            }

            $this->reset('empresaservicoEditModal');
    
            $this->notification([
                'title'       => 'Empresa de Serviço atualizada!',
                'description' => 'Empresa de Serviço foi atualizada com sucesso.',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();

            // throw $th;
    
            $this->notification([
                'title'       => 'Falha na atualização!',
                'description' => 'Não foi possivel atualizar a Empresa de Serviço.',
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
                'description' => 'Deletar este empresa de serviço?',
                'acceptLabel' => 'Sim, delete',
                'method'      => 'delete',
                'params'      => 'Deleted',
            ]);
            return;
        }

        try {
            $this->empresaservico->endereco()->delete();
            $this->empresaservico->delete();

            $this->reset('empresaservicoEditModal');

            $this->notification([
                'title'       => 'Empresa de Serviço deletada!',
                'description' => 'Empresa de Serviço foi deletada com sucesso',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            //throw $th;
    
            $this->notification([
                'title'       => 'Falha ao deletar!',
                'description' => 'Não foi possivel deletar a Empresa de Serviço.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.empresas-servicos.empresa-servico-edit-modal');
    }
}
