<?php

namespace JeffersonGoncalves\Snov\Tests;

use JeffersonGoncalves\Snov\SnovServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SnovServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('snov.client_id', 'fake-client-id');
        $app['config']->set('snov.client_secret', 'fake-client-secret');
        $app['config']->set('snov.base_url', 'https://api.snov.io/v1');
    }
}
