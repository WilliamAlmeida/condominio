<?php

namespace App\Livewire\Forms\Tenant;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\Tenant\PrestadoresServicos;
use App\Traits\FormHasAvatar;

class PrestadorServicoForm extends Form
{
    #[Validate('required')]
    #[Validate('in:pessoa_fisica,pessoa_juridica', message: 'Selecione uma opção válida')]
    public $tipo;

    #[Validate('required|min:2')]
    public $categoria;

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

    #[Validate('nullable')]
    public $descricao;

    use FormHasAvatar;

    public function mount(PrestadoresServicos|Null $value)
    {
        if($value) {
            $this->fill($value);
        }
    }
}
