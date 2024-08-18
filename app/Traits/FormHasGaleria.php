<?php

namespace App\Traits;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Intervention\Image\ImageManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait FormHasGaleria
{
    #[Locked]
    public $fotos = [];

    #[Validate([
        'fotos_tmp.*' => 'nullable|image|mimes:jpeg,png,webp,jpg,avif|max:2048'
        ], message: [
        'fotos_tmp.*.mimes' => 'O arquivo deve ser uma imagem do tipo JPEG, PNG, WEBP, JPG ou AVIF.',
        'fotos_tmp.*.max' => 'As imagens não podem ser maior que 2 MB (Mega).'
    ], attribute: [
        'fotos_tmp.*' => 'foto',
    ])]
    public $fotos_tmp = [];

    public string $sub_dir = 'galeria';

    public function saveFoto(Model $model, bool $toWebp = true): bool
    {
        if(!count($this->fotos_tmp)) return true;

        try {
            if(count($this->fotos_tmp)) {
                foreach($this->fotos_tmp as $foto) {
                    $url = $foto->store($model->getTable() . '/' . $model->id . '/' . $this->sub_dir, 'public');

                    $data_file = [
                        'url'           => $url,
                        'original_name' => $foto->getClientOriginalName(),
                        'full_name'     => $foto->hashName(),
                        'extension'     => $foto->extension(),
                        'file_mimetype' => $foto->getMimeType(),
                        'rel_id'        => $model->id,
                        'rel_table'     => $model->getTable()
                    ];
                    
                    if($toWebp && $this->fotoToWebP($url, 'public')) {
                        $data_file = array_merge($data_file, [
                            'url'           => str_replace($foto->extension(), 'webp', $url),
                            'full_name'     => str_replace($foto->extension(), 'webp', $data_file['full_name']),
                            'extension'     => 'webp',
                            'file_mimetype' => 'image/webp'
                        ]);
                    }

                    $this->fotos[] = $model->fotos()->create($data_file);
                }

                $this->reset('fotos_tmp');
            }
            
            return true;
            
        } catch (\Throwable $th) {
            throw $th;
            
            return false;
        }
    }
    
    public function cancelFotoSaved()
    {
        if(count($this->fotos)) {
            foreach($this->fotos as $foto) {
                Storage::disk('public')->delete($foto->url);
            }
        }
        $this->reset('fotos');
    }

    public function cancelFotoTemp($index): void
    {
        if(!isset($this->fotos_tmp[$index])) return;

        $foto = $this->fotos_tmp[$index];

        if(file_exists($foto->getRealPath())) unlink($foto->getRealPath());

        unset($this->fotos_tmp[$index]);

        $this->resetValidation('fotos_tmp.*');
    }

    public function deleteFoto(Model $model, int $index): void
    {
        if(!isset($this->fotos[$index])) return;

        $foto = $this->fotos[$index];
        
        $model->fotoDelete($foto);

        unset($this->fotos[$index]);
    }

    public function fotoToWebP(string $path_file, string $disk): bool
    {
        // Verifica se o caminho do arquivo é válido
        if(!$path_file) return false;

        try {
            // Obtém o caminho completo do arquivo
            $path_file = Storage::disk($disk)->path($path_file);

            // Obtém o nome do arquivo sem a extensão
            $name = pathinfo($path_file, PATHINFO_FILENAME);

            // Cria uma instância do ImageManager
            $manager = new ImageManager(config('image.driver'));

            // Le o arquivo de imagem usando o ImageManager
            $image = $manager->read($path_file);

            // $image->orientate();

            // Redimensiona a imagem para 300x300 pixels
            // $image->cover(300, 300);
            $image->scaleDown(height: 300);

            // Converte a imagem para o formato WebP com qualidade 60
            $encode = $image->toWebp(60);

            // Obtém o diretório onde a imagem será salva
            $dir = pathinfo($path_file, PATHINFO_DIRNAME);

            // Salva a imagem WebP no mesmo diretório com o mesmo nome do arquivo original
            $image->save($dir . '/' . $name . '.webp');

            // Remove o arquivo original se a conversão for bem-sucedida
            if(file_exists($path_file)) unlink($path_file);

            // Retorna true indicando que a conversão foi bem-sucedida
            return true;
        } catch (\Throwable $th) {
            // Retorna false se ocorrer uma exceção durante o processo
            return false;
        }
    }

    public function resetInputFile($component): void
    {
        $component->dispatch('resetInputFile', ['query' => 'input[name="form.fotos_tmp"]']);
    }
}
