<div>
    <x-modal.card title="Edição do Bloco" blur wire:model.defer="blocoEditModal" max-width="sm">
        <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
            <x-input label="Nome" placeholder="Nome" wire:model="nome" id="edit_nome" />
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
