<?php

namespace App\Traits;

trait CacheDictionary
{
    private function dictList(): array
    {
        return cache()->get('dict_cache', []);
    }

    private function dictAdd(string $key): void
    {
        $dict = cache()->get('dict_cache', []);
        if(!in_array($key, $dict)) {
            $dict[] = $key;
        }
        cache()->set('dict_cache', $dict);
    }

    private function dictRemove(string $key): void
    {
        $dict = cache()->get('dict_cache', []);
        $dict = array_filter($dict, function($cache) use ($key) {
            return $cache !== $key;
        });
        cache()->set('dict_cache', $dict);
    }

    private function dictClear(string $key = ''): void
    {
        foreach(cache()->get('dict_cache', []) as $cache) {
            if($key) {
                if(strpos($cache, $key) !== false) cache()->forget($cache);
            }else{
                cache()->forget($cache);
            }
        }

        if($key) {
            $this->dictRemove($key);
        }else{
            cache()->forget('dict_cache');
        }
    }
}