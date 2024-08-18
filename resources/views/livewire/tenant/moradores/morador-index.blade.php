<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="flex justify-between items-center px-2 sm:px-0">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Moradores
                </h2>
            </div>

            <div class="flex justify-end">
                <x-button white class="rounded-lg" label="Novo Morador" wire:click="$dispatch('create')" />
            </div>

            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 md:p-2 text-gray-900 dark:text-gray-100">
                    <livewire:tenant.moradores.morador-table />
                </div>
            </div>
        </div>
    </div>

    <livewire:tenant.moradores.morador-create-modal />
    <livewire:tenant.moradores.morador-edit-modal />
    <livewire:tenant.moradores.morador-imoveis-modal />
</div>