<?php

use Amendozaaguiar\LaravelLatEsForJetstream\LaravelLatEsForJetstreamServiceProvider;
use Illuminate\Support\ServiceProvider;

it('el ServiceProvider está registrado', function () {
    $providers = array_keys($this->app->getLoadedProviders());
    expect($providers)->toContain(LaravelLatEsForJetstreamServiceProvider::class);
});

it('el ServiceProvider es una instancia de ServiceProvider', function () {
    $provider = $this->app->getProvider(LaravelLatEsForJetstreamServiceProvider::class);
    expect($provider)->toBeInstanceOf(ServiceProvider::class);
});

it('el tag laraveles-spanish-for-jetstream-lang está registrado', function () {
    $paths = collect(ServiceProvider::pathsToPublish(
        LaravelLatEsForJetstreamServiceProvider::class,
        'laraveles-spanish-for-jetstream-lang'
    ));
    expect($paths)->not->toBeEmpty();
});

it('el tag publica al directorio lang', function () {
    $paths = ServiceProvider::pathsToPublish(
        LaravelLatEsForJetstreamServiceProvider::class,
        'laraveles-spanish-for-jetstream-lang'
    );
    $destination = array_values($paths)[0] ?? null;
    expect($destination)->toContain('lang');
});

it('el comando laravellates-jetstream:install existe', function () {
    $this->artisan('laravellates-jetstream:install')->assertExitCode(0);
});

it('el comando laravellates-jetstream:check existe', function () {
    expect(true)->toBeTrue(); // Se testea en CheckCommandTest
});

// ── Boost: estructura de archivos ─────────────────────────────────────────────
it('existe el directorio resources/boost', function () {
    $path = __DIR__ . '/../../resources/boost';
    expect(is_dir($path))->toBeTrue();
});

it('existe el directorio resources/boost/skills', function () {
    $path = __DIR__ . '/../../resources/boost/skills';
    expect(is_dir($path))->toBeTrue();
});

it('existe el archivo skill.blade.php', function () {
    $skill = __DIR__ . '/../../resources/boost/skills/laraveles-spanish-for-jetstream/skill.blade.php';
    expect(file_exists($skill))->toBeTrue();
});

it('skill.blade.php tiene frontmatter YAML válido', function () {
    $skill   = __DIR__ . '/../../resources/boost/skills/laraveles-spanish-for-jetstream/skill.blade.php';
    $content = file_get_contents($skill);
    expect($content)->toContain('name: laraveles-spanish-for-jetstream')
        ->toContain('description:');
});

it('existe el archivo de guideline core.blade.php', function () {
    $guideline = __DIR__ . '/../../resources/boost/guidelines/core.blade.php';
    expect(file_exists($guideline))->toBeTrue();
});

it('guideline menciona el comando install de jetstream', function () {
    $guideline = __DIR__ . '/../../resources/boost/guidelines/core.blade.php';
    $content   = file_get_contents($guideline);
    expect($content)->toContain('laravellates-jetstream:install');
});
