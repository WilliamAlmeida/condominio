<?php

namespace App\Livewire\Tenant\Pets;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Tenant\Pets;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use App\Livewire\Forms\Tenant\PetForm;

class PetEditModal extends Component
{
    use Actions;
    use WithFileUploads;

    public $petEditModal = false;
 
    public Pets $pet;

    #[Locked]
    public $array_porte_pet = [];

    #[Locked]
    public $proprietario_selecionado;

    public PetForm $form;

    public function mount()
    {
        $this->array_porte_pet = Pets::$portes_pets;
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->reset('proprietario_selecionado');
        $this->form->resetValidation();
        $this->form->reset();
        $this->form->resetInputFile($this);

        $this->pet = Pets::with(['foto:id,url', 'proprietario' => fn ($query) => $query->withCount('pets')])->find($rowId);

        $this->form->fill($this->pet);
        $this->form->foto = $this->pet?->foto;
        $this->proprietario_selecionado = $this->pet?->proprietario;

        $this->js('$openModal("petEditModal")');
    }

    public function pesquisar_proprietario()
    {
        $this->proprietario_selecionado = $this->form->searchProprietario();
    }

    public function save($params=null)
    {
        $this->form->validate();

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Atualizar as informações deste pet?',
                'acceptLabel' => 'Sim, atualize',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            throw_unless($this->form->saveFoto($this->pet), 'Falha ao salvar a foto');

            $this->pet->update($this->form->except('foto_tmp', 'foto'));

            $this->reset('petEditModal');

            $this->notification([
                'title'       => 'Pet atualizado!',
                'description' => 'Pet foi atualizado com sucesso.',
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
                'description' => 'Não foi possivel atualizar o Pet.',
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
                'description' => 'Deletar este pet?',
                'acceptLabel' => 'Sim, delete',
                'method'      => 'delete',
                'params'      => 'Deleted',
            ]);
            return;
        }

        try {
            $this->pet->delete();

            $this->reset('petEditModal');

            $this->notification([
                'title'       => 'Pet deletado!',
                'description' => 'Pet foi deletado com sucesso',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            //throw $th;
    
            $this->notification([
                'title'       => 'Falha ao deletar!',
                'description' => 'Não foi possivel deletar o Pet.',
                'icon'        => 'error'
            ]);
        }
    }

    public function cancel_foto_tmp()
    {
        $this->form->cancelFotoTemp($this->pet);
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
            $this->form->deleteFoto($this->pet);

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
        return view('livewire.tenant.pets.pet-edit-modal');
    }
}
