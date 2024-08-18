<?php

namespace App\Console\Commands\CacheDictionary;

use App\Traits\CacheDictionary;
use Illuminate\Console\Command;

class dictList extends Command
{
    use CacheDictionary;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dict:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all keys in the cache dictionary.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cache = $this->dictList();

        if(count($cache) > 0) {
            $this->info('Cache dictionary:');
            foreach($cache as $key) {
                $this->info($key);
            }
        }else{
            $this->info('Cache dictionary is empty.');
        }
    }
}
