<?php

namespace Squarebit\Volition;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class VolitionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-volition')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-volition_tables')
            ->hasMigration('rename_active-column-in-volition-rules_table')
            ->runsMigrations();
    }
}
