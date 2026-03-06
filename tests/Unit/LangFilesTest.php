<?php

use Illuminate\Support\Arr;

$langPath = __DIR__ . '/../../resources/lang/es';

// ── Archivo auth.php ──────────────────────────────────────────────────────────
it('auth.php existe', function () use ($langPath) {
    expect(file_exists("{$langPath}/auth.php"))->toBeTrue();
});

it('auth.php retorna un array', function () use ($langPath) {
    expect(require "{$langPath}/auth.php")->toBeArray();
});

it('auth.php tiene las claves requeridas', function () use ($langPath) {
    $keys = array_keys(Arr::dot(require "{$langPath}/auth.php"));
    expect($keys)->toContain('failed')
        ->toContain('password')
        ->toContain('throttle');
});

it('auth.php no tiene valores vacíos', function () use ($langPath) {
    foreach (Arr::dot(require "{$langPath}/auth.php") as $key => $value) {
        expect($value)->not->toBeEmpty("La clave auth.{$key} está vacía");
    }
});

// ── Archivo pagination.php ────────────────────────────────────────────────────
it('pagination.php existe', function () use ($langPath) {
    expect(file_exists("{$langPath}/pagination.php"))->toBeTrue();
});

it('pagination.php retorna un array', function () use ($langPath) {
    expect(require "{$langPath}/pagination.php")->toBeArray();
});

it('pagination.php tiene las claves requeridas', function () use ($langPath) {
    $keys = array_keys(Arr::dot(require "{$langPath}/pagination.php"));
    expect($keys)->toContain('previous')
        ->toContain('next');
});

// ── Archivo passwords.php ─────────────────────────────────────────────────────
it('passwords.php existe', function () use ($langPath) {
    expect(file_exists("{$langPath}/passwords.php"))->toBeTrue();
});

it('passwords.php retorna un array', function () use ($langPath) {
    expect(require "{$langPath}/passwords.php")->toBeArray();
});

it('passwords.php tiene las claves requeridas', function () use ($langPath) {
    $keys = array_keys(Arr::dot(require "{$langPath}/passwords.php"));
    expect($keys)->toContain('reset')
        ->toContain('sent')
        ->toContain('throttled')
        ->toContain('token')
        ->toContain('user');
});

// ── Archivo validation.php ────────────────────────────────────────────────────
it('validation.php existe', function () use ($langPath) {
    expect(file_exists("{$langPath}/validation.php"))->toBeTrue();
});

it('validation.php retorna un array', function () use ($langPath) {
    expect(require "{$langPath}/validation.php")->toBeArray();
});

it('validation.php tiene claves de validación comunes', function () use ($langPath) {
    $keys = array_keys(Arr::dot(require "{$langPath}/validation.php"));
    expect($keys)->toContain('required')
        ->toContain('email')
        ->toContain('min.string')
        ->toContain('confirmed');
});

// ── Archivo es.json (Jetstream JSON strings) ──────────────────────────────────
$jsonPath = __DIR__ . '/../../resources/lang/es.json';

it('es.json existe', function () use ($jsonPath) {
    expect(file_exists($jsonPath))->toBeTrue();
});

it('es.json es JSON válido', function () use ($jsonPath) {
    $data = json_decode(file_get_contents($jsonPath), true);
    expect(json_last_error())->toBe(JSON_ERROR_NONE)
        ->and($data)->toBeArray();
});

it('es.json tiene más de 200 claves de Jetstream', function () use ($jsonPath) {
    $data = json_decode(file_get_contents($jsonPath), true);
    expect(count($data))->toBeGreaterThan(200);
});

it('es.json contiene claves esenciales de Jetstream', function () use ($jsonPath) {
    $data = json_decode(file_get_contents($jsonPath), true);
    $requiredKeys = [
        'Two Factor Authentication',
        'API Tokens',
        'Team Members',
        'Profile Information',
        'Update Password',
        'Browser Sessions',
        'Log Out',
        'Log in',
    ];
    foreach ($requiredKeys as $key) {
        expect($data)->toHaveKey($key);
    }
});

it('es.json no tiene valores vacíos', function () use ($jsonPath) {
    $data = json_decode(file_get_contents($jsonPath), true);
    foreach ($data as $key => $value) {
        expect($value)->not->toBeEmpty("La clave '{$key}' tiene valor vacío en es.json");
    }
});
