<?php

namespace App\Livewire\Forms\Tenant;

use App\Models\Tenant\Moradores;
use App\Traits\FormHasAvatar;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MoradorForm extends Form
{
    #[Validate('required|min:3')]
    public $nome;

    #[Validate('required|min:3')]
    public $sobrenome;

    #[Validate('nullable|min:3')]
    public $rg;

    #[Validate('nullable|min:11')]
    public $cpf;

    #[Validate(
        'nullable|before_or_equal:today|after:1900-01-01',
        message: [
            'date_format' => 'O nascimento deve ser no formato Y-m-d',
            'before_or_equal' => 'O nascimento deve ser menor ou igual a data atual',
            'after' => 'Data de nascimento invalida'
        ]
    )]
    public $nascimento;

    #[Validate('nullable|min:10')]
    public $telefone;

    #[Validate('nullable|min:10')]
    public $whatsapp;

    #[Validate('nullable|email')]
    public $email;

    use FormHasAvatar;

    public function mount(Moradores|Null $value)
    {
        if($value) {
            $this->fill($value);
        }
    }
}
