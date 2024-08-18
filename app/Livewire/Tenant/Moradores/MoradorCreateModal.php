<?php

namespace App\Livewire\Tenant\Moradores;

use App\Livewire\Forms\Tenant\MoradorForm;
use App\Models\Tenant\Moradores;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class MoradorCreateModal extends Component
{
    use Actions;
    use WithFileUploads;

    public $moradorCreateModal = false;

    public MoradorForm $form;

    #[\Livewire\Attributes\On('create')]
    public function create(): void
    {
        $this->form->resetValidation();
        $this->form->reset();
        $this->form->resetInputFile($this);

        $this->js('$openModal("moradorCreateModal")');
    }

    public function save($params=null)
    {
        $this->form->validate([
            'cpf' => tenant()->unique('moradores')
        ]);

        $this->form->validate();

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Registrar este novo morador?',
                'acceptLabel' => 'Sim, registre',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            $morador = Moradores::create($this->form->except('foto_tmp', 'foto'));

            throw_unless($this->form->saveFoto($morador), 'Falha ao salvar a foto');

            $this->reset('moradorCreateModal');
    
            $this->notification([
                'title'       => 'Morador registrado!',
                'description' => 'Morador foi registrado com sucesso.',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');

            DB::commit();

        } catch (\Throwable $th) {
            $this->form->cancelFotoSaved();

            DB::rollBack();

            // throw $th;
    
            $this->notification([
                'title'       => 'Falha no cadastro!',
                'description' => 'Não foi possivel registrar o Morador.',
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
        return view('livewire.tenant.moradores.morador-create-modal');
    }
}
