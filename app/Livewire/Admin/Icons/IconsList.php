<?php

namespace App\Livewire\Admin\Icons;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class IconsList extends Component
{
    #[Locked]
    public $icons = [];
    
    public $limit = 0;
    
    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <div class="px-3 py-1 text-xs font-medium leading-none text-indigo-500 animate-pulse">loading...</div>
        </div>
        HTML;
    }
    
    public function mount()
    {
        $this->icons = cache()->remember('icons', now()->addHours(24), function () {
            // Caminhos das pastas
            $pastaSolid = Storage::disk('wireui')->path('solid');
            $pastaOutline = Storage::disk('wireui')->path('outline');
            
            // Listar arquivos .blade das duas pastas
            $arquivosSolid = $this->listFiles($pastaSolid);
            $arquivosOutline = $this->listFiles($pastaOutline);
            
            // Agrupar os arquivos
            return [
                'solid' => $arquivosSolid,
                'outline' => $arquivosOutline,
            ];
        });
    }
    
    private function listFiles($pasta)
    {
        $arquivos = [];
        
        // Verificar se a pasta existe
        if (File::isDirectory($pasta)) {
            // Listar os arquivos na pasta
            $arquivos = File::files($pasta);
            
            // Obter apenas os nomes dos arquivos (sem extensão)
            $arquivos = array_map(function ($arquivo) {
                return str_replace('.blade.php', '', $arquivo->getFilename());
            }, $arquivos);
        }
        
        return $arquivos;
    }
    
    public function render()
    {
        return view('livewire.admin.icons.icons-list');
    }
}
