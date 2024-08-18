@props(['form', 'label' => 'Fotos', 'wireModel' => 'form.fotos_tmp'])

<div class="col-span-2 flex flex-col gap-3">
    <x-input :label=$label type="file" :wire:model.defer=$wireModel accept="image/jpeg,image/png,image/webp,image/jpg,image/avif" class="py-0 text-sm" multiple />

    @error('form.fotos_tmp.*')
        <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror

    <div wire:loading wire:target="form.fotos_tmp">Uploading...</div>

    @foreach($form->fotos_tmp as $key => $foto)
        <div class="flex items-center gap-x-3">
            <img src="{{ $foto?->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-md border" alt="Foto #{{ $key }}">

            <x-button icon="trash" flat negative label="Cancelar" wire:click="cancelFotoTemp({{ $key }})" />
        </div>
    @endforeach

    @foreach($form->fotos as $key => $foto)
        <div class="flex items-center gap-x-3">
            <img src="{{ asset('storage/' . $foto->url) }}" class="w-32 h-32 object-cover rounded-md border" alt="Foto #{{ $key }}">

            <x-button icon="trash" negative label="Remover" wire:click="deleteFoto({{ $key }})" />
        </div>
    @endforeach
</div>