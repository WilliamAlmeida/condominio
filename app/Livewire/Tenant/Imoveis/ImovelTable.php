<?php

namespace App\Livewire\Tenant\Imoveis;

use App\Models\Tenant\Blocos;
use App\Models\Tenant\Imoveis;
use Illuminate\Support\Carbon;
use App\Models\Tenant\Moradores;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class ImovelTable extends PowerGridComponent
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
        return Imoveis::query()
        ->leftJoin('blocos', 'imoveis.bloco_id', '=', 'blocos.id')
        ->leftJoin('moradores as proprietario', 'imoveis.proprietario_id', '=', 'proprietario.id')
        ->select('imoveis.*', 'blocos.nome as bloco_nome')->selectRaw("CONCAT(proprietario.nome, ' ', proprietario.sobrenome) as proprietario_nome");
    }

    public function relationSearch(): array
    {
        return [
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('bloco_id')
            ->add('bloco_nome', fn ($row) => $row->bloco_nome ?: 'N/A')
            ->add('tipo', fn ($row) => $row->tipo === 'casa' ? 'Casa' : 'Apartamento')
            ->add('localizacao', function($row) {
                if($row->tipo === 'casa') {
                    return $row->rua . ', nº ' . $row->numero;
                }else {
                    return 'Andar ' . $row->andar . ', Ap. ' . $row->numero;
                }
            })
            ->add('proprietario_id')
            ->add('proprietario_nome', fn ($row) => $row->proprietario_nome ?: 'N/A')
            ->add('created_at_formatted', fn ($row) => Carbon::parse($row->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Bloco', 'bloco_id')->hidden(),

            Column::make('Bloco', 'bloco_nome')
                ->sortable()
                ->searchable(),

            Column::make('Tipo', 'tipo')
                ->sortable()
                ->searchable(),

            Column::make('Localização', 'localizacao'),

            Column::make('Proprietário', 'proprietario_id')->searchable()->hidden(),
            Column::make('Proprietário', 'proprietario_nome')->sortable(),

            Column::make('Registrado em', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('bloco_id', 'bloco_id')->dataSource(Blocos::select('id', 'nome')->get())->optionValue('id')->optionLabel('nome'),
            Filter::select('tipo', 'Tipo')->dataSource(Imoveis::$tipos_imoveis)->optionValue('id')->optionLabel('name'),
            Filter::select('proprietario_id')->dataSource(Moradores::select('id', 'nome', 'sobrenome')->selectRaw("CONCAT(nome, ' ', sobrenome) as nome_completo")->get())->optionValue('id')->optionLabel('nome_completo')
            ,
        ];
    }

    public function actions(Imoveis $row): array
    {
        return [
            Button::add('edit')
                ->slot('Editar')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id]),
            Button::add('edit-moradores')
                ->slot('Moradores')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit-moradores', ['rowId' => $row->id])
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
