<?php

namespace App\Livewire\Tenant\EmpresasServicos;

use App\Models\Tenant\EmpresasServicos;
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

final class EmpresaServicoTable extends PowerGridComponent
{
    // use WithExport;

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
        return EmpresasServicos::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('categoria')
            ->add('cnpj', fn ($row) => $row->cnpj_format)
            ->add('nome_fantasia')
            ->add('telefone', fn ($row) => $row->telefone_1_format . ($row->telefone_2 ? ' / ' . $row->telefone_2_format : '') )
            ->add('whatsapp')
            ->add('created_at_formatted', fn($row) => Carbon::parse($row->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Categoria', 'categoria')
                ->sortable(),

            Column::make('Cnpj', 'cnpj')
                ->sortable()
                ->searchable(),

            Column::make('Nome fantasia', 'nome_fantasia')
                ->sortable()
                ->searchable(),

            Column::make('Telefone', 'telefone'),

            Column::make('Registrado em', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Ações')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('cnpj')->operators(['contains']),
            Filter::inputText('nome_fantasia')->operators(['contains']),
        ];
    }

    public function actions(EmpresasServicos $row): array
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
