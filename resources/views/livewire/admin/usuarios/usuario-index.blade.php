<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="flex justify-between items-center px-2 sm:px-0">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Usuários
                </h2>
            </div>

            <div class="flex justify-end">
                <x-button white class="rounded-lg" label="Novo Usuário" wire:click="$dispatch('create')" />
            </div>

            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 md:p-2 text-gray-900 dark:text-gray-100">
                    <livewire:admin.usuarios.usuario-table />
                </div>
            </div>
        </div>
    </div>

    <livewire:admin.usuarios.usuario-create-modal />
    <livewire:admin.usuarios.usuario-edit-modal />
    <livewire:admin.usuarios.usuario-permissions-modal />
</div>