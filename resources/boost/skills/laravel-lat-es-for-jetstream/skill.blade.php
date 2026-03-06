---
name: laravel-lat-es-for-jetstream
description: >
  Traducciones al español latinoamericano para Laravel con Jetstream.
  Cubre auth.php, pagination.php, passwords.php, validation.php EN lang/es/
  y todas las cadenas JSON de Jetstream en lang/es.json (216+ claves).
  Comandos artisan: laravellates-jetstream:install y laravellates-jetstream:check.
---

# laravel-lat-es-for-jetstream

Paquete de traducciones al español latinoamericano para Laravel + Jetstream.

## Archivos de traducción

### PHP (lang/es/)
| Archivo | Descripción |
|---------|-------------|
| `auth.php` | Mensajes de autenticación (credenciales inválidas, deshabilitado) |
| `pagination.php` | Textos de paginación (anterior, siguiente) |
| `passwords.php` | Mensajes del sistema de contraseñas |
| `validation.php` | Mensajes de validación de formularios |

### JSON (lang/es.json)
Contiene 216+ traducciones para todas las cadenas de texto usadas en las vistas de Jetstream:
- Autenticación 2FA (Two Factor Authentication)
- Gestión de equipos (Teams)
- Tokens API
- Sesiones del navegador
- Perfil de usuario
- Verificación de email
- Recuperación de cuenta

## Uso
```php
// Las traducciones JSON se usan automáticamente en las vistas Blade de Jetstream
__('Two factor authentication is now enabled. ...')
// → "La autenticación de dos factores ahora está habilitada. ..."

// Las traducciones PHP se usan con el prefijo de archivo
__('auth.failed')
// → "Estas credenciales no coinciden con nuestros registros."
```

## Comandos Artisan

| Comando | Descripción |
|---------|-------------|
| `php artisan laravellates-jetstream:install` | Publica lang/es/ y lang/es.json en el proyecto |
| `php artisan laravellates-jetstream:check` | Verifica que las traducciones estén completas y el JSON sea válido |
| `php artisan laravellates-jetstream:check --locale=pt` | Verifica otro locale |

### laravellates-jetstream:install
Publica todos los archivos de traducción al directorio `lang/` del proyecto.
Equivale a `vendor:publish --tag=laravel-lat-es-for-jetstream-lang`.

### laravellates-jetstream:check
Compara `lang/en/` con `lang/es/` (archivos PHP) y valida `lang/es.json`:
- Archivos PHP faltantes o con claves sin traducir
- Archivos PHP con claves obsoletas (no existen en EN)
- Validez del JSON y conteo de traducciones
- Retorna código de salida 1 si hay problemas (compatible con CI/CD)

## Instalación en proyecto
```bash
composer require amendozaaguiar/laravel-lat-es-for-jetstream
php artisan laravellates-jetstream:install
```

## Publicar tag en composer.json
```json
"amendozaaguiar/laravel-lat-es-for-jetstream": "^1.0"
```

## ServiceProvider
`Amendozaaguiar\LaravelLatEsForJetstream\LaravelLatEsForJetstreamServiceProvider`
- Publica con tag: `laravel-lat-es-for-jetstream-lang`
- Destino: `lang_path()` (directorio `lang/` del proyecto Laravel)

## Compatibilidad
- PHP `^8.2`
- Laravel `^10.0|^11.0|^12.0`
- Jetstream `^4.0|^5.0` (Livewire y Inertia)
