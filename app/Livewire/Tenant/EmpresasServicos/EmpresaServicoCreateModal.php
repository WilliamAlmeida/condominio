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
use App\Http\Controllers\Api\CnpjController;
use App\Livewire\Forms\Tenant\EmpresaServicoForm;

class EmpresaServicoCreateModal extends Component
{
    use Actions;
    use HelperQueries;

    public $empresaservicoCreateModal = false;

    public $array_estados;

    public EmpresaServicoForm $form;
    public EnderecoForm $endereco;

    public function mount()
    {
        $this->array_estados = $this->array_estados();
    }

    #[\Livewire\Attributes\On('create')]
    public function create(): void
    {
        $this->form->resetValidation();
        $this->form->reset();

        $this->endereco->resetValidation();
        $this->endereco->reset();

        $this->js('$openModal("empresaservicoCreateModal")');
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

    public function pesquisar_cnpj()
    {
        $cnpj = preg_replace( '/[^0-9]/', '', $this->form->cnpj);

        if(empty($cnpj)) {
            // $this->set_focus(['query' => '[name="form.cnpj"]']);
            return;
        }

        $helper = new CnpjController;
        $response = json_decode($helper->show($cnpj));

        if($response->status == 'ERROR') {
            // $this->set_focus(['query' => '[name="form.cnpj"]']);

            $this->dialog()->error(
                $title = 'Error!!!',
                $description = $response->message
            );
            return;
        }

        $this->form->fillCnpj($response);

        if(isset($response->cep)) {
            $this->endereco->cep = $response->cep;
            $this->pesquisar_cep();
        }


        $this->notification()->success(
            $title = 'CNPJ Encontrado',
            $description = "Busca pelo CNPJ {$this->form->cnpj} foi finalizada!"
        );

        // $this->set_focus(['query' => '[name="form.end_cep"]']);
        $this->form->resetValidation();
    }

    public function save($params=null)
    {
        $this->form->validate([
            'cnpj' => tenant()->unique('empresas_servicos')
        ]);

        $validated = $this->form->validate();

        $address_validated = $this->endereco->validate();

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Registrar este novo empresa de serviço?',
                'acceptLabel' => 'Sim, registre',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            $endereco = Enderecos::create($address_validated);

            $validated['endereco_id'] = $endereco->id;

            $empresaservico = EmpresasServicos::create($validated);

            $this->reset('empresaservicoCreateModal');
    
            $this->notification([
                'title'       => 'Empresa de Serviço registrada!',
                'description' => 'Empresa de Serviço foi registrada com sucesso.',
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
                'description' => 'Não foi possivel registrar a Empresa de Serviço.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.empresas-servicos.empresa-servico-create-modal');
    }
}
