<div>
    <x-modal.card title="Criação de Bloco" blur wire:model.defer="blocoCreateModal" max-width="sm">
        <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
            <x-input label="Nome" placeholder="Nome" wire:model.live="nome" />
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
