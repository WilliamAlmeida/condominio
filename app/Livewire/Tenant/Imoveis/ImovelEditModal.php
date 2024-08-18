<?php

namespace App\Livewire\Tenant\Imoveis;

use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use App\Models\Tenant\Imoveis;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use App\Livewire\Forms\Tenant\ImovelForm;
use App\Traits\HelperActions;

class ImovelEditModal extends Component
{
    use Actions;
    use WithFileUploads;
    use HelperActions;

    public $imovelEditModal = false;
 
    public Imoveis $imovel;

    #[Locked]
    public $blocos = [];

    #[Locked]
    public $array_tipo_imovel = [];

    #[Locked]
    public $proprietario_selecionado;

    public ImovelForm $form;

    public function mount()
    {
        $this->array_tipo_imovel = Imoveis::$tipos_imoveis;
        $this->blocos = tenant()->blocos()->get();
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->form->resetValidation();
        $this->form->reset();
        $this->form->resetInputFile($this);

        $this->imovel = Imoveis::with(['fotos:id,url,rel_table,rel_id', 'proprietario' => fn ($query) => $query->withCount('imoveis')])->find($rowId);

        $this->form->fill($this->imovel);
        $this->form->fotos = $this->imovel?->fotos;

        $this->reset('proprietario_selecionado');
        if($this->imovel->proprietario_id) $this->proprietario_selecionado = $this->imovel->proprietario;

        $this->js('$openModal("imovelEditModal")');
    }

    public function pesquisar_proprietario()
    {
        $this->proprietario_selecionado = $this->form->searchProprietario();
    }

    public function save($params=null)
    {
        $validated = $this->form->validate();

        if($this->form->tipo == 'casa') {
            $validated = array_merge($validated, $this->form->validate([ 
                'rua' => 'required|min:3',
            ]));
        }elseif($this->form->tipo == 'apartamento') {
            $validated = array_merge($validated, $this->form->validate([ 
                'andar' => 'required|min:1',
            ]));
        }

        if($params == null) {
            $proprietario_in_moradores = $this->imovel->moradores()->whereMoradorId($this->form->proprietario_id)->exists();

            if($proprietario_in_moradores) {
                $this->dialog()->confirm([
                    'title'       => 'Atenção!',
                    'description' => 'O Proprietário selecionado já consta cadastrado na lista de moradores deste imóvel.<br/><br/>Deseja continuar mesmo assim?',
                    'acceptLabel' => 'Sim, atualize',
                    'method'      => 'save',
                    'params'      => ['Saved', 'remove_morador' => [$this->form->proprietario_id]],
                ]);
                return;
            }

            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Atualizar as informações deste imovel?',
                'acceptLabel' => 'Sim, atualize',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            throw_unless($this->form->saveFoto($this->imovel), 'Falha ao salvar a foto');

            $this->imovel->update($validated);

            if(is_array($params) && isset($params['remove_morador'])) {
                $this->imovel->moradores()->detach($params['remove_morador']);
            }

            $this->reset('imovelEditModal');
    
            $this->notification([
                'title'       => 'Imovel atualizado!',
                'description' => 'Imovel foi atualizado com sucesso.',
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
                'description' => 'Não foi possivel atualizar o Imovel.',
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
                'description' => 'Deletar este imovel?',
                'acceptLabel' => 'Sim, delete',
                'method'      => 'delete',
                'params'      => 'Deleted',
            ]);
            return;
        }

        try {
            $this->imovel->delete();

            $this->reset('imovelEditModal');

            $this->notification([
                'title'       => 'Imovel deletado!',
                'description' => 'Imovel foi deletado com sucesso',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            // throw $th;
    
            $this->notification([
                'title'       => 'Falha ao deletar!',
                'description' => 'Não foi possivel deletar o Imovel.',
                'icon'        => 'error'
            ]);
        }
    }

    public function cancel_foto_tmp($index)
    {
        $this->form->cancelFotoTemp($index);
    }

    public function deleteFoto($index, $params=null)
    {
        if($params == null) {
            $this->dialog()->confirm([
                'icon'        => 'trash',
                'title'       => 'Você tem certeza?',
                'description' => 'Deletar a foto?',
                'acceptLabel' => 'Sim, delete',
                'method'      => 'delete_foto',
                'params'      => [$index, 'Deleted'],
            ]);
            return;
        }

        try {
            $this->form->deleteFoto($this->imovel, $index);

            $this->notification([
                'title'       => 'Foto deletada!',
                'description' => 'Foto foi deletada com sucesso',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            // throw $th;
    
            $this->notification([
                'title'       => 'Falha ao deletar!',
                'description' => 'Não foi possivel deletar a foto.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.imoveis.imovel-edit-modal');
    }
}
