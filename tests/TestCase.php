<?php

namespace Jeffersongoncalves\Snov\Tests;

use Jeffersongoncalves\Snov\SnovServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SnovServiceProvider::class,
        ];
    }
}
