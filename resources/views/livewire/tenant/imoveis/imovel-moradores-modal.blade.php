<div>
    <x-modal.card title="Moradores do Imóvel" blur wire:model.defer="imovelMoradoresModal">
        @if($imovel)
        <div x-data="{ activeTab: 'moradores' }">
            <ul class="flex flex-wrap mb-3 gap-x-2">
                <li role="presentation">
                    <button x-on:click="activeTab = 'moradores'" :class="{ 'border-b-2 text-indigo-500 border-indigo-500': activeTab === 'moradores', 'hover:border-b-2': activeTab !== 'moradores' }">Moradores</button>
                </li>
                <li role="presentation">
                    <button x-on:click="activeTab = 'imovel'" :class="{ 'border-b-2 text-indigo-500 border-indigo-500': activeTab === 'imovel', 'hover:border-b-2': activeTab !== 'imovel' }">Imóvel</button>
                </li>
            </ul>

            <div x-show="activeTab === 'imovel'" x-transition.duration.50ms>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-input label="Tipo do Imóvel" value="{{ $imovel->getTipoImovel()['name'] ?: 'N/A' }}" disabled />
                    <x-input label="Bloco" value="{{ $imovel->blocos->nome ?: 'N/A' }}" disabled />
        
                    @if($imovel->tipo)
                        @if($imovel->tipo == 'casa')
                            <x-input label="Rua" value="{{ $imovel->rua ?: 'N/A' }}" disabled />
                        @elseif($imovel->tipo == 'apartamento')
                            <x-input label="Andar" value="{{ $imovel->andar ?: 'N/A' }}" disabled />
                        @endif
                        <x-input label="Número" value="{{ $imovel->numero ?: 'N/A' }}" disabled />
                    @endif
        
                    <x-input label="Proprietário" value="{{ $proprietario->nome_completo ?? 'N/A' }}" disabled />
        
                    @if($proprietario)
                        <x-input label="CPF" value="{{ $proprietario->cpf_format ?? 'N/A' }}" disabled />
                    @endif
                </div>
            </div>

            <div x-show="activeTab === 'moradores'" x-transition.duration.50ms>
                <div class="grid grid-cols-1 sm:grid-cols-1" x-data="{
                    moradores: @entangle('moradores'),
                    morador_selected: @entangle('morador_id'),
                }">
                    <div class="flex gap-x-4">
                        <x-select
                        label="Morador"
                        wire:model.defer="morador_id"
                        placeholder="Pesquise pelo nome"
                        :async-data="route('api.moradores', ['empresa' => tenant() ?? null, 'ignore' => array_merge($moradores->pluck('id')->toArray(), [$proprietario?->id])])"
                        option-label="nome_completo"
                        option-value="id"
                        x-on:selected="morador_selected = true"
                        x-on:clear="morador_selected = false"
                        id="edit_morador_id">
                        </x-select>
    
                        <div x-show="morador_selected !== null" class="flex items-end">
                            <x-button icon="plus" label="Adicionar" primary wire:loading.attr="disabled" wire:click="adicionar_morador" />
                        </div>
                    </div>
    
                    <div class="mt-4 mb-2">Lista de Moradores</div>

                    <div class="relative overflow-x-auto rounded-t-lg">
                        <table class="table power-grid-table min-w-full dark:bg-slate-800">
                            <thead class="shadow-sm bg-pg-primary-200 dark:bg-gray-900">
                                <tr>
                                    <th scope="col" class="font-semibold px-2 pr-4 py-3 text-left text-xs text-pg-primary-700 tracking-wider whitespace-nowrap dark:text-pg-primary-300">
                                        Nome
                                    </th>
                                    <th scope="col" class="font-semibold px-2 pr-4 py-3 text-right text-xs text-pg-primary-700 tracking-wider whitespace-nowrap dark:text-pg-primary-300">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($moradores as $morador)
                                <tr class="border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-700">
                                    <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                                        {{ $morador->nome_completo }}
                                    </th>
                                    <td class="px-2 py-2 text-right">
                                        <x-button icon="trash" label="Remover" negative xs wire:click="remover_morador({{ $morador->id }})" />
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-2 py-2 text-gray-500 dark:text-gray-400" colspan="2">Nenhum morador adicionado.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </x-modal.card>
</div>
