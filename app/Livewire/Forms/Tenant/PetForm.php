<?php

namespace App\Livewire\Forms\Tenant;

use Livewire\Form;
use App\Models\Tenant\Moradores;
use App\Traits\FormHasAvatar;
use Livewire\Attributes\Validate;

class PetForm extends Form
{
    #[Validate('required|min:3')]
    public $nome;

    #[Validate('nullable|min:3')]
    public $raca;

    #[Validate('nullable|min:3')]
    public $cor;

    #[Validate('required|min:1')]
    public $porte;

    #[Validate(
        'nullable|before_or_equal:today|after:1900-01-01',
        message: [
            'date_format' => 'O nascimento deve ser no formato Y-m-d',
            'before_or_equal' => 'O nascimento deve ser menor ou igual a data atual',
            'after' => 'Data de nascimento invalida'
        ]
    )]
    public $nascimento;

    #[Validate('nullable|min:1')]
    public $proprietario_id = null;

    use FormHasAvatar;

    public function searchProprietario(): Moradores|null
    {
        if($this->proprietario_id) {
            return Moradores::withCount('pets')->find($this->proprietario_id);
        }

        return null;
    }
}
