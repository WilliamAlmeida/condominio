<?php

namespace App\Livewire\Tenant\Imoveis;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Tenant\Imoveis;
use Livewire\Attributes\Locked;
use App\Models\Tenant\Moradores;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;

class ImovelCreateModal extends Component
{
    use Actions;

    public $imovelCreateModal = false;

    #[Locked]
    public $blocos = [];

    #[Locked]
    public $array_tipo_imovel = [];

    #[Validate('nullable|min:1')]
    public $bloco_id = null;

    #[Validate('required|min:1', as: 'Tipo do Imóvel')]
    public $tipo = null;

    public $andar = null;
    public $rua = null;

    #[Validate('nullable|min:1')]
    public $numero = null;

    #[Validate('nullable|min:1')]
    public $proprietario_id = null;
    #[Locked]
    public $proprietario_selecionado;

    public function mount()
    {
        $this->array_tipo_imovel = Imoveis::$tipos_imoveis;
        $this->blocos = tenant()->blocos()->get();
    }

    #[\Livewire\Attributes\On('create')]
    public function create(): void
    {
        $this->resetValidation();

        $this->reset('bloco_id', 'tipo', 'andar', 'rua', 'numero', 'proprietario_id', 'proprietario_selecionado');

        $this->js('$openModal("imovelCreateModal")');
    }

    public function pesquisar_proprietario()
    {
        if($this->proprietario_id) {
            $this->proprietario_selecionado = Moradores::withCount('imoveis')->find($this->proprietario_id);
        }else{
            $this->reset('proprietario_selecionado');
        }
    }

    public function save($params=null)
    {
        $validated = $this->validate();

        if($this->tipo == 'casa') {
            $validated = array_merge($validated, $this->validate([ 
                'rua' => 'required|min:3',
            ]));
        }elseif($this->tipo == 'apartamento') {
            $validated = array_merge($validated, $this->validate([ 
                'andar' => 'required|min:1',
            ]));
        }

        if($params == null) {
            $this->dialog()->confirm([
                'title'       => 'Você tem certeza?',
                'description' => 'Registrar este novo imóvel?',
                'acceptLabel' => 'Sim, registre',
                'method'      => 'save',
                'params'      => 'Saved',
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            $imovel = Imoveis::create($validated);

            // tenant()->imoveis()->attach($imovel);

            $this->reset('imovelCreateModal');
    
            $this->notification([
                'title'       => 'Imovel registrado!',
                'description' => 'Imovel foi registrado com sucesso.',
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
                'description' => 'Não foi possivel registrar o Imovel.',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tenant.imoveis.imovel-create-modal');
    }
}
