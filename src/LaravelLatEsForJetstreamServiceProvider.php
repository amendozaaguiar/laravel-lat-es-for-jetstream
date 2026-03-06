<?php

namespace Amendozaaguiar\LaravelLatEsForJetstream;

use Amendozaaguiar\LaravelLatEsForJetstream\Commands\CheckLaravelLatEsForJetstream;
use Amendozaaguiar\LaravelLatEsForJetstream\Commands\InstallLaravelLatEsForJetstream;
use Illuminate\Support\ServiceProvider;

class LaravelLatEsForJetstreamServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes(
            [__DIR__ . '/../resources/lang' => lang_path()],
            'laravel-lat-es-for-jetstream-lang'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallLaravelLatEsForJetstream::class,
                CheckLaravelLatEsForJetstream::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {}
}
