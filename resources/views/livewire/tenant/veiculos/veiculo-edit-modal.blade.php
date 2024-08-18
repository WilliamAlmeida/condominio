<div>
    <x-modal.card title="Edição do Veículo" blur wire:model.defer="veiculoEditModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="col-span-2">
                <x-inputs.maskable label="Placa" placeholder="Ex.: ABC-1D23 ou ABC-1234" wire:model.blur="placa" mask="AAA-#X##" class="text-center text-uppercase" id="edit_placa" />
            </div>

            <x-input label="Modelo" placeholder="Modelo" wire:model.blur="modelo" id="edit_modelo" />

            <x-input label="Marca" placeholder="Marca" wire:model.blur="marca" id="edit_marca" />

            <x-inputs.maskable label="Ano" placeholder="Ano" wire:model.blur="ano" mask="####" id="edit_ano" />

            <x-input label="Cor" placeholder="Cor" wire:model.blur="cor" id="edit_cor" />
        </div>
     
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <x-button flat negative label="Deletar" wire:click="delete" />
     
                <div class="flex">
                    <x-button flat label="Cancelar" x-on:click="close" />
                    <x-button primary label="Atualizar" wire:click="save" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
