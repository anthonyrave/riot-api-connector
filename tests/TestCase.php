<?php

namespace Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithConsole;
    use RefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [
            'RiotApiConnector\RiotApiConnectorServiceProvider',
        ];
    }
}
