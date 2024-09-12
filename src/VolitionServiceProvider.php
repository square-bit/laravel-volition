<?php

namespace Squarebit\Volition;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Squarebit\Volition\Commands\UpgradeCommand;

class VolitionServiceProvider extends PackageServiceProvider
{
    public function register()
    {
        $this->app->singleton(Volition::class, fn () => new Volition);

        return parent::register();
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-volition')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(UpgradeCommand::class)
            ->hasMigration('create_laravel-volition_tables')
            ->hasMigration('rename_active-column-in-volition-rules_table')
            ->hasMigration('remove_class-in-volition-rules_table')
            ->runsMigrations();
    }
}
