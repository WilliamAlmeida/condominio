<div>
    <x-modal.card title="Criação de Prestador de Serviço" blur wire:model.defer="prestadorservicoCreateModal">
        <div x-data="{ activeTab: 'prestador-servico' }">
            <ul class="flex flex-wrap mb-3 gap-x-2">
                <li role="presentation">
                    <button x-on:click="activeTab = 'prestador-servico'" :class="{ 'border-b-2 text-indigo-500 border-indigo-500': activeTab === 'prestador-servico', 'hover:border-b-2': activeTab !== 'prestador-servico' }">Prestador de Serviço</button>
                </li>
                <li role="presentation">
                    <button x-on:click="activeTab = 'endereco'" :class="{ 'border-b-2 text-indigo-500 border-indigo-500': activeTab === 'endereco', 'hover:border-b-2': activeTab !== 'endereco' }">Endereço</button>
                </li>
            </ul>

            <div x-show="activeTab === 'prestador-servico'" x-transition.duration.50ms>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-forms.input-foto :form="$form" />

                    <x-select label="Tipo" placeholder="Selecione um Tipo" :options="$array_tipos_prestadores" option-label="name" option-value="id" wire:model.live="form.tipo" />

                    <x-input label="Categoria" wire:model.blur="form.categoria" placeholder="Ex.: TI" />

                    <x-input label="Nome" wire:model.blur="form.nome" placeholder="William" />
                    <x-input label="Sobrenome" wire:model.blur="form.sobrenome" placeholder="Almeida" />

                    <x-inputs.maskable label="CPF" wire:model.blur="form.cpf" mask="###.###.###-##" placeholder="000.000.000-00" />
                    <x-input label="RG" wire:model.blur="form.rg" placeholder="00.000.000-0" />

                    <x-input label="Data de Nascimento" type="date" wire:model.defer="form.nascimento" />

                    <x-inputs.phone label="Telefone" wire:model.live="form.telefone" mask="['(##) ####-####', '(##) #####-####']" placeholder="(00) 0000-0000" />
                    <x-inputs.phone label="WhatsApp" wire:model.live="form.whatsapp" mask="['(##) ####-####', '(##) #####-####']" placeholder="(00) 00000-0000" />

                    <x-input label="E-mail" wire:model.live="form.email" placeholder="exemplo@gmail.com" type="email" class="col-span-2" />
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
