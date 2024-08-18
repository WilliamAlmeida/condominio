<?php

namespace App\Livewire\Forms\Tenant;

use App\Models\Tenant\EmpresasServicos;
use Livewire\Form;
use Livewire\Attributes\Validate;

class EmpresaServicoForm extends Form
{
    #[Validate('required|min:2')]
    public $categoria;

    #[Validate('required|min:14')]
    public $cnpj;

    #[Validate('required|min:3')]
    public $razao_social;

    #[Validate('required|min:3')]
    public $nome_fantasia;

    #[Validate('nullable|min:3')]
    public $inscricao_estadual;

    #[Validate('nullable|min:3')]
    public $inscricao_municipal;

    #[Validate('required|min:10')]
    public $telefone_1;

    #[Validate('nullable|min:10')]
    public $telefone_2;

    #[Validate('nullable|min:10')]
    public $whatsapp;

    #[Validate('nullable|email')]
    public $email;

    #[Validate('nullable|url')]
    public $site;

    #[Validate('nullable')]
    public $descricao;

    public function mount(EmpresasServicos|Null $value)
    {
        if($value) {
            $this->fill($value);
        }
    }

    public function fillCnpj($values)
    {
        $this->nome_fantasia = $values->nome_fantasia;
        $this->razao_social = $values->razao_social;
    }
}
