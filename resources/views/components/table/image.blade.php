@props(['url', 'alt' => 'Imagem', 'class' => null])

@if ($url)
    @php
        $attributes = $attributes->class(['w-16 h-16 overflow-clip rounded-md'])->merge(['class' => $class]);
    @endphp
    <img src="{{ $url }}" alt="{{ $alt }}" {{ $attributes }}>
@endif