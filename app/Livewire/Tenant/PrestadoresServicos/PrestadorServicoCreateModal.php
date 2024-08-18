<?php

namespace App\Livewire\Tenant\PrestadoresServicos;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Traits\HelperQueries;
use App\Models\Tenant\Enderecos;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\PrestadoresServicos;
use App\Http\Controllers\Api\CepController;
use App\Livewire\Forms\Tenant\EnderecoForm;
use App\Livewire\Forms\Tenant\PrestadorServicoForm;
use Livewire\WithFileUploads;

class PrestadorServicoCreateModal extends Component
{
    use Actions;
    use HelperQueries;
    use WithFileUploads;

    public $prestadorservicoCreateModal = false;

    public $array_tipos_prestadores;
    public $array_estados;

    public PrestadorServicoForm $form;
    public EnderecoForm $endereco;

    public function mount()
    {
        $this->array_tipos_prestadores = PrestadoresServicos::$tipos_prestadores;
        $this->array_estados = $this->array_estados();
    }

    #[\Livewire\Attributes\On('create')]
    public function create(): void
    {
        $this->form->resetValidation();
        $this->form->reset();
        $this->form->resetInputFile($this);

        $this->endereco->resetValidation();
        $this->endereco->reset();

        $this->js('$openModal("prestadorservicoCreateModal")');
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
            'cpf' => tenant()->unique('prestadores_servicos')
        ]);

        $validated = $this->form->validate();

        $address_validated = $this->endereco->validate();

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Registrar este novo prestador de serviço?',
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

            $prestadorservico = PrestadoresServicos::create($validated);

            throw_unless($this->form->saveFoto($prestadorservico), 'Falha ao salvar a foto');

            $prestadorservico->update(['foto_id' => $this->form->foto->id]);

            $this->reset('prestadorservicoCreateModal');
    
            $this->notification([
                'title'       => 'Prestador de Serviço registrado!',
                'description' => 'Prestador de Serviço foi registrado com sucesso.',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');

            DB::commit();
            // DB::rollBack();

        } catch (\Throwable $th) {
            $this->form->cancelFotoSaved();

            DB::rollBack();

            // throw $th;
    
            $this->notification([
                'title'       => 'Falha no cadastro!',
                'description' => 'Não foi possivel registrar o Prestador de Serviço.',
                'icon'        => 'error'
            ]);
        }
    }

    public function cancel_foto_tmp()
    {
        $this->form->reset('foto_tmp', 'foto');
    }

    public function render()
    {
        return view('livewire.tenant.prestadores-servicos.prestador-servico-create-modal');
    }
}
