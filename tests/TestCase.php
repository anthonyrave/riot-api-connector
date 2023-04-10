<?php

namespace Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithConsole;

    protected function getPackageProviders($app): array
    {
        return [
            'RiotApiConnector\RiotApiConnectorServiceProvider',
        ];
    }
}
