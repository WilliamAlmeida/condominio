<?php

namespace App\Livewire\Tenant\Pets;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Tenant\Pets;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use App\Livewire\Forms\Tenant\PetForm;

class PetCreateModal extends Component
{
    use Actions;
    use WithFileUploads;

    public $petCreateModal = false;

    #[Locked]
    public $array_porte_pet = [];

    #[Locked]
    public $proprietario_selecionado;

    public PetForm $form;

    public function mount()
    {
        $this->array_porte_pet = Pets::$portes_pets;
    }

    #[\Livewire\Attributes\On('create')]
    public function create(): void
    {
        $this->form->resetValidation();
        $this->form->reset();
        $this->form->resetInputFile($this);

        $this->js('$openModal("petCreateModal")');
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
                'description' => 'Registrar este novo pet?',
                'acceptLabel' => 'Sim, registre',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            $pet = Pets::create($this->form->all());

            throw_unless($this->form->saveFoto($pet), 'Falha ao salvar a foto');

            $pet->update(['foto_id' => $this->form->foto->id]);

            $this->reset('petCreateModal');
    
            $this->notification([
                'title'       => 'Pet registrado!',
                'description' => 'Pet foi registrado com sucesso.',
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
                'description' => 'Não foi possivel registrar o Pet.',
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
        return view('livewire.tenant.pets.pet-create-modal');
    }
}
