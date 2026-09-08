<?php

namespace Jeffersongoncalves\Snov;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SnovServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-snov')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
