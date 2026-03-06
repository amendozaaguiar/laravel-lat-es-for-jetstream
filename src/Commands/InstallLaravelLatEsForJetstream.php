<?php

namespace Amendozaaguiar\LaravelLatEsForJetstream\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallLaravelLatEsForJetstream extends Command
{
    protected $signature = 'laravellates-jetstream:install';

    protected $description = 'Instala los archivos de traducción de Laravel + Jetstream en Español.';

    public function handle(): int
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'Amendozaaguiar\LaravelLatEsForJetstream\LaravelLatEsForJetstreamServiceProvider',
            '--tag'      => 'laravel-lat-es-for-jetstream-lang',
        ]);

        $this->info('✓ Traducciones de Laravel + Jetstream en Español instaladas correctamente.');

        return self::SUCCESS;
    }
}
