<?php

namespace App\Traits;

trait HelperPowerGrid
{
    public function fieldImage($row, $url = null, $alt = null, $class = 'w-8 h-8'): string
    {
        if (!$url) return '';

        $path_view = 'components.table.image';

        if (!view()->exists($path_view)) return '';

        return view($path_view, ['url' => $url, 'alt' => $alt, 'class' => $class])->render();
    }
}
