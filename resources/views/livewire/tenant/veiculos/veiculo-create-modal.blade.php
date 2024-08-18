<div>
    <x-modal.card title="Criação de Veículo" blur wire:model.defer="veiculoCreateModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="col-span-2">
                <x-inputs.maskable label="Placa" placeholder="Ex.: ABC-1D23 ou ABC-1234" wire:model.blur="placa" mask="AAA-#X##" class="text-center text-uppercase" />
            </div>

            <x-input label="Modelo" placeholder="Modelo" wire:model.blur="modelo" />

            <x-input label="Marca" placeholder="Marca" wire:model.blur="marca" />

            <x-inputs.maskable label="Ano" placeholder="Ano" wire:model.blur="ano" mask="####" />

            <x-input label="Cor" placeholder="Cor" wire:model.blur="cor" />
        </div>
     
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancelar" x-on:click="close" />
                    <x-button primary label="Salvar" wire:click="save" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
