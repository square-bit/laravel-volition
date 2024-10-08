<?php

namespace Squarebit\Volition\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;
use Squarebit\Volition\VolitionServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            VolitionServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $migration = include __DIR__.'/../database/migrations/create_laravel-volition_tables.php.stub';
        $migration->up();
        $migration = include __DIR__.'/../database/migrations/rename_active-column-in-volition-rules_table.php.stub';
        $migration->up();
        $migration = include __DIR__.'/../database/migrations/remove_class-in-volition-rules_table.php.stub';
        $migration->up();
    }
}
