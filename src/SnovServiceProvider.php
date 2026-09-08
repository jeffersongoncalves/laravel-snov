<?php

namespace JeffersonGoncalves\Snov;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SnovServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('snov')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(SnovClient::class);
        $this->app->alias(SnovClient::class, 'snov');
    }
}
