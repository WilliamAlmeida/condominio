<?php

namespace App\Livewire\Forms\Tenant;

use App\Models\Tenant\Imoveis;
use Livewire\Form;
use App\Traits\FormHasGaleria;
use App\Models\Tenant\Moradores;
use Livewire\Attributes\Validate;

class ImovelForm extends Form
{
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

    use FormHasGaleria;

    public function mount(Imoveis|Null $value)
    {
        if($value) {
            $this->fill($value);
        }
    }

    public function searchProprietario(): Moradores|null
    {
        if($this->proprietario_id) {
            return Moradores::withCount('imoveis')->find($this->proprietario_id);
        }

        return null;
    }
}
