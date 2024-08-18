<?php

namespace App\Livewire\Tenant\PrestadoresServicos;

use App\Models\Tenant\PrestadoresServicos;
use App\Traits\HelperPowerGrid;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class PrestadorServicoTable extends PowerGridComponent
{
    // use WithExport;
    use HelperPowerGrid;

    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return PrestadoresServicos::query()
        ->with('foto:id,url')
        ->select('*')->selectRaw('CONCAT(nome, " ", sobrenome) as nome_completo');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('foto', fn($row) => $this->fieldImage($row, url: $row->foto ? asset('storage/'.$row->foto->url) : null))
            ->add('categoria')
            ->add('nome')
            ->add('sobrenome')
            ->add('nome_completo')
            ->add('rg', fn($row) => $row->rg ?: 'N/A')
            ->add('cpf', fn($row) => $row->cpf_format ?: 'N/A')
            ->add('created_at_formatted', fn($row) => Carbon::parse($row->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Foto', 'foto'),

            Column::make('Tipo', 'tipo')->searchable()->hidden(),

            Column::make('Categoria', 'categoria')
                ->sortable(),

            Column::make('Nome', 'nome')->searchable()->hidden(),
            Column::make('Sobrenome', 'sobrenome')->searchable()->hidden(),

            Column::make('Nome Completo', 'nome_completo')
                ->sortable(),

            Column::make('Cpf', 'cpf')
                ->searchable(),

            Column::make('Rg', 'rg')
                ->searchable(),

            Column::make('Registrado em', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Ações')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('nome')->operators(['contains']),
            Filter::inputText('sobrenome')->operators(['contains']),
            Filter::inputText('cpf')->operators(['contains']),
            Filter::inputText('rg')->operators(['contains']),
        ];
    }

    public function actions(PrestadoresServicos $row): array
    {
        return [
            Button::add('edit')
                ->slot('Editar')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
