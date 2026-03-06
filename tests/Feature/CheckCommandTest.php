<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

it('el comando laravellates-jetstream:check falla sin lang/en/', function () {
    $enPath = lang_path('en');
    if (is_dir($enPath)) {
        collect(glob("{$enPath}/*.php"))->each(fn($f) => unlink($f));
        @rmdir($enPath);
    }

    $exit = Artisan::call('laravellates-jetstream:check');

    expect($exit)->toBe(1);
});

it('el comando acepta la opción --locale', function () {
    $enPath = lang_path('en');
    if (! is_dir($enPath)) {
        mkdir($enPath, 0755, true);
    }
    file_put_contents("{$enPath}/auth.php", "<?php\nreturn ['failed' => 'These credentials do not match.'];");

    $frPath = lang_path('fr');
    if (is_dir($frPath)) {
        collect(glob("{$frPath}/*.php"))->each(fn($f) => unlink($f));
        @rmdir($frPath);
    }

    $exit = Artisan::call('laravellates-jetstream:check', ['--locale' => 'fr']);

    expect($exit)->toBe(1); // Falla porque no existe lang/fr/

    unlink("{$enPath}/auth.php");
});

it('el comando pasa cuando las traducciones están sincronizadas', function () {
    $enPath = lang_path('en');
    $esPath = lang_path('es');

    // Limpiar directorios existentes para asegurar estado limpio
    foreach ([$enPath, $esPath] as $path) {
        if (is_dir($path)) {
            collect(glob("{$path}/*.php"))->each(fn($f) => unlink($f));
        } else {
            mkdir($path, 0755, true);
        }
    }

    file_put_contents("{$enPath}/auth.php", "<?php\nreturn ['failed' => 'These credentials do not match.'];");
    file_put_contents("{$esPath}/auth.php", "<?php\nreturn ['failed' => 'Credenciales incorrectas.'];");
    file_put_contents(lang_path('es.json'), json_encode(['Hello' => 'Hola']));

    $exit = Artisan::call('laravellates-jetstream:check');

    expect($exit)->toBe(0);

    unlink("{$enPath}/auth.php");
    unlink("{$esPath}/auth.php");
    @unlink(lang_path('es.json'));
});

it('el comando detecta claves faltantes', function () {
    $enPath = lang_path('en');
    $esPath = lang_path('es');

    foreach ([$enPath, $esPath] as $path) {
        if (is_dir($path)) {
            collect(glob("{$path}/*.php"))->each(fn($f) => unlink($f));
        } else {
            mkdir($path, 0755, true);
        }
    }

    file_put_contents("{$enPath}/auth.php", "<?php\nreturn ['failed' => '1', 'throttle' => '2'];");
    file_put_contents("{$esPath}/auth.php", "<?php\nreturn ['failed' => 'uno'];");
    file_put_contents(lang_path('es.json'), json_encode(['Hello' => 'Hola']));

    $exit = Artisan::call('laravellates-jetstream:check');

    expect($exit)->toBe(1);

    unlink("{$enPath}/auth.php");
    unlink("{$esPath}/auth.php");
    @unlink(lang_path('es.json'));
});

it('el comando falla si es.json no existe aunque los PHP estén bien', function () {
    $enPath = lang_path('en');
    $esPath = lang_path('es');

    foreach ([$enPath, $esPath] as $path) {
        if (is_dir($path)) {
            collect(glob("{$path}/*.php"))->each(fn($f) => unlink($f));
        } else {
            mkdir($path, 0755, true);
        }
    }

    file_put_contents("{$enPath}/auth.php", "<?php\nreturn ['failed' => 'These credentials do not match.'];");
    file_put_contents("{$esPath}/auth.php", "<?php\nreturn ['failed' => 'Credenciales incorrectas.'];");

    if (file_exists(lang_path('es.json'))) {
        unlink(lang_path('es.json'));
    }

    $exit = Artisan::call('laravellates-jetstream:check');

    expect($exit)->toBe(1);

    unlink("{$enPath}/auth.php");
    unlink("{$esPath}/auth.php");
});

it('el comando reporta es.json inválido', function () {
    $enPath = lang_path('en');
    $esPath = lang_path('es');

    foreach ([$enPath, $esPath] as $path) {
        if (is_dir($path)) {
            collect(glob("{$path}/*.php"))->each(fn($f) => unlink($f));
        } else {
            mkdir($path, 0755, true);
        }
    }

    file_put_contents("{$enPath}/auth.php", "<?php\nreturn ['failed' => 'These credentials do not match.'];");
    file_put_contents("{$esPath}/auth.php", "<?php\nreturn ['failed' => 'Credenciales incorrectas.'];");
    file_put_contents(lang_path('es.json'), '{invalid json}');

    $exit = Artisan::call('laravellates-jetstream:check');

    expect($exit)->toBe(1);

    unlink("{$enPath}/auth.php");
    unlink("{$esPath}/auth.php");
    @unlink(lang_path('es.json'));
});
