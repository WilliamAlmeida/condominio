<?php

namespace App\Console\Commands\CacheDictionary;

use App\Traits\CacheDictionary;
use Illuminate\Console\Command;

class dictClear extends Command
{
    use CacheDictionary;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dict:clear {--key=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear a specific key in the cache dictionary.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = $this->option('key');

        if (!empty($key)) {
            $this->dictClear($key);
            $this->info("Cache for key '{$key}' cleared.");
        } else {
            $this->dictClear();
            $this->info('Cache dictionary cleared.');
        }
    }
}
