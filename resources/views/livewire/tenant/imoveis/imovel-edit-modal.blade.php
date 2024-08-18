<div>
    <x-modal.card title="Edição do Imóvel" blur wire:model.defer="imovelEditModal">
        <div x-data="{ activeTab: 'imovel' }">
            <ul class="flex flex-wrap mb-3 gap-x-2">
                <li role="presentation">
                    <button x-on:click="activeTab = 'imovel'" :class="{ 'border-b-2 text-indigo-500 border-indigo-500': activeTab === 'imovel', 'hover:border-b-2': activeTab !== 'imovel' }">Imóvel</button>
                </li>
                <li role="presentation">
                    <button x-on:click="activeTab = 'fotos'" :class="{ 'border-b-2 text-indigo-500 border-indigo-500': activeTab === 'fotos', 'hover:border-b-2': activeTab !== 'fotos' }">Fotos</button>
                </li>
            </ul>

            <div x-show="activeTab === 'imovel'" x-transition.duration.50ms>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-select label="Tipo do Imóvel" placeholder="Selecione um Tipo" :options="$array_tipo_imovel" option-label="name" option-value="id" wire:model.live="form.tipo" id="edit_tipo" />
                    <x-select label="Bloco" placeholder="Selecione um Bloco" :options="$blocos" option-label="nome" option-value="id" wire:model.defer="form.bloco_id" id="edit_bloco" />
        
                    @if($form->tipo)
                        @if($form->tipo == 'casa')
                            <x-input label="Rua" wire:model.defer="form.rua" id="edit_rua" />
                        @elseif($form->tipo == 'apartamento')
                            <x-input label="Andar" wire:model.defer="form.andar" id="edit_andar" />
                        @endif
                        <x-input label="Número" wire:model.defer="form.numero" id="edit_numero" />
                    @endif
        
                    <x-select class="w-full"
                    label="Proprietário"
                    wire:model.defer="form.proprietario_id"
                    placeholder="Pesquise pelo nome"
                    :async-data="route('api.moradores', ['empresa' => tenant() ?? null])"
                    option-label="nome_completo"
                    option-value="id"
                    x-on:selected="$wire.pesquisar_proprietario()"
                    x-on:clear="$wire.pesquisar_proprietario()"
                    id="edit_proprietario_id"
                    />
        
                    @if($proprietario_selecionado)
                        <x-input label="CPF" value="{{ $proprietario_selecionado->cpf_format ?: 'N/A' }}" disabled />
        
                        @if($proprietario_selecionado->imoveis_count)
                            <span class="text-sm text-indigo-500 col-span-2"><strong>Aviso:</strong> Este proprietário já possui um imóvel cadastrado.</span>
                        @endif
                    @endif
                </div>
            </div>

            <div x-show="activeTab === 'fotos'" x-transition.duration.50ms>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-forms.input-fotos :form="$form" />
                </div>
            </div>
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
