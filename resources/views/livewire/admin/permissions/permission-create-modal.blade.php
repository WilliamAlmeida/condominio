<div>
    <x-modal.card title="Criação de Permissões" blur wire:model.defer="permissionCreateModal" max-width="md"
        x-on:open="$dispatch('loadf')">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" x-data="{
            permission: @entangle('name'),
            selecteds: @entangle('selected'),
            toggleSelectAll (action) {
                $el.querySelectorAll('[type=checkbox]').forEach((e) => {
                    if(window.getComputedStyle(e.closest('li')).display !== 'none') {
                        e.checked = action;
                        let index = this.selecteds.indexOf(parseInt(e.name));
                        if(action) { if(index === -1) this.selecteds.push(parseInt(e.name)) }else{ if(index !== -1) this.selecteds.splice(index, 1) }
                    }
                });
            },
            generateCrud () {
                if(!this.permission) return;
                let permissions = [];
				let crud = ['create', 'edit', 'view', 'viewAny', 'delete', 'forceDelete'];
				crud.map((c) => { permissions.push(`${this.permission}.${c}`) });
                this.permission = permissions.join('; ');
            },
            loadData () {
                let values = [...this.selecteds];
                this.toggleSelectAll(0);

                $el.querySelectorAll('[type=checkbox]').forEach((e) => {
                    if(window.getComputedStyle(e.closest('li')).display !== 'none') {
                        if(values.includes(parseInt(e.name))) { e.checked = true; this.toggleSelect(parseInt(e.name)) }
                    }
                });
            }
        }" @loadf.window="loadData">
            <div class="col-span-full">
                <x-textarea label="Permissão" placeholder="Digite o nome da Permissão" wire:model="name" id="permission_create" />
            </div>

            <div class="col-span-full flex gap-x-3" x-show="permission">
                <x-button primary label="Gerar CRUD" x-on:click="generateCrud" class="flex-1" />
                <x-button primary label="Limpar Permissões" x-on:click="permission = ''" class="flex-1" />
            </div>

            @if(!empty($roles))
                <div class="col-span-full">
                    <div class="select-none" x-data="{
                        toggleSelectAll (action) {
                            $el.querySelectorAll('[type=checkbox]').forEach((e) => {
                                if(window.getComputedStyle(e.closest('li')).display !== 'none') {
                                    e.checked = action;
                                    let index = selecteds.indexOf(parseInt(e.name));
                                    if(action) { if(index === -1) selecteds.push(parseInt(e.name)) }else{ if(index !== -1) selecteds.splice(index, 1) }
                                }
                            });
                        },
                        toggleSelect (option) {
                            let index = selecteds.indexOf(option);
                            if(index !== -1) { selecteds.splice(index, 1) }else{ selecteds.push(option) }
                        }
                    }">
                        <div class="flex justify-between">
                            <span class="font-bold text-sm">Funções</span>
                            <div>
                                {{-- <x-button xs primary flat label="Salvar" wire:dirty /> --}}
                                <x-button xs negative flat icon="minus-circle" x-on:click="toggleSelectAll(0)" />
                                <x-button xs positive flat icon="check-circle" x-on:click="toggleSelectAll(1)" />
                            </div>
                        </div>

                        <ul class="[&>*]:border-b [&>*:last-child]:border-b-0">
                            @foreach ($roles as $role)
                                <li>
                                    <x-checkbox id="c{{ $role['id'] }}" label="{{ $role['name'] }}" name="{{ $role['id'] }}" x-on:click="toggleSelect({{ $role['id'] }})" />
                                </li>
                            @endforeach
                        </ul>

                        {{-- <div class="flex justify-end pt-1"><x-button xs primary wire:dirty label="Salvar" /></div> --}}
                    </div>
                </div>
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
