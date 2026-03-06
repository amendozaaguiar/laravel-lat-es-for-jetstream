<?php

namespace Amendozaaguiar\LaravelLatEsForJetstream\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class CheckLaravelLatEsForJetstream extends Command
{
    protected $signature = 'laravellates-jetstream:check
        {--locale=es : Locale a comparar contra el inglés}';

    protected $description = 'Compara lang/en/ con lang/{locale}/ y valida lang/{locale}.json para Jetstream.';

    public function handle(): int
    {
        $locale    = $this->option('locale');
        $enPath    = lang_path('en');
        $esPath    = lang_path($locale);
        $jsonFile  = lang_path("{$locale}.json");
        $hasIssues = false;

        // ── Comprobar que existe lang/en/ ────────────────────────────────────
        if (! is_dir($enPath)) {
            $this->error("No existe el directorio lang/en/. Ejecuta primero: php artisan lang:publish");

            return self::FAILURE;
        }

        // ── Comprobar que existe lang/{locale}/ ──────────────────────────────
        if (! is_dir($esPath)) {
            $this->error("No existe el directorio lang/{$locale}/. Ejecuta primero: php artisan laravellates-jetstream:install");

            return self::FAILURE;
        }

        $enFiles  = collect(glob("{$enPath}/*.php"))->mapWithKeys(fn($f) => [basename($f, '.php') => $f]);
        $esFiles  = collect(glob("{$esPath}/*.php"))->mapWithKeys(fn($f) => [basename($f, '.php') => $f]);

        $missingFiles = $enFiles->keys()->diff($esFiles->keys());
        $orphanFiles  = $esFiles->keys()->diff($enFiles->keys());
        $totalMissing = 0;
        $totalOrphan  = 0;

        // ── Archivos que faltan en el locale ────────────────────────────────
        if ($missingFiles->isNotEmpty()) {
            $hasIssues = true;
            $this->newLine();
            $this->line("<fg=red;options=bold>Archivos faltantes en lang/{$locale}/:</>");
            $missingFiles->each(fn($file) => $this->line("  <fg=red>✗</> {$file}.php"));
        }

        // ── Archivos extra (en locale pero no en en/) ───────────────────────
        if ($orphanFiles->isNotEmpty()) {
            $hasIssues = true;
            $this->newLine();
            $this->line("<fg=yellow;options=bold>Archivos en lang/{$locale}/ sin contraparte en lang/en/:</>");
            $orphanFiles->each(fn($file) => $this->line("  <fg=yellow>⚠</> {$file}.php"));
        }

        // ── Comparar claves por archivo ──────────────────────────────────────
        $commonFiles = $enFiles->keys()->intersect($esFiles->keys());

        foreach ($commonFiles as $group) {
            $enKeys = Arr::dot(require $enFiles[$group]);
            $esKeys = Arr::dot(require $esFiles[$group]);

            $missing = array_diff_key($enKeys, $esKeys);
            $orphan  = array_diff_key($esKeys, $enKeys);

            if (! empty($missing)) {
                $hasIssues = true;
                $totalMissing += count($missing);
                $this->newLine();
                $this->line("<fg=red;options=bold>{$group}.php — " . count($missing) . " clave(s) faltante(s):</>");
                foreach ($missing as $key => $value) {
                    $this->line("  <fg=red>✗</> {$key}");
                    $this->line("    <fg=gray>EN:</> {$this->truncate((string)$value)}");
                }
            }

            if (! empty($orphan)) {
                $hasIssues = true;
                $totalOrphan += count($orphan);
                $this->newLine();
                $this->line("<fg=yellow;options=bold>{$group}.php — " . count($orphan) . " clave(s) extra (no existen en EN):</>");
                foreach ($orphan as $key => $value) {
                    $this->line("  <fg=yellow>⚠</> {$key}");
                }
            }
        }

        // ── Validar lang/{locale}.json (Jetstream JSON strings) ──────────────
        $this->newLine();
        if (! file_exists($jsonFile)) {
            $hasIssues = true;
            $this->line("<fg=red>✗</> No existe lang/{$locale}.json (requerido por Jetstream).");
            $this->line("  Ejecuta: php artisan laravellates-jetstream:install");
        } else {
            $jsonContent = file_get_contents($jsonFile);
            $jsonData    = json_decode($jsonContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $hasIssues = true;
                $this->line("<fg=red>✗</> lang/{$locale}.json no es JSON válido: " . json_last_error_msg());
            } else {
                $keyCount = count($jsonData);
                $this->line("<fg=green>✓</> lang/{$locale}.json es JSON válido con <fg=cyan>{$keyCount}</> traducciones.");
            }
        }

        // ── Resumen ──────────────────────────────────────────────────────────
        $this->newLine();

        if (! $hasIssues) {
            $this->line("<fg=green;options=bold>✓ Las traducciones lang/{$locale}/ y lang/{$locale}.json están correctas.</>");

            return self::SUCCESS;
        }

        $this->line("<fg=red;options=bold>Resumen para lang/{$locale}/:</>");

        if ($missingFiles->isNotEmpty()) {
            $this->line("  <fg=red>•</> {$missingFiles->count()} archivo(s) faltante(s)");
        }

        if ($totalMissing > 0) {
            $this->line("  <fg=red>•</> {$totalMissing} clave(s) sin traducir");
        }

        if ($totalOrphan > 0) {
            $this->line("  <fg=yellow>•</> {$totalOrphan} clave(s) extra (obsoletas)");
        }

        return self::FAILURE;
    }

    private function truncate(string $value, int $length = 80): string
    {
        return mb_strlen($value) > $length
            ? mb_substr($value, 0, $length) . '…'
            : $value;
    }
}
