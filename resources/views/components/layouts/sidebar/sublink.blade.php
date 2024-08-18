@props([
    'route',
    'label',
    'active' => false,
])

<a href="{{ $route }}" wire:navigate class="flex items-center p-2 pl-11 w-full text-base font-normal rounded-lg transition duration-75 group {{ $active ?
'text-indigo-500  hover:bg-gray-100 dark:indigo-900 dark:hover:bg-gray-700' :
'text-gray-900  hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700'
}}">
    <span>{{ $label }}</span>
</a>