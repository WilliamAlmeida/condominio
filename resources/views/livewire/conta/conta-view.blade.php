<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Perfíl') }}
        </h2>
    </x-slot>
    
    <div class="pt-6 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col gap-4">
                        <h2 class="font-bold text-lg">Informação do Perfil</h2>

                        <div class="relative overflow-x-auto rounded-t-lg">
                            <table class="table power-grid-table min-w-full dark:bg-slate-800">
                                <tbody>
                                    @if($usuario->foto)
                                    <tr class="border-b border-pg-primary-100 dark:border-pg-primary-600 dark:bg-pg-primary-800">
                                        <th scope="row" colspan="2" class="px-2 py-2 whitespace-nowrap text-left">
                                            <x-avatar size="w-24 h-24" src="{{ asset('storage/'.$usuario->foto->url) }}" :border=null />
                                        </th>
                                    </tr>
                                    @endif
                                    <tr class="border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-700">
                                        <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                                            Nome do Usuário
                                        </th>
                                        <td class="px-2 py-2 text-right">
                                            {{ $usuario->name }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-700">
                                        <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                                            E-mail
                                        </th>
                                        <td class="px-2 py-2 text-right">
                                            {{ Str::lower($usuario->email) }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-700">
                                        <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                                            Tipo de Usuário
                                        </th>
                                        <td class="px-2 py-2 text-right">
                                            {{ $usuario->getTypeUser() }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-700">
                                        <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                                            Funções Atribuidas @if(tenant()) Referente ao Condomínio @endif
                                        </th>
                                        <td class="px-2 py-2 text-right">
                                            @if($usuario->roles->count())
                                                {{ Str::title($usuario->getRoleNames()->implode(', ')) }}
                                            @else
                                                Nenhuma função atribuida.
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-700">
                                        <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                                            Registrado Em
                                        </th>
                                        <td class="px-2 py-2 text-right">
                                            {{ $usuario->created_at->format('d/m/Y H:i:s') }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-700">
                                        <th scope="row" class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white text-left">
                                            Última atualização
                                        </th>
                                        <td class="px-2 py-2 text-right">
                                            {{ $usuario->updated_at->format('d/m/Y H:i:s') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>