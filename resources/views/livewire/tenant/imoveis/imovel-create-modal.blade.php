<div>
    <x-modal.card title="Criação de Imóvel" blur wire:model.defer="imovelCreateModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-select label="Tipo do Imóvel" placeholder="Selecione um Tipo" :options="$array_tipo_imovel" option-label="name" option-value="id" wire:model.live="tipo" />
            <x-select label="Bloco" placeholder="Selecione um Bloco" :options="$blocos" option-label="nome" option-value="id" wire:model.defer="bloco_id" />

            @if($tipo)
                @if($tipo == 'casa')
                    <x-input label="Rua" wire:model.defer="rua" />
                @elseif($tipo == 'apartamento')
                    <x-input label="Andar" wire:model.defer="andar" />
                @endif
                <x-input label="Número" wire:model.defer="numero" />
            @endif

            <x-select class="w-full"
            label="Proprietário"
            wire:model.defer="proprietario_id"
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

                @if($proprietario_selecionado->imoveis_count)
                    <span class="text-sm text-indigo-500 col-span-2"><strong>Aviso:</strong> Este proprietário já possui um imóvel cadastrado.</span>
                @endif
            @endif
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
