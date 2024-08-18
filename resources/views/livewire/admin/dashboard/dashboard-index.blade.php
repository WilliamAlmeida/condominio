<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="flex justify-between items-center px-2 sm:px-0">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Condomínios
                </h2>
            </div>

            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-1 sm:grid-cols-3 gap-3">

                    @if(count(auth()->user()->condominio))
                        @foreach(auth()->user()->condominio as $condominio)
                            <x-card class="rounded-t-md rounded-b-md border-2 border-indigo-500 hover:bg-gray-400/10 dark:bg-none hover:dark:bg-white/5 transition-all" shadow="none">
                                <span class="text-sm font-bold block">Condomínio</span>
                                <span class="text-lg uppercase text-indigo-500">{{ $condominio->nome_fantasia }}</span>
                                <div class="flex justify-end items-center">
                                    <x-button primary href="{{ route('tenant.dashboard', $condominio) }}" wire:navigate>Acessar Painel</x-button>
                                </div>
                            </x-card>
                        @endforeach
                    @else
                        @if(auth()->user()->isAdmin() || auth()->user()->isCondominio())
                            <div class="col-span-full">
                                <div class="flex flex-row justify-center items-center max-w-lg mx-auto gap-x-8">
                                    <x-icon name="building" class="w-24 h-24 text-indigo-200" />

                                    <div class="flex flex-col justify-around items-center gap-y-4">
                                        <span class="select-none">Cadastre seu Condomínio e<br/>desfrute desse incrivel Sistema!</span>
                                        <x-button label="Registrar Condomínio" primary href="{{ route('admin.condominio.create') }}" wire:navigate class="hover:-translate-y-2 transition-transform" />
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>