<div>
    <x-modal.card title="Edição do Pet" blur wire:model.defer="petEditModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="col-span-2 flex flex-col gap-3">
                @if(!$form->foto_tmp && !$form->foto)
                    <x-input label="Foto" type="file" wire:model.defer="form.foto_tmp" accept="image/*" class="py-0 text-sm" />
                @endif

                <div wire:loading wire:target="form.foto_tmp">Uploading...</div>

                @if($form->foto_tmp || $form->foto)
                    <x-label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Foto</x-label>
                    <div class="flex items-center gap-x-3">
                        <img src="{{ $form->foto_tmp?->temporaryUrl() ?? asset('storage/' . $form->foto->url) }}" class="w-32 h-32 object-cover rounded-md border" alt="Foto do Pet">
                        @if($form->foto)
                            <x-button icon="trash" negative label="Remover" wire:click="deleteFoto" />
                        @elseif($form->foto_tmp)
                            <x-button icon="trash" flat negative label="Cancelar" wire:click="cancelFotoTemp" />
                        @endif
                    </div>
                @endif
            </div>

            <x-input label="Nome" wire:model.defer="form.nome" />
            <x-select label="Porte" placeholder="Selecione um Porte" :options="$array_porte_pet" option-label="name" option-value="id" wire:model.live="form.porte" />
            <x-input label="Raça" wire:model.defer="form.raca" />
            <x-input label="Cor" wire:model.defer="form.cor" />
            <x-input label="Data de Nascimento" type="date" wire:model.defer="form.nascimento" />

            <x-select class="w-full"
            label="Proprietário"
            wire:model.defer="form.proprietario_id"
            placeholder="Pesquise pelo nome"
            :async-data="route('api.moradores', ['empresa' => tenant() ?? null])"
            option-label="nome_completo"
            option-value="id"
            x-on:selected="$wire.pesquisar_proprietario()"
            x-on:clear="$wire.pesquisar_proprietario()"
            id="proprietario_id"
            />

            @if($proprietario_selecionado)
                <x-input label="CPF" value="{{ $proprietario_selecionado->cpf_format ?: 'N/A' }}" disabled />

                @if($proprietario_selecionado->pets_count)
                    <span class="text-sm text-indigo-500 col-span-2"><strong>Aviso:</strong> Este proprietário já possui um pet cadastrado.</span>
                @endif
            @endif
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
