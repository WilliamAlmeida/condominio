<?php

namespace App\Livewire\Forms\Tenant;

use Livewire\Form;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Illuminate\Database\Eloquent\Model;

class EnderecoForm extends Form
{
    #[Validate('required', as: 'estado')]
    public $estado_id;

    #[Validate('required', as: 'cidade')]
    public $cidade_id;

    #[Validate('required|min:0|max:255', as: 'rua')]
    public $rua;

    #[Validate('required|min:0|max:10', as: 'número')]
    public $numero;

    #[Validate('min:0|max:255', as: 'complemento')]
    public $complemento;

    #[Validate('required|min:0|max:255', as: 'bairro')]
    public $bairro;

    #[Validate('required|min:0|max:14', as: 'cep')]
    public $cep;

    public function mount(Model|Null $value)
    {
        if($value) {
            $this->fill($value);
        }
    }

    public function fillCep($values)
    {
        $this->bairro           = Str::title($values->bairro ?: null);
        $this->complemento      = Str::title($values->complemento ?: null);
        $this->rua              = Str::title($values->logradouro ?: null);
        $this->numero           = $values->numero ?: null;
        $this->cidade_id         = $values->cidade_id ?: null;
        $this->estado_id         = $values->estado_id ?: null;
    }
}
