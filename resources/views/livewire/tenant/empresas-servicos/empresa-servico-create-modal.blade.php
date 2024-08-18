<div>
    <x-modal.card title="Criação de Empresa de Serviço" blur wire:model.defer="empresaservicoCreateModal">
        <div x-data="{ activeTab: 'empresa-servico' }">
            <ul class="flex flex-wrap mb-3 gap-x-2">
                <li role="presentation">
                    <button x-on:click="activeTab = 'empresa-servico'" :class="{ 'border-b-2 text-indigo-500 border-indigo-500': activeTab === 'empresa-servico', 'hover:border-b-2': activeTab !== 'empresa-servico' }">Empresa de Serviço</button>
                </li>
                <li role="presentation">
                    <button x-on:click="activeTab = 'endereco'" :class="{ 'border-b-2 text-indigo-500 border-indigo-500': activeTab === 'endereco', 'hover:border-b-2': activeTab !== 'imovel' }">Endereço</button>
                </li>
            </ul>

            <div x-show="activeTab === 'empresa-servico'" x-transition.duration.50ms>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-input label="Categoria" wire:model.blur="form.categoria" placeholder="Ex.: TI" />

                    <x-inputs.maskable label="CNPJ" mask="##.###.###/####-##" placeholder="Informe o CNPJ" wire:model.blur="form.cnpj"
                        wire:keydown.enter="pesquisar_cnpj" wire:loading.attr="disabled">
                        <x-slot name="append">
                            <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                                <x-button class="h-full rounded-r-md" icon="search" primary flat squared wire:loading.attr="disabled" wire:click="pesquisar_cnpj" />
                            </div>
                        </x-slot>
                    </x-inputs.maskable>

                    <x-input label="Nome Fantâsia" wire:model.blur="form.nome_fantasia" placeholder="" />
                    <x-input label="Razão Social" wire:model.blur="form.razao_social" placeholder="" />

                    <x-inputs.maskable label="Inscrição Estadual" wire:model.blur="form.inscricao_estadual" mask="###.###.###.###" placeholder="" />
                    <x-inputs.maskable label="Inscrição Municipal" wire:model.blur="form.inscricao_municipal" mask="###.###.###.###" placeholder="" />

                    <x-inputs.phone label="Telefone (1)" wire:model.blur="form.telefone_1" mask="['(##) ####-####', '(##) #####-####']" placeholder="(00) 0000-0000" />
                    <x-inputs.phone label="Telefone (2)" wire:model.blur="form.telefone_2" mask="['(##) ####-####', '(##) #####-####']" placeholder="(00) 0000-0000" />

                    <x-inputs.phone label="WhatsApp" wire:model.blur="form.whatsapp" mask="['(##) ####-####', '(##) #####-####']" placeholder="(00) 00000-0000" />

                    <x-input label="E-mail" wire:model.blur="form.email" placeholder="exemplo@gmail.com" type="email" class="col-span-2" />

                    <x-input label="Site" wire:model.blur="form.site" placeholder="www.exemplo.com" type="url" class="col-span-2" />
                </div>
            </div>

            <div x-show="activeTab === 'endereco'" x-transition.duration.50ms>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="col-span-1 sm:col-span-2">
                        <div class="grid grid-cols-3 sm:grid-cols-3 gap-4">
                            <x-input label="CEP" placeholder="00.000-000" wire:model="endereco.cep" emitFormatted="true">
                                <x-slot name="append">
                                    <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                                        <x-button class="h-full rounded-r-md" icon="search" primary flat squared wire:click="pesquisar_cep" />
                                    </div>
                                </x-slot>
                            </x-input>

                            <x-select label="Estado" placeholder="Selecione um Estado" :options="$array_estados" option-label="uf" option-value="id" wire:model.blur="endereco.estado_id" />
                            <x-select
                                label="Município"
                                wire:model.defer="endereco.cidade_id"
                                placeholder="Selecione um Município"
                                :async-data="route('api.cidades', ['estado' => $endereco->estado_id])"
                                option-label="nome"
                                option-value="id"
                                :disabled="!$endereco->estado_id">
                            </x-select>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <x-input label="Bairro" placeholder="Informe o Bairro" wire:model="endereco.bairro" />
                    </div>

                    <div class="col-span-2">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <x-input label="Logradouro" placeholder="Informe o Logradouro" wire:model="endereco.rua" />
                            </div>
                            <x-input label="Número" placeholder="Informe o Número" wire:model="endereco.numero" />
                        </div>
                    </div>

                    <div class="col-span-2">
                        <x-input label="Complemento" placeholder="Informe um Complemento" wire:model="endereco.complemento" />
                    </div>
                </div>
            </div>
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
