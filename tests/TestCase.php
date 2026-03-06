<?php

namespace Amendozaaguiar\LaravelLatEsForJetstream\Tests;

use Amendozaaguiar\LaravelLatEsForJetstream\LaravelLatEsForJetstreamServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelLatEsForJetstreamServiceProvider::class,
        ];
    }
}
