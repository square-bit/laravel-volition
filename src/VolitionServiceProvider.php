<?php

namespace Squarebit\Volition;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class VolitionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-volition')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-volition_table');
    }
}
