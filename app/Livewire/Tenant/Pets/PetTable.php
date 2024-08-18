<?php

namespace App\Livewire\Tenant\Pets;

use App\Models\Tenant\Pets;
use Illuminate\Support\Carbon;
use App\Models\Tenant\Moradores;
use App\Traits\HelperPowerGrid;
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

final class PetTable extends PowerGridComponent
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
        return Pets::query()->with('proprietario', 'foto:id,url')
        ->leftJoin('moradores', 'pets.proprietario_id', '=', 'moradores.id')
        ->select('pets.*')->selectRaw("CONCAT(moradores.nome, ' ', moradores.sobrenome) as proprietario_nome");
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
            ->add('proprietario_id')
            ->add('proprietario_nome', fn($row) => $row->proprietario_nome ?: 'N/A')
            ->add('nome')
            ->add('raca', fn($row) => $row->raca ?: 'N/A')
            ->add('cor', fn($row) => $row->cor ?: 'N/A')
            ->add('porte', fn($row) => $row->porte ?: 'N/A')
            ->add('created_at_formatted', fn($row) => Carbon::parse($row->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Foto', 'foto'),

            Column::make('Proprietário', 'proprietario_id')->hidden(),
            Column::make('Proprietário', 'proprietario_nome')->sortable(),

            Column::make('Nome', 'nome')
                ->sortable()
                ->searchable(),

            Column::make('Raca', 'raca'),
            Column::make('Cor', 'cor'),
            Column::make('Porte', 'porte'),

            Column::make('Registrado em', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Ações')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('nome')->operators(['contains']),
            Filter::select('proprietario_id')->dataSource(Moradores::select('id', 'nome', 'sobrenome')->selectRaw("CONCAT(nome, ' ', sobrenome) as nome_completo")->get())->optionValue('id')->optionLabel('nome_completo')
        ];
    }

    public function actions(Pets $row): array
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
