<?php

namespace App\Traits;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Intervention\Image\ImageManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait FormHasAvatar
{
    #[Locked]
    public $foto_id;
    
    #[Locked]
    public $foto;
    
    #[Validate('nullable')]
    #[Validate('image', as: 'foto')]
    #[Validate('mimes:jpeg,png,webp,jpg,avif', message: 'O arquivo deve ser uma imagem do tipo JPEG, PNG, WEBP, JPG ou AVIF.')]
    #[Validate('max:2048', message: 'O imagem não pode ser maior que 2 MB (Mega).')]
    public $foto_tmp;
    
    public function saveFoto(Model $model, bool $toWebp = true): bool
    {
        if(!$this->foto_tmp) return true;
        
        try {
            if($this->foto_tmp) {
                $url = $this->foto_tmp->store($model->getTable(), 'public');
                
                $data_file = [
                    'url'           => $url,
                    'original_name' => $this->foto_tmp->getClientOriginalName(),
                    'full_name'     => $this->foto_tmp->hashName(),
                    'extension'     => $this->foto_tmp->extension(),
                    'file_mimetype' => $this->foto_tmp->getMimeType(),
                    'rel_id'        => $model->id,
                    'rel_table'     => $model->getTable()
                ];

                if($toWebp && $this->fotoToWebP($url, 'public')) {
                    $data_file = array_merge($data_file, [
                        'url'           => str_replace($this->foto_tmp->extension(), 'webp', $url),
                        'full_name'     => str_replace($this->foto_tmp->extension(), 'webp', $data_file['full_name']),
                        'extension'     => 'webp',
                        'file_mimetype' => 'image/webp'
                    ]);
                }
                
                $this->foto = $model->foto()->create($data_file);
                
                $this->foto_id = $this->foto->id;
                
                $this->reset('foto_tmp');
            }
            
            return true;
            
        } catch (\Throwable $th) {
            throw $th;
            
            return false;
        }
    }
    
    public function cancelFotoSaved()
    {
        if($this->foto) Storage::disk('public')->delete($this->foto->url);
        $this->reset('foto_id', 'foto');
    }

    public function cancelFotoTemp($model): void
    {
        if($this->foto_tmp && file_exists($this->foto_tmp->getRealPath())) unlink($this->foto_tmp->getRealPath());
        
        $model->fotoDelete();
        
        $this->reset('foto_tmp', 'foto');
        
        $this->resetValidation('foto_tmp');
    }
    
    public function deleteFoto($model): void
    {
        if(!$this->foto) return;
        
        $model->fotoDelete();
        
        $this->reset('foto_id', 'foto');
        
        $model->update(['foto_id' => null]);
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
            $image->cover(300, 300);

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
        $component->dispatch('resetInputFile', ['query' => 'input[name="form.foto_tmp"]']);
    }
}
