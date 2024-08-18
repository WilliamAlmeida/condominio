<aside id="default-sidebar" class="fixed sm:relative top-0 left-0 z-40 w-64 md:w-72 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidenav">
    <div class="scrollbar overflow-y-auto py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <ul class="space-y-2">
            <li>
                <x-layouts.sidebar.link :route="route('tenant.dashboard', tenant())" label="Dashboard" :active="request()->routeIs('tenant.dashboard')">
                    <x-slot name="icon">
                        <svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                    </x-slot>
                </x-layouts.sidebar.link>
            </li>
            @can('tenant.users.viewAny')
            <li>
                <x-layouts.sidebar.link :route="route('tenant.usuarios.index', tenant())" label="Usuários" :active="request()->routeIs('tenant.usuarios.index')">
                    <x-slot name="icon">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z" clip-rule="evenodd"/></svg>
                    </x-slot>
                </x-layouts.sidebar.link>
            </li>
            @endcan
            <li>
                <x-layouts.sidebar.dropdown label="Cadastros"
                    :open="request()->routeIs([
                        'tenant.blocos.index', 'tenant.moradores.index', 'tenant.imoveis.index',
                        'tenant.pets.index', 'tenant.veiculos.index', 'tenant.prestadores-servicos.index',
                        'tenant.empresas-servicos.index'
                    ])">
                    <x-slot name="icon">
                        <svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                    </x-slot>

                    <x-layouts.sidebar.sublink :route="route('tenant.blocos.index', tenant())" label="Blocos" :active="request()->routeIs('tenant.blocos.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.moradores.index', tenant())" label="Moradores" :active="request()->routeIs('tenant.moradores.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.imoveis.index', tenant())" label="Imóveis" :active="request()->routeIs('tenant.imoveis.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.pets.index', tenant())" label="Pets" :active="request()->routeIs('tenant.pets.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.veiculos.index', tenant())" label="Veículos" :active="request()->routeIs('tenant.veiculos.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.prestadores-servicos.index', tenant())" label="Prestadores de Serviços" :active="request()->routeIs('tenant.prestadores-servicos.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.empresas-servicos.index', tenant())" label="Empresas de Serviços" :active="request()->routeIs('tenant.empresas-servicos.index')" />

                    {{-- <x-layouts.sidebar.sublink :route="route('tenant.usuarios.index', tenant())" label="Vagas" :active="request()->routeIs('tenant.usuarios.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.usuarios.index', tenant())" label="Visitantes" :active="request()->routeIs('tenant.usuarios.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.usuarios.index', tenant())" label="Salão" :active="request()->routeIs('tenant.usuarios.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.usuarios.index', tenant())" label="Horários (Agenda Festa)" :active="request()->routeIs('tenant.usuarios.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.usuarios.index', tenant())" label="Horários (Agenda Mudança)" :active="request()->routeIs('tenant.usuarios.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.usuarios.index', tenant())" label="Chaves" :active="request()->routeIs('tenant.usuarios.index')" />
                    <x-layouts.sidebar.sublink :route="route('tenant.usuarios.index', tenant())" label="Câmeras IP" :active="request()->routeIs('tenant.usuarios.index')" /> --}}
                </x-layouts.sidebar.dropdown>
            </li>
        </ul>
        <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
            {{-- <li>
                <a href="javascript:void(0)" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path><path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Messages</span>
                    <span class="inline-flex justify-center items-center w-5 h-5 text-xs font-semibold rounded-full text-primary-800 bg-primary-100 dark:bg-primary-200 dark:text-primary-800">
                        6   
                    </span>
                </a>
            </li> --}}
            @can('tenant.tenants.edit')
            <li>
                <x-layouts.sidebar.link :route="route('tenant.condominio.edit', tenant())" label="Configurações" :active="request()->routeIs('tenant.condominio.edit')">
                    <x-slot name="icon"><x-icon name="cog" solid /></x-slot>
                </x-layouts.sidebar.link>
            </li>
            @endcan
            <li>
                <x-layouts.sidebar.link :route="route('admin.dashboard')" label="Painel Principal">
                    <x-slot name="icon"><x-icon name="logout" /></x-slot>
                </x-layouts.sidebar.link>
            </li>
            <li class="border-t border-gray-200 dark:border-gray-700 pt-5">
                <div class="flex gap-x-3 justify-center items-center p-2">
                    <x-icon name="sun" class="w-4 h-4 dark:text-white" />
                    <div x-data="{ checked: localStorage.theme === 'dark' }">
                        <label class="cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" x-on:click="theme = (theme == 'dark' ? 'light' : 'dark')" x-bind:checked="checked">
                            <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <x-icon name="moon" class="w-4 h-4 dark:text-white" />
                </div>
            </li>
        </ul>
    </div>

    @can('super admin')
    <div class="hidden absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-white dark:bg-gray-800 z-20 border-r border-gray-200 dark:border-gray-700">
        {{-- <a href="#" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-600">
            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"></path></svg>
        </a>
        <a href="#" data-tooltip-target="tooltip-settings" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
        </a>
        <div id="tooltip-settings" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip">
            Settings page
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div> --}}

        {{-- <x-layouts.sidebar.dropdown-lang /> --}}
    </div>
    @endcan
</aside>