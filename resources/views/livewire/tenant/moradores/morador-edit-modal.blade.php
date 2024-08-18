<div>
    <x-modal.card title="Edição de Morador" blur wire:model.defer="moradorEditModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-forms.input-foto :form="$form" />

            <x-input label="Nome" wire:model.blur="form.nome" placeholder="William" id="edit_nome" />
            <x-input label="Sobrenome" wire:model.blur="form.sobrenome" placeholder="Almeida" id="edit_sobrenome" />

            <x-inputs.maskable label="CPF" wire:model.blur="form.cpf" mask="###.###.###-##" placeholder="000.000.000-00" id="edit_cpf" />
            <x-input label="RG" wire:model.blur="form.rg" placeholder="00.000.000-0" id="edit_rg" />

            <x-input label="Data de Nascimento" type="date" wire:model.defer="form.nascimento" id="edit_nascimento" />

            <x-inputs.phone label="Telefone" wire:model.blur="form.telefone" mask="['(##) ####-####', '(##) #####-####']" placeholder="(00) 0000-0000" id="edit_telefone" />
            <x-inputs.phone label="WhatsApp" wire:model.blur="form.whatsapp" mask="['(##) ####-####', '(##) #####-####']" placeholder="(00) 00000-0000" id="edit_whatsapp" />

            <x-input label="E-mail" wire:model.blur="form.email" placeholder="exemplo@gmail.com" type="email" class="col-span-2" id="edit_email" />
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
