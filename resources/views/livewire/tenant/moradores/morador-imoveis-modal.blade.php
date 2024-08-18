<div>
    <x-modal.card title="Imóveis do Morador" blur wire:model.defer="moradorImoveisModal">
        @if($morador)
        <div x-data="{ activeTab: 'imoveis' }">
            <ul class="flex flex-wrap mb-3 gap-x-2">
                <li role="presentation">
                    <button x-on:click="activeTab = 'imoveis'" :class="{ 'border-b-2 text-indigo-500 border-indigo-500': activeTab === 'imoveis', 'hover:border-b-2': activeTab !== 'imoveis' }">Imóveis</button>
                </li>
                <li role="presentation">
                    <button x-on:click="activeTab = 'morador'" :class="{ 'border-b-2 text-indigo-500 border-indigo-500': activeTab === 'morador', 'hover:border-b-2': activeTab !== 'morador' }">Morador</button>
                </li>
            </ul>

            <div x-show="activeTab === 'morador'" x-transition.duration.50ms>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-input label="Nome Completo" value="{{ $morador->nome_completo ?: 'N/A' }}" disabled />
                    <x-input label="CPF" value="{{ $morador->cpf_format ?: 'N/A' }}" disabled />
                    <x-input label="RG" value="{{ $morador->rg_format ?: 'N/A' }}" disabled />
                    
                    <x-input label="Telefone" value="{{ $morador->telefone_format ?: 'N/A' }}" disabled />
                    <x-input label="WhatsApp" value="{{ $morador->whatsapp_format ?: 'N/A' }}" disabled />
                    <x-input label="E-mail" value="{{ $morador->email ?: 'N/A' }}" disabled class="col-span-2" />
                </div>
            </div>

            <div x-show="activeTab === 'imoveis'" x-transition.duration.50ms>
                <div class="grid grid-cols-1 sm:grid-cols-1">
                    <div class="mt-4 mb-2">Lista de Imóveis</div>

                    <div class="relative overflow-x-auto rounded-t-lg">
                        <table class="table power-grid-table min-w-full dark:bg-slate-800">
                            <thead class="shadow-sm bg-pg-primary-200 dark:bg-gray-900">
                                <tr>
                                    <th scope="col" class="font-semibold px-2 pr-4 py-3 text-left text-xs text-pg-primary-700 tracking-wider whitespace-nowrap dark:text-pg-primary-300">
                                        Imóvel
                                    </th>
                                    <th scope="col" class="font-semibold px-2 pr-4 py-3 text-right text-xs text-pg-primary-700 tracking-wider whitespace-nowrap dark:text-pg-primary-300">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($imoveis as $imovel)
                                <tr class="border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-700">
                                    <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                                        {{ $imovel->getTipoImovel()['name'] }} - {{ $imovel->blocos->nome }} - Nº {{ $imovel->numero }}
                                        @if($imovel->tipo == 'casa')
                                            - {{ $imovel->rua }}
                                        @elseif($imovel->tipo == 'apartamento')
                                            - {{ $imovel->andar }}º Andar
                                        @endif
                                    </th>
                                    <td class="px-2 py-2 text-right">
                                        <x-button icon="trash" label="Remover" negative xs wire:click="remover_imovel({{ $imovel->id }})" />
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-2 py-2 text-gray-500 dark:text-gray-400" colspan="2">Nenhum imóvel adicionado.</td>
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
