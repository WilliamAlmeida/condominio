<div>
    <x-modal.card title="Criação de Morador" blur wire:model.defer="moradorCreateModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-forms.input-foto :form="$form" />

            <x-input label="Nome" wire:model.blur="form.nome" placeholder="William" />
            <x-input label="Sobrenome" wire:model.blur="form.sobrenome" placeholder="Almeida" />

            <x-inputs.maskable label="CPF" wire:model.blur="form.cpf" mask="###.###.###-##" placeholder="000.000.000-00" />
            <x-input label="RG" wire:model.blur="form.rg" placeholder="00.000.000-0" />

            <x-input label="Data de Nascimento" type="date" wire:model.defer="form.nascimento" />

            <x-inputs.phone label="Telefone" wire:model.blur="form.telefone" mask="['(##) ####-####', '(##) #####-####']" placeholder="(00) 0000-0000" />
            <x-inputs.phone label="WhatsApp" wire:model.blur="form.whatsapp" mask="['(##) ####-####', '(##) #####-####']" placeholder="(00) 00000-0000" />

            <x-input label="E-mail" wire:model.blur="form.email" placeholder="exemplo@gmail.com" type="email" class="col-span-2" />
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
