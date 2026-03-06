# laravel-lat-es-for-jetstream

[![Latest Version on Packagist](https://img.shields.io/packagist/v/amendozaaguiar/laravel-lat-es-for-jetstream.svg?style=flat-square)](https://packagist.org/packages/amendozaaguiar/laravel-lat-es-for-jetstream)
[![Total Downloads](https://img.shields.io/packagist/dt/amendozaaguiar/laravel-lat-es-for-jetstream.svg?style=flat-square)](https://packagist.org/packages/amendozaaguiar/laravel-lat-es-for-jetstream)
[![Tests](https://github.com/amendozaaguiar/laravel-lat-es-for-jetstream/actions/workflows/tests.yml/badge.svg)](https://github.com/amendozaaguiar/laravel-lat-es-for-jetstream/actions/workflows/tests.yml)
[![PHP Version](https://img.shields.io/badge/php-%5E8.2-blue?style=flat-square)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-10%20|%2011%20|%2012-red?style=flat-square)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-green?style=flat-square)](LICENSE)

Archivos de traducción al **español latinoamericano** para proyectos **Laravel + Jetstream**.

Incluye:
- `lang/es/auth.php`, `pagination.php`, `passwords.php`, `validation.php` — traducciones estándar de Laravel
- `lang/es.json` — 216+ cadenas JSON de Jetstream (2FA, Teams, API Tokens, Browser Sessions, Perfil, etc.)

---

## Requisitos

- PHP `^8.2`
- Laravel `^10.0 | ^11.0 | ^12.0`
- Laravel Jetstream `^4.0 | ^5.0`

---

## Instalación

```bash
composer require amendozaaguiar/laravel-lat-es-for-jetstream
```

### Publicar las traducciones

```bash
php artisan laravellates-jetstream:install
```

Esto publica los archivos de traducción en el directorio `lang/` de tu proyecto Laravel:

```
lang/
├── es/
│   ├── auth.php
│   ├── pagination.php
│   ├── passwords.php
│   └── validation.php
└── es.json          ← Todas las cadenas de texto de Jetstream
```

### Activar el locale en español

En `config/app.php`:

```php
'locale' => 'es',
'fallback_locale' => 'en',
```

---

## Comandos Artisan

### `laravellates-jetstream:install`

Publica todos los archivos de traducción en el directorio `lang/` del proyecto.

```bash
php artisan laravellates-jetstream:install
```

### `laravellates-jetstream:check`

Verifica que las traducciones estén completas y el `es.json` sea válido. Útil para pipelines CI/CD.

```bash
# Verificar locale es (por defecto)
php artisan laravellates-jetstream:check

# Verificar otro locale
php artisan laravellates-jetstream:check --locale=pt
```

El comando reporta:
- ✗ Archivos PHP faltantes en `lang/{locale}/`
- ✗ Claves sin traducir por archivo
- ⚠ Claves obsoletas (no existen en `lang/en/`)
- ✓ Validez y conteo del archivo `{locale}.json`

Retorna código de salida `0` si todo está bien, `1` si hay problemas.

---

## Traducciones incluidas

### Archivos PHP (`lang/es/`)

| Archivo | Claves |
|---------|--------|
| `auth.php` | failed, password, throttle |
| `pagination.php` | previous, next |
| `passwords.php` | reset, sent, throttled, token, user |
| `validation.php` | required, email, min, max, confirmed, unique, etc. |

### JSON — Cadenas de Jetstream (`lang/es.json`)

Más de **216 traducciones** que cubren:

| Área | Ejemplos |
|------|---------|
| Autenticación 2FA | Two Factor Authentication, Setup Key, Recovery Code |
| Gestión de equipos | Team Members, Create Team, Leave Team, Switch Teams |
| Tokens API | API Tokens, Create API Token, Token Permissions |
| Sesiones | Browser Sessions, Log Out Other Browser Sessions |
| Perfil | Profile Information, Update Password, Delete Account |
| Email | Verify Email Address, Resend Verification Email |
| General | Dashboard, Save, Cancel, Confirm, Delete, etc. |

---

## Integración con Laravel Boost (Agentes IA)

Este paquete incluye soporte nativo para **[Laravel Boost](https://github.com/laravel/boost)**, permitiendo que agentes IA (Claude, Copilot, etc.) conozcan las traducciones disponibles y cómo usarlas.

### Agregar al proyecto con Boost

En tu `boost.json`:

```json
{
    "packages": [
        "amendozaaguiar/laravel-lat-es-for-jetstream"
    ]
}
```

Luego actualiza:

```bash
php artisan boost:update
```

El agente IA tendrá contexto sobre:
- Archivos de traducción disponibles
- Cómo usar `__()` para cada área
- Comandos de instalación y verificación

---

## Tests

```bash
composer test
```

Tests incluidos:
- `tests/Unit/LangFilesTest.php` — verifica que todos los archivos existen, son arrays válidos y tienen las claves requeridas; valida es.json
- `tests/Feature/ServiceProviderTest.php` — verifica el ServiceProvider, tag de publicación y estructura de Boost
- `tests/Feature/CheckCommandTest.php` — prueba el comando `laravellates-jetstream:check`

---

## Licencia

[MIT](LICENSE) © 2026 Anderson Mendoza
