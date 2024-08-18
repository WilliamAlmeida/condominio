<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class reinit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reinit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'php artisan migrate:refresh && php artisan db:seed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directories = Storage::directories('public');

        foreach ($directories as $directory) {
            Storage::deleteDirectory($directory);
        }

        $this->call('dict:clear');
        $this->call('migrate:fresh');
        $this->call('db:seed');
        $this->info('Reinitialized successfully.');
    }
}
