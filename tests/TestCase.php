<?php

namespace Viezel\Webhooks\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Viezel\Webhooks\WebhooksServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            WebhooksServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*
        include_once __DIR__.'/../database/migrations/create_webhooks_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
