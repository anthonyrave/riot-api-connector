<?php

namespace RiotApiConnector\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use InteractsWithConsole;

    protected function getPackageProviders($app): array
    {
        return [
            'RiotApiConnector\\RiotApiConnectorServiceProvider',
        ];
    }
}
