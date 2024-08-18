@props(['form', 'label' => 'Foto', 'wireModel' => 'form.foto_tmp'])

<div class="col-span-2 flex flex-col gap-3">
    @if(!$form->foto_tmp && !$form->foto)
        <x-input :label=$label type="file" :wire:model.defer=$wireModel accept="image/jpeg,image/png,image/webp,image/jpg,image/avif" class="py-0 text-sm" />
    @endif

    <div wire:loading wire:target="{{ $wireModel }}">Uploading...</div>

    @if($form->foto_tmp || $form->foto)
        <x-label class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ $label }}</x-label>
        <div class="flex items-center gap-x-3">
            <img src="{{ $form->foto_tmp?->temporaryUrl() ?? asset('storage/' . $form->foto->url) }}" class="w-32 h-32 object-cover rounded-md border" alt="{{ $label }}">
            @if($form->foto)
                <x-button icon="trash" negative label="Remover" wire:click="delete_foto" />
            @elseif($form->foto_tmp)
                <x-button icon="trash" flat negative label="Cancelar" wire:click="cancel_foto_tmp" />
            @endif
        </div>
    @endif

    @error($wireModel)
        <x-label :label="$message" class="text-red-500" />
    @enderror
</div>