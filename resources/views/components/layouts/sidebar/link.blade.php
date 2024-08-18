@props([
    'route',
    'label',
    'active' => false,
    'icon' => false,
    'iconPosition' => 'left',
])

<a href="{{ $route }}" wire:navigate class="flex items-center p-2 text-base font-normal rounded-lg group {{ $active ?
'text-indigo-500 dark:text-indigo-500 hover:bg-indigo-100 dark:hover:bg-gray-700' :
'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700'
}}">
    @if($icon && $iconPosition === 'left')
        <i class="w-6 h-6 transition duration-75 {{ $active ?
        'text-indigo-500 dark:text-indigo-500 group-hover:text-indigo-500 dark:group-hover:text-white' :
        'text-gray-500 dark:text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white'
        }}">
            {!! $icon !!}
        </i>
    @endif

    <span class="mx-3">{{ $label }}</span>

    @if($icon && $iconPosition === 'right')
        <i class="w-6 h-6 transition duration-75 {{ $active ?
        'text-indigo-500 dark:text-indigo-500 group-hover:text-indigo-500 dark:group-hover:text-white' :
        'text-gray-500 dark:text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white'
        }}">
            {!! $icon !!}
        </i>
    @endif
</a>