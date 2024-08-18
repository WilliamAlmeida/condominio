<?php

namespace App\Livewire\Tenant\PrestadoresServicos;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Traits\HelperQueries;
use Livewire\WithFileUploads;
use App\Models\Tenant\Enderecos;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\PrestadoresServicos;
use App\Http\Controllers\Api\CepController;
use App\Livewire\Forms\Tenant\EnderecoForm;
use App\Livewire\Forms\Tenant\PrestadorServicoForm;

class PrestadorServicoEditModal extends Component
{
    use Actions;
    use HelperQueries;
    use WithFileUploads;

    public $prestadorservicoEditModal = false;

    public PrestadoresServicos $prestadorservico;

    public $array_tipos_prestadores;
    public $array_estados;
 
    public PrestadorServicoForm $form;
    public EnderecoForm $endereco;

    public function mount()
    {
        $this->array_tipos_prestadores = PrestadoresServicos::$tipos_prestadores;
        $this->array_estados = $this->array_estados();
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->form->resetValidation();
        $this->endereco->resetValidation();
        $this->form->reset();
        $this->form->resetInputFile($this);

        $this->prestadorservico = PrestadoresServicos::with('foto:id,url', 'endereco')->find($rowId);

        $this->form->fill($this->prestadorservico);
        $this->form->foto = $this->prestadorservico?->foto;

        if($this->prestadorservico->endereco) {
            $this->endereco->fill($this->prestadorservico->endereco);
        }else{
            $this->endereco->reset();
        }

        $this->js('$openModal("prestadorservicoEditModal")');
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
            'cpf' => tenant()->unique('prestadores_servicos')->ignore($this->prestadorservico)
        ]);

        $this->form->validate();

        $address_validated = $this->endereco->validate();

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Atualizar as informações deste prestador de serviço?',
                'acceptLabel' => 'Sim, atualize',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            throw_unless($this->form->saveFoto($this->prestadorservico), 'Falha ao salvar a foto');

            $this->prestadorservico->update($this->form->except('foto_tmp', 'foto'));

            if($this->prestadorservico->endereco) {
                $this->prestadorservico->endereco->update($address_validated);
            } else {
                $endereco = Enderecos::create($address_validated);
                $this->prestadorservico->update(['endereco_id' => $endereco->id]);
            }

            $this->reset('prestadorservicoEditModal');
    
            $this->notification([
                'title'       => 'Prestador de Serviço atualizado!',
                'description' => 'Prestador de Serviço foi atualizado com sucesso.',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');

            DB::commit();

        } catch (\Throwable $th) {
            $this->form->cancelFotoSaved();

            DB::rollBack();

            // throw $th;
    
            $this->notification([
                'title'       => 'Falha na atualização!',
                'description' => 'Não foi possivel atualizar o Prestador de Serviço.',
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
                'description' => 'Deletar este prestador de serviço?',
                'acceptLabel' => 'Sim, delete',
                'method'      => 'delete',
                'params'      => 'Deleted',
            ]);
            return;
        }

        try {
            $this->prestadorservico->endereco()->delete();
            $this->prestadorservico->delete();

            $this->reset('prestadorservicoEditModal');

            $this->notification([
                'title'       => 'Prestador de Serviço deletado!',
                'description' => 'Prestador de Serviço foi deletado com sucesso',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            //throw $th;
    
            $this->notification([
                'title'       => 'Falha ao deletar!',
                'description' => 'Não foi possivel deletar o PrestPrestador de ServiçoadorServico.',
                'icon'        => 'error'
            ]);
        }
    }

    public function cancel_foto_tmp()
    {
        $this->form->cancelFotoTemp($this->prestadorservico);
    }

    public function delete_foto($params=null)
    {
        if($params == null) {
            $this->dialog()->confirm([
                'icon'        => 'trash',
                'title'       => 'Você tem certeza?',
                'description' => 'Deletar a foto?',
                'acceptLabel' => 'Sim, delete',
                'method'      => 'delete_foto',
                'params'      => 'Deleted',
            ]);
            return;
        }

        try {
            $this->form->deleteFoto($this->prestadorservico);

            $this->notification([
                'title'       => 'Foto deletada!',
                'description' => 'Foto foi deletada com sucesso',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            //throw $th;
    
            $this->notification([
                'title'       => 'Falha ao deletar!',
                'description' => 'Não foi possivel deletar a foto.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.prestadores-servicos.prestador-servico-edit-modal');
    }
}
