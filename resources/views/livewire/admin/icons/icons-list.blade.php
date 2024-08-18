<div>
    <div x-data="{ searchText: '' }" class="text-gray-900 dark:text-gray-100">
        <input type="text" x-model.debounce.500ms="searchText" placeholder="Pesquisar ícone..." class="w-full px-2 py-1 mb-4 border rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:focus:ring-gray-500 dark:focus:border-gray-500">
    
        @foreach($icons as $type => $list)
            <h2 class="font-bold text-base">{{ $type }}</h2>
    
            <div class="grid grid-cols-3 gap-1">
                @foreach($list as $icon)
                    @if($limit && $loop->index == $limit) @break @endif
                    <template x-if="searchText === '' || '{{ $icon }}'.toLowerCase().includes(searchText.toLowerCase())">
                        <div class="flex flex-col justify-center items-center border rounded-md px-1 pb-1 pt-2 hover:border-indigo-400 cursor-pointer group" x-data="{
                            icon: '{{ $icon }}',
                            type: '{{ $type == 'solid' ? 'solid' : null }}',
                            copy() {
                                let html = `<x-icon name='${this.icon}' ${this.type} />`;
                                if(window.copyToClipboard(html)) window.$wireui.notify({icon: 'success', progressbar: true, timeout: 1000, title: 'Ícone Copiado!', description: `${this.icon}`});
                            }}" x-on:click="copy()">
                            <span>
                                @if($type == 'outline')
                                    <x-icon :name="$icon" class="w-5 h-5 group-hover:-translate-y-1 transition-transform" />
                                @else
                                    <x-icon :name="$icon" class="w-5 h-5 group-hover:-translate-y-1 transition-transform" solid />
                                @endif
                            </span>
                            <span class="text-xs group-hover:text-indigo-400">{{ $icon }}</span>
                        </div>
                    </template>
                @endforeach
            </div>
        @endforeach
    </div>
</div>