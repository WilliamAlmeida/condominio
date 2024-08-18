<?php

namespace App\Livewire\Tenant\Moradores;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Tenant\Moradores;
use Illuminate\Support\Facades\DB;
use App\Livewire\Forms\Tenant\MoradorForm;
use Livewire\WithFileUploads;

class MoradorEditModal extends Component
{
    use Actions;
    use WithFileUploads;

    public $moradorEditModal = false;
 
    public Moradores $morador;

    public MoradorForm $form;

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->form->resetValidation();
        $this->form->reset();
        $this->form->resetInputFile($this);

        $this->morador = Moradores::with('foto:id,url')->find($rowId);

        $this->form->fill($this->morador);
        $this->form->foto = $this->morador?->foto;

        $this->js('$openModal("moradorEditModal")');
    }

    public function save($params=null)
    {
        $this->form->validate([
            'cpf' => tenant()->unique('moradores')->ignore($this->morador)
        ]);

        $this->form->validate();

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Atualizar as informações deste morador?',
                'acceptLabel' => 'Sim, atualize',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            throw_unless($this->form->saveFoto($this->morador), 'Falha ao salvar a foto');

            $this->morador->update($this->form->except('foto_tmp', 'foto'));

            $this->reset('moradorEditModal');
    
            $this->notification([
                'title'       => 'Morador atualizado!',
                'description' => 'Morador foi atualizado com sucesso.',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');

            DB::commit();

        } catch (\Throwable $th) {
            $this->form->cancelFotoSaved();

            DB::rollBack();

            throw $th;
    
            $this->notification([
                'title'       => 'Falha na atualização!',
                'description' => 'Não foi possivel atualizar o Morador.',
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
                'description' => 'Deletar este morador?',
                'acceptLabel' => 'Sim, delete',
                'method'      => 'delete',
                'params'      => 'Deleted',
            ]);
            return;
        }

        try {
            $this->morador->delete();

            $this->reset('moradorEditModal');

            $this->notification([
                'title'       => 'Morador deletado!',
                'description' => 'Morador foi deletado com sucesso',
                'icon'        => 'success'
            ]);

            $this->dispatch('pg:eventRefresh-default');
        } catch (\Throwable $th) {
            //throw $th;
    
            $this->notification([
                'title'       => 'Falha ao deletar!',
                'description' => 'Não foi possivel deletar o Morador.',
                'icon'        => 'error'
            ]);
        }
    }

    public function cancel_foto_tmp()
    {
        $this->form->cancelFotoTemp($this->morador);
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
            $this->form->deleteFoto($this->morador);

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
        return view('livewire.tenant.moradores.morador-edit-modal');
    }
}
